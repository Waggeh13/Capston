document.addEventListener('DOMContentLoaded', function() {
    // Ensure ZoomMtg is available before proceeding
    if (typeof ZoomMtg === 'undefined') {
        console.error('ZoomMtg is not defined. Zoom SDK script may have failed to load.');
        document.getElementById('consultationList').innerHTML = `
            <div style="text-align: center; padding: 20px; color: red;">
                Error: Unable to load video conferencing service. Please try again later.
            </div>
        `;
        return;
    }

    const consultationList = document.getElementById('consultationList');
    const consultationArea = document.getElementById('consultationArea');
    const zoomMeeting = document.getElementById('zoomMeeting');
    const muteBtn = document.getElementById('muteBtn');
    const videoBtn = document.getElementById('videoBtn');
    const screenShareBtn = document.getElementById('screenShareBtn');
    const endCallBtn = document.getElementById('endCallBtn');
    const saveNotesBtn = document.getElementById('saveNotesBtn');
    const consultationNotes = document.getElementById('consultationNotes');
    let client = null;
    let isMuted = false;
    let isVideoOn = true;
    let currentBookingId = null;
    let isMeetingActive = false;

    // Load appointments
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
                            <div class="patient-avatar">
                                <i class="fas fa-user"></i>
                            </div>
                            <div>
                                <h3>${apt.doctor_name}</h3>
                                <p>ID: ${apt.booking_id} | ${dateTime}</p>
                            </div>
                        </div>
                        <div class="consultation-actions">
                            <button class="btn start-consultation" data-booking-id="${apt.booking_id}" 
                                    ${apt.status !== 'Scheduled' ? 'disabled' : ''}>
                                <i class="fas fa-video"></i> Start Consultation
                            </button>
                        </div>
                    `;
                    console.log(`Button status for booking ${apt.booking_id}: ${apt.status !== 'Scheduled' ? 'disabled' : 'enabled'}`);
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

        if (startButtons.length === 0) {
            console.warn('No start consultation buttons found in the DOM');
        }

        startButtons.forEach(button => {
            button.addEventListener('click', async function(event) {
                event.preventDefault();
                console.log('Start consultation button clicked');
                const bookingId = this.getAttribute('data-booking-id');
                console.log(`Starting consultation for booking ID: ${bookingId}`);
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
            consultationArea.style.display = 'block';
            consultationList.style.display = 'none';
            await initZoomMeeting(data.meeting);
        } catch (error) {
            console.error('Start consultation error:', error);
            alert(error.message || 'Error starting consultation');
            consultationArea.style.display = 'none';
            consultationList.style.display = 'block';
        }
    }

    async function initZoomMeeting(meeting) {
        try {
            // Verify that zoomMeeting element exists
            if (!zoomMeeting) {
                throw new Error('Zoom meeting container not found in the DOM');
            }

            ZoomMtg.setZoomJSLib('https://source.zoom.us/3.12.0/lib', '/av');
            ZoomMtg.preLoadWasm();
            ZoomMtg.prepareWebSDK();

            const meetingConfig = {
                sdkKey: meeting.sdk_key,
                meetingNumber: meeting.meeting_id,
                password: meeting.password,
                userName: 'Patient',
                userEmail: '',
                leaveUrl: window.location.href,
                signature: meeting.signature,
                role: 0
            };

            await ZoomMtg.init({
                leaveUrl: meetingConfig.leaveUrl,
                success: async () => {
                    try {
                        await ZoomMtg.join({
                            signature: meetingConfig.signature,
                            sdkKey: meetingConfig.sdk_key,
                            meetingNumber: meetingConfig.meetingNumber,
                            passWord: meetingConfig.password,
                            userName: meetingConfig.userName,
                            userEmail: meetingConfig.userEmail,
                            success: () => {
                                client = ZoomMtg;
                                isMeetingActive = true;
                                setupMeetingControls();
                            },
                            error: (error) => {
                                throw new Error('Failed to join meeting: ' + error.message);
                            }
                        });
                    } catch (joinError) {
                        throw joinError;
                    }
                },
                error: (error) => {
                    throw new Error('Failed to initialize meeting: ' + error.message);
                }
            });
        } catch (error) {
            console.error('Zoom initialization error:', error);
            alert(error.message || 'Error initializing Zoom meeting');
            cleanupMeeting();
        }
    }

    function setupMeetingControls() {
        muteBtn.addEventListener('click', toggleMute);
        videoBtn.addEventListener('click', toggleVideo);
        screenShareBtn.addEventListener('click', toggleScreenShare);
        endCallBtn.addEventListener('click', endMeeting);
        saveNotesBtn.addEventListener('click', saveNotes);
    }

    function toggleMute() {
        if (!isMeetingActive || !client) return;
        try {
            if (isMuted) {
                client.unmute();
                muteBtn.innerHTML = '<i class="fas fa-microphone"></i>';
            } else {
                client.mute();
                muteBtn.innerHTML = '<i class="fas fa-microphone-slash"></i>';
            }
            isMuted = !isMuted;
        } catch (error) {
            console.error('Toggle mute error:', error);
            alert('Error toggling mute');
        }
    }

    function toggleVideo() {
        if (!isMeetingActive || !client) return;
        try {
            if (isVideoOn) {
                client.stopVideo();
                videoBtn.innerHTML = '<i class="fas fa-video-slash"></i>';
            } else {
                client.startVideo();
                videoBtn.innerHTML = '<i class="fas fa-video"></i>';
            }
            isVideoOn = !isVideoOn;
        } catch (error) {
            console.error('Toggle video error:', error);
            alert('Error toggling video');
        }
    }

    function toggleScreenShare() {
        if (!isMeetingActive || !client) return;
        try {
            client.startScreenShare({
                success: () => {
                    screenShareBtn.innerHTML = '<i class="fas fa-desktop"></i> Stop Sharing';
                },
                error: () => {
                    client.stopScreenShare();
                    screenShareBtn.innerHTML = '<i class="fas fa-desktop"></i>';
                }
            });
        } catch (error) {
            console.error('Toggle screen share error:', error);
            alert('Error toggling screen share');
        }
    }

    async function saveNotes() {
        if (!currentBookingId || !isMeetingActive) {
            alert('No active meeting to save notes for');
            return;
        }
        
        try {
            const notes = consultationNotes.value.trim();
            if (!notes) {
                alert('Notes cannot be empty');
                return;
            }

            const response = await fetch('../actions/telemedicine_action.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `action=save_notes&booking_id=${encodeURIComponent(currentBookingId)}¬es=${encodeURIComponent(notes)}`
            });
            const data = await response.json();
            if (data.success) {
                alert(data.message);
            } else {
                throw new Error(data.message || 'Failed to save notes');
            }
        } catch (error) {
            console.error('Save notes error:', error);
            alert(error.message || 'Error saving notes');
        }
    }

    async function endMeeting() {
        if (!isMeetingActive || !client || !currentBookingId) {
            alert('No active meeting to end');
            return;
        }

        try {
            const response = await fetch('../actions/telemedicine_action.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `action=end_meeting&booking_id=${encodeURIComponent(currentBookingId)}`
            });
            const data = await response.json();
            if (!data.success) {
                throw new Error(data.message || 'Failed to end meeting');
            }

            await client.leaveMeeting({
                success: () => {
                    cleanupMeeting();
                    alert(data.message);
                },
                error: (error) => {
                    throw new Error('Failed to leave meeting: ' + error.message);
                }
            });
        } catch (error) {
            console.error('End meeting error:', error);
            alert(error.message || 'Error ending meeting');
            cleanupMeeting();
        }
    }

    function cleanupMeeting() {
        consultationArea.style.display = 'none';
        consultationList.style.display = 'block';
        consultationNotes.value = '';
        client = null;
        currentBookingId = null;
        isMeetingActive = false;
        isMuted = false;
        isVideoOn = true;
        muteBtn.innerHTML = '<i class="fas fa-microphone"></i>';
        videoBtn.innerHTML = '<i class="fas fa-video"></i>';
        screenShareBtn.innerHTML = '<i class="fas fa-desktop"></i>';
        zoomMeeting.innerHTML = '';
        loadAppointments();
    }
});