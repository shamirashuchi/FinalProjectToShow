<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Ivy Streams</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('main.css') }}">

    <script src="https://download.agora.io/sdk/release/AgoraRTC_N.js"></script>
    <!-- For build message -->
    <!-- <script src="https://cdn.agora.com/sdk/javascript/agora-rtm.2.1.1.js"></script> -->
    <script src="{{ asset('js/agora-rtm.js') }}"></script>
    <style>
          /* Popup styles */
          .chat-popup {
            display: none; /* Initially hidden */
            position: fixed;
            bottom: 200px;
            right: 20px;
            border: 2px solid #ccc;
            border-radius: 10px;
            width: 300px;
            background-color: #f9f9f9;
            box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.3);
            z-index: 1000;
        }

        .chat-popup-header {
            padding: 10px;
            background-color: #007bff;
            color: white;
            border-radius: 10px 10px 0 0;
            font-size: 16px;
            text-align: center;
        }

        .chat-popup-body {
            padding: 10px;
        }

        .chat-popup-footer {
            padding: 10px;
            border-top: 1px solid #ccc;
            display: flex;
            gap: 10px;
        }

        .chat-popup-footer input {
            flex: 1;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .chat-popup-footer button {
            padding: 8px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .chat-popup-footer button:hover {
            background-color: #0056b3;
        }

        #close-chat {
            position: absolute;
            top: 5px;
            right: 10px;
            cursor: pointer;
            color: white;
            font-weight: bold;
        }
    </style>
     <!-- For build message -->
</head>
<body>
    <button id="join-btn">Join Stream</button>
            <div id="stream-wrapper" >
                <div id="video-streams"></div>

                <div id="stream-controls" style="display:none;">
                    <button id="leave-btn">Leave Stream</button>
                    <button id="mic-btn">Mic On</button>
                    <button id="camera-btn">Camera On</button>
                    <button id="open-chat">Open Chat</button>
                                    <div class="chat-popup" id="chat-popup">
                        <div class="chat-popup-header">
                            Chat
                            <span id="close-chat">×</span>
                        </div>
                        <div class="chat-popup-body" id="messages">
                            <!-- Messages will appear here -->
                        </div>
                        <div class="chat-popup-footer">
                            <input type="text" id="message" placeholder="Type your message..." />
                            <button id="send-message">Send</button>
                        </div>
                    </div>
                </div>
            </div>
    
             <!-- For build message -->
    <script>
        // credentials
        const APP_ID = "7ba05910998743e281f6138b7a72405c";
        const CHANNEL = @json($channelName);
        const TOKEN = @json(Session::get('rtcToken'));
        console.log("Token received from server:", TOKEN);
        const uid = @json($uid);


        // video call
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
      



        // For build message
        const openChatButton = document.getElementById('open-chat');
        const chatPopup = document.getElementById('chat-popup');
        const closeChatButton = document.getElementById('close-chat');
        const sendMessageButton = document.getElementById('send-message');
        const messageInput = document.getElementById('message');
        const messagesDiv = document.getElementById('messages');



        let initAgoraRTM = async () =>{
            let client = await AgoraRTM.createInstance(APP_ID)
            await client.login({uid,TOKEN})

            const channel = await client.createChannel(CHANNEL)
            await channel.join()

            console.log('Joined channel:', CHANNEL);

            // Listen for incoming messages
            channel.on('ChannelMessage', (message, memberId) => {
                const messageElement = document.createElement('div');
                messageElement.textContent = `${memberId}: ${message.text}`;
                messagesDiv.appendChild(messageElement);
                messagesDiv.scrollTop = messagesDiv.scrollHeight; // Scroll to latest message
            });
        }



            // chat pop up appear and close
        openChatButton.addEventListener('click', () => {
            chatPopup.style.display = 'block';
        });

        closeChatButton.addEventListener('click', () => {
            chatPopup.style.display = 'none';
        });

        // Send Message
        sendMessageButton.addEventListener('click', async () => {
            const message = messageInput.value.trim();
            if (message) {
                await channel.sendMessage({ text: message });
                const messageElement = document.createElement('div');
                messageElement.textContent = `You: ${message}`;
                messagesDiv.appendChild(messageElement);
                messageInput.value = ''; // Clear the input
                messagesDiv.scrollTop = messagesDiv.scrollHeight; // Scroll to latest message
            }
        });


         // Send message to the server
         fetch('/chat-message', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Laravel CSRF token
            },
            body: JSON.stringify({
                channel_name: CHANNEL,  // This is the channel name
                sender_id: uid,          // Sender's unique ID
                receiver_id: RECEIVER_ID,    // Receiver's unique ID (optional)
                superadmin_id: SUPERADMIN_ID, // Superadmin ID (optional)
                message: message,            // The message content
                event_id: EVENT_ID,          // Event ID (optional)
                schedule_start_time: START_TIME, // Start time (optional)
                schedule_end_time: END_TIME   // End time (optional)
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Message saved to database!');
            } else {
                console.error('Error saving message:', data);
            }
        })
        .catch(error => console.error('Fetch error:', error));

        // Clear the input
        messageInput.value = '';
    


            // Start RTM Client
            initAgoraRTM().catch(console.error);


        document.getElementById('join-btn').addEventListener('click', joinStream);
        document.getElementById('leave-btn').addEventListener('click', leaveAndRemoveLocalStream);
        document.getElementById('mic-btn').addEventListener('click', toggleMic);
        document.getElementById('camera-btn').addEventListener('click', toggleCamera);
    </script>
</body>
</html>
