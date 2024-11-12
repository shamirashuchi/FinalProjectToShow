<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Call Room</title>
    <script src="https://download.agora.io/sdk/release/AgoraRTC_N-4.17.0.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Add Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        /* Styling for the video call container */
        #video-call-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 20px auto;
            max-width: 90%;
            background-color: #2c2f33;
            border-radius: 12px;
            padding: 15px;
        }

        /* Video streams container */
        #video-streams {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            justify-content: center;
            margin-bottom: 20px;
            background-color: #23272a;
            border-radius: 8px;
            padding: 10px;
            width: 100%;
        }

        .video-frame {
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: #2f3136;
            border: 2px solid #7289da;
            border-radius: 8px;
            padding: 5px;
            width: 300px;
            height: 200px;
            position: relative;
            overflow: hidden;
        }

        .video-frame p {
            position: absolute;
            top: 5px;
            left: 5px;
            color: #fff;
            font-size: 14px;
            margin: 0;
        }

        video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 6px;
        }

        /* Controls container */
        #controls {
            display: flex;
            gap: 15px;
            justify-content: center;
        }

        .control-btn {
            background-color: #7289da;
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 10px 15px;
            font-size: 16px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
            transition: background-color 0.3s;
        }

        .control-btn:hover {
            background-color: #5a6cae;
        }

        .leave-btn {
            background-color: #f04747;
        }

        .leave-btn:hover {
            background-color: #d83c3e;
        }
    </style>
</head>
<body>

    <div id="video-call-container">
        <div id="video-streams">
            <!-- Video frames will be inserted dynamically -->
        </div>
        <video id="videoElement" width="640" height="480" autoplay></video>
        <div id="controls">
        
            <button id="openCameraBtn" class="control-btn"><i class="bi bi-camera-video"></i> Camera</button>
            <button id="mic-btn" class="control-btn"><i class="bi bi-mic"></i> Mic</button>
            <button id="leave-btn" class="control-btn leave-btn"><i class="bi bi-box-arrow-right"></i> Leave</button>
            <!-- <button id="openCameraBtn">Open Camera</button> -->
          <!-- camera-btn -->
        </div>
    </div>

    <script>
     const APP_ID = "d68157674b73485e8ce461ae2af71003";

        const TOKEN = sessionStorage.getItem('token');
        const CHANNEL = sessionStorage.getItem('room');
        let UID = sessionStorage.getItem('UID');
        let NAME = sessionStorage.getItem('name');

        const client = AgoraRTC.createClient({ mode: 'rtc', codec: 'vp8' });

        let localTracks = { audioTrack: null, videoTrack: null };
        let remoteUsers = {};

        async function initializeCall() {
            await joinAndDisplayLocalStream();
            setupEventListeners();
        }

        async function joinAndDisplayLocalStream() {
            try {
                UID = await client.join(APP_ID, CHANNEL, TOKEN, UID);
                localTracks.audioTrack = await AgoraRTC.createMicrophoneAudioTrack();
                localTracks.videoTrack = await AgoraRTC.createCameraVideoTrack();
                displayLocalStream();
                await client.publish(Object.values(localTracks));
            } catch (error) {
                console.error('Error joining Agora channel:', error);
            }
        }

        function displayLocalStream() {
            let playerHTML = `
                <div class="video-frame" id="user-container-${UID}">
                    <p>${NAME}</p>
                    <video id="user-${UID}" autoplay muted></video>
                </div>
            `;
            document.getElementById('video-streams').insertAdjacentHTML('beforeend', playerHTML);
            localTracks.videoTrack.play(`user-${UID}`);
        }

        function setupEventListeners() {
            client.on('user-published', handleUserJoined);
            client.on('user-left', handleUserLeft);
            document.getElementById('leave-btn').addEventListener('click', leaveAndRemoveLocalStream);
            document.getElementById('camera-btn').addEventListener('click', toggleCamera);
            document.getElementById('mic-btn').addEventListener('click', toggleMic);
      
        }

        async function handleUserJoined(user, mediaType) {
            remoteUsers[user.uid] = user;
            await client.subscribe(user, mediaType);
            if (mediaType === 'video') {
                displayRemoteStream(user);
            }
            if (mediaType === 'audio') {
                user.audioTrack.play();
            }
        }

        function displayRemoteStream(user) {
            let playerHTML = `
                <div class="video-frame" id="user-container-${user.uid}">
                    <p>Remote User</p>
                    <video id="user-${user.uid}" autoplay></video>
                </div>
            `;
            document.getElementById('video-streams').insertAdjacentHTML('beforeend', playerHTML);
            user.videoTrack.play(`user-${user.uid}`);
        }

        function handleUserLeft(user) {
            delete remoteUsers[user.uid];
            document.getElementById(`user-container-${user.uid}`).remove();
        }

        async function leaveAndRemoveLocalStream() {
            for (let track of Object.values(localTracks)) {
                if (track) {
                    track.stop();
                    track.close();
                }
            }
            await client.leave();
            document.getElementById(`user-container-${UID}`).remove();
        }

        async function toggleCamera(e) {
            if (localTracks.videoTrack) {
                await localTracks.videoTrack.setEnabled(!localTracks.videoTrack.enabled);
                e.target.style.backgroundColor = localTracks.videoTrack.enabled ? '#fff' : 'rgb(255, 80, 80)';
            }
        }

        async function toggleMic(e) {
            if (localTracks.audioTrack) {
                await localTracks.audioTrack.setEnabled(!localTracks.audioTrack.enabled);
                e.target.style.backgroundColor = localTracks.audioTrack.enabled ? '#fff' : 'rgb(255, 80, 80)';
            }
        }

        initializeCall();
        const openCameraBtn = document.getElementById('openCameraBtn');
const videoElement = document.getElementById('videoElement');

// Add event listener to the button to trigger the camera access
// openCameraBtn.addEventListener('click', () => {
//     // Check if the browser supports getUserMedia
//     if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
//         // Request access to the camera (video only)
//         navigator.mediaDevices.getUserMedia({ video: true })
//             .then(stream => {
//                 // Assign the video stream to the video element's srcObject
//                 videoElement.srcObject = stream;
//             })
//             .catch(err => {
//                 console.error('Error accessing the camera: ', err);
//             });
//     } else {
//         alert('Your browser does not support camera access');
//     }
// });
let currentStream = null; // Store the current media stream

// Add event listener to the button to trigger the camera access or stop
openCameraBtn.addEventListener('click', () => {
    // Check if the camera is already running
    if (currentStream) {
        // Stop the video stream
        currentStream.getTracks().forEach(track => track.stop());
        videoElement.srcObject = null; // Stop displaying the video
        currentStream = null; // Clear the current stream
        openCameraBtn.textContent = 'Open Camera'; // Reset button text
    } else {
        // Check if the browser supports getUserMedia
        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            // Request access to the camera (video only)
            navigator.mediaDevices.getUserMedia({ video: true })
                .then(stream => {
                    // Assign the video stream to the video element's srcObject
                    videoElement.srcObject = stream;
                    currentStream = stream; // Store the media stream
                    openCameraBtn.textContent = 'Stop Camera'; // Change button text
                })
                .catch(err => {
                    console.error('Error accessing the camera: ', err);
                });
        } else {
            alert('Your browser does not support camera access');
        }
    }
});
    </script>
</body>
</html>
