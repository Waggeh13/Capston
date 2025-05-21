document.addEventListener('DOMContentLoaded', function() {
    const consultationList = document.getElementById('consultationList');
    const upcomingConsultations = document.getElementById('upcomingConsultations');
    const endMeetingArea = document.getElementById('endMeetingArea');
    const endMeetingBtn = document.getElementById('endMeetingBtn');
    const browserWarning = document.getElementById('browserWarning');
    let currentBookingId = null;
    let isMeetingActive = false;
    let zoomWindow = null;

    function checkBrowserCompatibility() {
        const ua = navigator.userAgent.toLowerCase();
        const isChrome = ua.includes('chrome') && !ua.includes('edge');
        const isFirefox = ua.includes('firefox');
        const isEdge = ua.includes('edg/');
        if (!isChrome && !isFirefox && !isEdge) {
            browserWarning.style.display = 'block';
        }
    }

    checkBrowserCompatibility();
    loadAppointments();

    async function loadAppointments() {
        try {
            console.log('Fetching appointments...');
            const response = await fetch('../actions/telemedicine_action.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'action=get_appointments'
            });

            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }

            const data = await response.json();
            console.log('Appointments data:', data);

            consultationList.innerHTML = '';
            if (data.success && data.appointments && data.appointments.length > 0) {
                data.appointments.forEach(apt => {
                    const dateTime = new Date(apt.start_time).toLocaleString();
                    const card = document.createElement('div');
                    card.className = 'consultation-card';
                    card.innerHTML = `
                        <div class="patient-info">
                            <div class="patient-avatar"><i class="fas fa-user"></i></div>
                            <div><h3>${apt.doctor_name}</h3><p>ID: ${apt.booking_id} | ${dateTime} | Status: ${apt.status}</p></div>
                        </div>
                        <div class="consultation-actions">
                            <button class="btn start-consultation" data-booking-id="${apt.booking_id}" 
                                    ${apt.status !== 'Scheduled' && apt.status !== 'InProgress' ? 'disabled' : ''}>
                                <i class="fas fa-video"></i> ${apt.status === 'InProgress' ? 'Rejoin Consultation' : 'Start Consultation'}
                            </button>
                        </div>
                    `;
                    consultationList.appendChild(card);
                });
                bindStartButtons();
            } else {
                consultationList.innerHTML = `
                    <div style="text-align: center; padding: 20px;">
                        ${data.message || 'No upcoming virtual consultations found'}
                    </div>
                `;
            }
        } catch (error) {
            console.error('Error loading appointments:', error);
            consultationList.innerHTML = `
                <div style="text-align: center; padding: 20px; color: red;">
                    Error loading consultations: ${error.message}
                </div>
            `;
        }
    }

    function bindStartButtons() {
        const startButtons = document.querySelectorAll('.start-consultation');
        console.log(`Found ${startButtons.length} start consultation buttons`);

        startButtons.forEach(button => {
            button.addEventListener('click', async function(event) {
                event.preventDefault();
                const bookingId = this.getAttribute('data-booking-id');
                console.log(`Starting or rejoining consultation for booking ID: ${bookingId}`);
                await startConsultation(bookingId);
            });
        });
    }

    async function startConsultation(bookingId) {
        try {
            console.log('Initiating startConsultation...');
            const response = await fetch('../actions/telemedicine_action.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `action=start_meeting&booking_id=${encodeURIComponent(bookingId)}`
            });
            const data = await response.json();
            console.log('Start meeting response:', data);

            if (!data.success) {
                throw new Error(data.message || 'Failed to start consultation');
            }

            currentBookingId = bookingId;
            upcomingConsultations.style.display = 'none';
            endMeetingArea.style.display = 'block';

            const meeting = data.meeting;
            const uniqueId = Date.now();
            const username = `Patient_${uniqueId}`;
            const webClientUrl = `https://zoom.us/wc/join/${meeting.meeting_id}?uname=${encodeURIComponent(username)}&pwd=${encodeURIComponent(meeting.password)}`;

            zoomWindow = window.open(webClientUrl, 'ZoomMeeting', 'width=1000,height=600');
            if (!zoomWindow) {
                throw new Error('Failed to open Zoom meeting window. Please allow pop-ups for this site.');
            }

            isMeetingActive = true;

            await fetch('../actions/telemedicine_action.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `action=mark_in_progress&booking_id=${encodeURIComponent(bookingId)}`
            });

            const checkWindowClosed = setInterval(async () => {
                if (zoomWindow.closed) {
                    clearInterval(checkWindowClosed);
                    if (isMeetingActive) {
                        await fetch('../actions/telemedicine_action.php', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                            body: `action=start_timer&booking_id=${encodeURIComponent(bookingId)}`
                        });
                        cleanupMeeting();
                    }
                }
            }, 1000);

            endMeetingBtn.onclick = async () => {
                if (zoomWindow && !zoomWindow.closed) {
                    zoomWindow.close();
                }
            };
        } catch (error) {
            console.error('Start consultation error:', error);
            alert(error.message || 'Error starting consultation');
            upcomingConsultations.style.display = 'block';
            endMeetingArea.style.display = 'none';
        }
    }

    function cleanupMeeting() {
        upcomingConsultations.style.display = 'block';
        endMeetingArea.style.display = 'none';
        currentBookingId = null;
        isMeetingActive = false;
        zoomWindow = null;
        loadAppointments();
    }
});