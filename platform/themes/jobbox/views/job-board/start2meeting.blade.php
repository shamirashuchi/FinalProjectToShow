<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Ivy Streams</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="{{ asset('main.css') }}">

    <script src="https://download.agora.io/sdk/release/AgoraRTC_N.js"></script>
</head>
<body>
    <button id="join-btn">Join Stream</button>

    <div id="stream-wrapper">
        <div id="video-streams"></div>

        <div id="stream-controls" style="display:none;">
            <button id="leave-btn">Leave Stream</button>
            <button id="mic-btn">Mic On</button>
            <button id="camera-btn">Camera On</button>
        </div>
    </div>

    <script>
        const APP_ID = "7ba05910998743e281f6138b7a72405c";
        
        // const TOKEN = "007eJxTYDCc46QnF7j14+Ev22UW9l+Wmb3Odd6hd9GvSw6I3b8m8e+RAoN5UqKBqaWhgaWlhbmJcaqRhWGamaGxRZJ5ormRiYFp8oN2y/SGQEYGsXOJrIwMEAjiczGU+5aWB7qZV4SlMDAAAJ90IuA=";
        const CHANNEL = @json($channelName);
        // const TOKEN = @json($token);
        // Access the token from the session
        const TOKEN = @json(Session::get('rtcToken'));

        console.log("Token received from server:", TOKEN);

        const uid = @json($uid);  // UID is passed correctly
        const client = AgoraRTC.createClient({ mode: 'rtc', codec: 'vp8' });

        let localTracks = [];
        let remoteUsers = {};

        // Ensure proper error handling when joining the stream
        let joinAndDisplayLocalStream = async () => {
            let UID;
            // Listen for users joining or leaving
            client.on('user-published', handleUserJoined);
            client.on('user-left', handleUserLeft);
            if(!TOKEN){
                console.error("Failed to join due to token:", error);
            }

            // Join the channel
            try {
                let UID = await client.join(APP_ID, CHANNEL, TOKEN, uid);  // Join the channel
                console.log("Joined successfully with UID:", UID);

                // Create local tracks for audio and video
                localTracks = await AgoraRTC.createMicrophoneAndCameraTracks();
                console.log("Audio track details:", localTracks[0]);
            } catch (error) {
                console.error("Failed to join channel:", error);
                return; // Exit if we can't join
            }

            // Create player container for local stream
            let player = `<div class="video-container" id="user-container-${UID}">
                                <div class="video-player" id="user-${UID}"></div>
                          </div>`;
            document.getElementById('video-streams').insertAdjacentHTML('beforeend', player);
            
            // Play the local stream
            localTracks[1].play(`user-${UID}`);

            try {
                await client.publish([localTracks[0], localTracks[1]]);  // Publish local tracks
                console.log("Local tracks published successfully");
            } catch (error) {
                console.error("Failed to publish local tracks:", error);
            }
        };

        let joinStream = async () => {
            try {
                await joinAndDisplayLocalStream();
                document.getElementById('join-btn').style.display = 'none';
                document.getElementById('stream-controls').style.display = 'flex';
            } catch (error) {
                console.error('Failed to join stream:', error);
                alert('Error joining the stream. Please try again.');
            }
        };

        let handleUserJoined = async (user, mediaType) => {
            remoteUsers[user.uid] = user;
            try {
                await client.subscribe(user, mediaType);
                console.log(`Subscribed to user ${user.uid}'s ${mediaType} track`);
            } catch (error) {
                console.error(`Failed to subscribe to user ${user.uid}:`, error);
                return;
            }

            // Handle video track
            if (mediaType === 'video') {
                let player = document.getElementById(`user-container-${user.uid}`);
                if (player != null) {
                    player.remove();
                }

                player = `<div class="video-container" id="user-container-${user.uid}">
                                <div class="video-player" id="user-${user.uid}"></div> 
                          </div>`;
                document.getElementById('video-streams').insertAdjacentHTML('beforeend', player);

                user.videoTrack.play(`user-${user.uid}`);
            }

            // Handle audio track
            if (mediaType === 'audio') {
                user.audioTrack.play();
            }
        };

        let handleUserLeft = async (user) => {
            delete remoteUsers[user.uid];
            document.getElementById(`user-container-${user.uid}`).remove();
        };

        let leaveAndRemoveLocalStream = async () => {
            for (let i = 0; i < localTracks.length; i++) {
                localTracks[i].stop();
                localTracks[i].close();
            }

            await client.leave();
            document.getElementById('join-btn').style.display = 'block';
            document.getElementById('stream-controls').style.display = 'none';
            document.getElementById('video-streams').innerHTML = '';
        };

        let toggleMic = async (e) => {
            if (localTracks[0].muted) {
                await localTracks[0].setMuted(false);
                e.target.innerText = 'Mic On';
                e.target.style.backgroundColor = 'cadetblue';
            } else {
                await localTracks[0].setMuted(true);
                e.target.innerText = 'Mic Off';
                e.target.style.backgroundColor = '#EE4B2B';
            }
        };

        let toggleCamera = async (e) => {
            if (localTracks[1].muted) {
                await localTracks[1].setMuted(false);
                e.target.innerText = 'Camera On';
                e.target.style.backgroundColor = 'cadetblue';
            } else {
                await localTracks[1].setMuted(true);
                e.target.innerText = 'Camera Off';
                e.target.style.backgroundColor = '#EE4B2B';
            }
        };

        document.getElementById('join-btn').addEventListener('click', joinStream);
        document.getElementById('leave-btn').addEventListener('click', leaveAndRemoveLocalStream);
        document.getElementById('mic-btn').addEventListener('click', toggleMic);
        document.getElementById('camera-btn').addEventListener('click', toggleCamera);
    </script>
</body>
</html>
