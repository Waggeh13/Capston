document.addEventListener('DOMContentLoaded', function() {
    let notificationIntervals = new Map(); // Store interval timers

    // Request notification permission
    async function requestNotificationPermission() {
        if (Notification.permission === 'granted') return true;
        const permission = await Notification.requestPermission();
        return permission === 'granted';
    }

    // Show a notification via service worker
    function showNotification(title, options) {
        navigator.serviceWorker.ready.then(registration => {
            registration.showNotification(title, options);
            console.log('Notification sent to service worker:', title, options);
        });
    }

    // Handle checkbox changes
    const reminderCheckboxes = document.querySelectorAll('.alert-toggle input');
    reminderCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', async function() {
            const medicationId = this.dataset.medicationId;
            const patientId = this.dataset.patientId;
            const enabled = this.checked ? 'Yes' : 'No';

            if (this.checked) {
                const granted = await requestNotificationPermission();
                if (!granted) {
                    alert('Notification permission denied.');
                    this.checked = false;
                    return;
                }
            }

            fetch('../actions/prescription_notification_actions.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `action=save_preference&medication_id=${medicationId}&patient_id=${patientId}&enabled=${enabled}`
            })
            .then(response => {
                if (!response.ok) {
                    return response.text().then(text => {
                        throw new Error(`HTTP ${response.status}: ${text}`);
                    });
                }
                return response.json();
            })
            .then(data => {
                if (!data.success) {
                    alert(data.message);
                    this.checked = !this.checked;
                } else if (enabled === 'Yes') {
                    scheduleNotifications(medicationId, patientId);
                } else {
                    if (notificationIntervals.has(medicationId)) {
                        clearInterval(notificationIntervals.get(medicationId));
                        notificationIntervals.delete(medicationId);
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert(`Failed to save notification preference: ${error.message}`);
                this.checked = !this.checked;
            });
        });
    });

    // Handle medication card clicks
    const medicationCards = document.querySelectorAll('.medication-card');
    medicationCards.forEach(card => {
        card.addEventListener('click', function(e) {
            if (e.target.closest('.alert-toggle') || e.target.closest('.modal')) return;
            const checkbox = card.querySelector('.alert-toggle input');
            if (!checkbox.checked) return;
            const medicationId = checkbox.dataset.medicationId;
            const patientId = checkbox.dataset.patientId;
            showNotificationModal(medicationId, patientId);
        });
    });

    // Modal handling
    function showNotificationModal(medicationId, patientId) {
        let modal = document.getElementById('notification-modal');
        if (!modal) {
            modal = document.createElement('div');
            modal.id = 'notification-modal';
            modal.className = 'modal';
            modal.innerHTML = `
                <div class="modal-content">
                    <span class="close">×</span>
                    <h2>Set Notification Times</h2>
                    <form id="notification-form">
                        <label><input type="radio" name="type" value="times" checked> Specific Times</label>
                        <label><input type="radio" name="type" value="interval"> Interval</label>
                        <div id="time-inputs" style="display: block;">
                            <input type="time" name="times[]" required>
                        </div>
                        <div id="interval-input" style="display: none;">
                            <select name="interval_hours">
                                <option value="1">Every 1 hour</option>
                                <option value="2">Every 2 hours</option>
                                <option value="3">Every 3 hours</option>
                                <option value="4">Every 4 hours</option>
                                <option value="6">Every 6 hours</option>
                                <option value="8">Every 8 hours</option>
                                <option value="12">Every 12 hours</option>
                            </select>
                        </div>
                        <button type="button" id="add-time">Add Another Time</button>
                        <div id="existing-times"></div>
                        <button type="submit">Save Times</button>
                    </form>
                </div>
            `;
            document.body.appendChild(modal);
        }

        modal.style.display = 'block';

        // Set min attribute for time inputs
        const now = new Date();
        const minTime = now.toTimeString().slice(0, 5); // HH:MM
        const timeInputs = modal.querySelector('#time-inputs');
        timeInputs.querySelectorAll('input[type="time"]').forEach(input => {
            input.setAttribute('min', minTime);
        });

        // Toggle inputs based on radio selection
        const typeRadios = modal.querySelectorAll('input[name="type"]');
        const intervalInput = modal.querySelector('#interval-input');
        typeRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                timeInputs.style.display = this.value === 'times' ? 'block' : 'none';
                intervalInput.style.display = this.value === 'interval' ? 'block' : 'none';
                timeInputs.querySelectorAll('input').forEach(input => 
                    input.toggleAttribute('required', this.value === 'times'));
            });
        });

        // Load existing times or interval
        fetch('../actions/prescription_notification_actions.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `action=get_settings&medication_id=${medicationId}&patient_id=${patientId}`
        })
        .then(response => {
            if (!response.ok) {
                return response.text().then(text => {
                    throw new Error(`HTTP ${response.status}: ${text}`);
                });
            }
            return response.json();
        })
        .then(data => {
            const existingTimesDiv = modal.querySelector('#existing-times');
            existingTimesDiv.innerHTML = '';
            if (data.settings) {
                data.settings.forEach(setting => {
                    if (setting.interval_hours !== null) {
                        const div = document.createElement('div');
                        div.innerHTML = `Every ${setting.interval_hours} hours <button type="button" class="delete-time" data-notification-id="${setting.notification_id}">Delete</button>`;
                        existingTimesDiv.appendChild(div);
                    } else if (setting.notification_time !== '00:00:00') {
                        const div = document.createElement('div');
                        div.innerHTML = `${setting.notification_time} <button type="button" class="delete-time" data-notification-id="${setting.notification_id}">Delete</button>`;
                        existingTimesDiv.appendChild(div);
                    }
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert(`Failed to load notification settings: ${error.message}`);
        });

        // Close modal
        modal.querySelector('.close').onclick = () => modal.style.display = 'none';
        window.onclick = event => {
            if (event.target == modal) modal.style.display = 'none';
        };

        // Add another time input
        modal.querySelector('#add-time').onclick = () => {
            const newInput = document.createElement('input');
            newInput.type = 'time';
            newInput.name = 'times[]';
            newInput.required = true;
            newInput.setAttribute('min', minTime);
            timeInputs.appendChild(newInput);
        };

        // Handle form submission
        modal.querySelector('#notification-form').onsubmit = function(e) {
            e.preventDefault();
            const type = this.querySelector('input[name="type"]:checked').value;
            let payload = { type, timezone: Intl.DateTimeFormat().resolvedOptions().timeZone };

            if (type === 'times') {
                const times = Array.from(this.querySelectorAll('input[name="times[]"]'))
                                 .map(input => input.value)
                                 .filter(time => time);
                if (times.length === 0) {
                    alert('Please add at least one time.');
                    return;
                }
                payload.times = times;
            } else {
                const interval = this.querySelector('select[name="interval_hours"]').value;
                payload.interval_hours = interval;
            }

            fetch('../actions/prescription_notification_actions.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `action=save_times&medication_id=${medicationId}&patient_id=${patientId}&data=${encodeURIComponent(JSON.stringify(payload))}`
            })
            .then(response => {
                if (!response.ok) {
                    return response.text().then(text => {
                        throw new Error(`HTTP ${response.status}: ${text}`);
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    modal.style.display = 'none';
                    scheduleNotifications(medicationId, patientId);
                    location.reload();
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert(`Failed to save notification times: ${error.message}`);
            });
        };

        // Handle delete time
        modal.querySelector('#existing-times').addEventListener('click', function(e) {
            if (e.target.classList.contains('delete-time')) {
                const notificationId = e.target.dataset.notificationId;
                fetch('../actions/prescription_notification_actions.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `action=delete_time¬ification_id=${notificationId}`
                })
                .then(response => {
                    if (!response.ok) {
                        return response.text().then(text => {
                            throw new Error(`HTTP ${response.status}: ${text}`);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        e.target.parentElement.remove();
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert(`Failed to delete notification time: ${error.message}`);
                });
            }
        });
    }

    // Schedule notifications
    function scheduleNotifications(medicationId, patientId) {
        fetch('../actions/prescription_notification_actions.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `action=get_settings&medication_id=${medicationId}&patient_id=${patientId}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.settings) {
                // Clear existing interval
                if (notificationIntervals.has(medicationId)) {
                    clearInterval(notificationIntervals.get(medicationId));
                    notificationIntervals.delete(medicationId);
                }

                data.settings.forEach(setting => {
                    if (setting.interval_hours !== null) {
                        // Interval notification
                        const intervalMs = setting.interval_hours * 60 * 60 * 1000;
                        const intervalId = setInterval(() => {
                            showNotification('Medication Reminder', {
                                body: `Time to take your medication (ID: ${medicationId})`,
                                vibrate: [200, 100, 200]
                            });
                        }, intervalMs);
                        notificationIntervals.set(medicationId, intervalId);
                        // Immediate notification to confirm
                        showNotification('Medication Reminder', {
                            body: `Medication (ID: ${medicationId}) set to notify every ${setting.interval_hours} hours`,
                            vibrate: [200, 100, 200]
                        });
                    } else if (setting.notification_time !== '00:00:00') {
                        // Specific time notification
                        const [hours, minutes] = setting.notification_time.split(':');
                        const now = new Date();
                        let notificationTime = new Date(now.getFullYear(), now.getMonth(), now.getDate(), hours, minutes);
                        if (notificationTime <= now) {
                            notificationTime.setDate(notificationTime.getDate() + 1);
                        }
                        const delay = notificationTime.getTime() - now.getTime();
                        if (delay > 0) {
                            console.log(`Scheduling notification for ${setting.notification_time} (ID: ${setting.notification_id}) in ${delay}ms`);
                            setTimeout(() => {
                                showNotification('Medication Reminder', {
                                    body: `Time to take your medication (ID: ${medicationId})`,
                                    vibrate: [200, 100, 200],
                                    data: { notificationId: setting.notification_id }
                                });
                                // Delete notification after triggering
                                fetch('../actions/prescription_notification_actions.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/x-www-form-urlencoded'
                                    },
                                    body: `action=delete_time¬ification_id=${setting.notification_id}`
                                }).then(response => response.json()).then(data => {
                                    if (!data.success) {
                                        console.error('Failed to delete notification:', data.message);
                                    }
                                });
                            }, delay);
                        }
                    }
                });
            }
        })
        .catch(error => {
            console.error('Error scheduling notifications:', error);
        });
    }

    // Initialize notifications for enabled checkboxes
    reminderCheckboxes.forEach(checkbox => {
        if (checkbox.checked) {
            scheduleNotifications(checkbox.dataset.medicationId, checkbox.dataset.patientId);
        }
    });
});