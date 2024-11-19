<?php

namespace Botble\JobBoard\Http\Controllers\Fronts;
use App\Http\Controllers\Controller;
use App\Salon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Pusher\Pusher;
// use Yasser\Agora\RtcTokenBuilder;
use TaylanUnutmaz\AgoraTokenBuilder\RtcTokenBuilder;
use Theme;
use Session;
use App\Models\Event;
use Botble\JobBoard\Models\MessageSystem;
use App\Models\User_Meeting;
use JobBoardHelper;
class AgoraController extends Controller
{
    public function showVideoCallRoom()
{
    return view('themes.jobbox.views.job-board.startmeeting');
}

//     public function createmeeting(Request $request,$id)
// {
  
//     try {
//           // Retrieve the 'channel' parameter from the JSON body
//           $channel = $request->json('channel');
         
//           if (!$channel) {
//               return response()->json(['error' => 'Channel parameter missing'], 400);
//           }
//         // Logic for creating the meeting
//         $meetingLink = "generated_meeting_link"; // replace with actual meeting link logic
//         $token = "generated_token"; // replace with actual token generation logic

//         return response()->json([
//             'meeting_link' => $meetingLink,
//             'token' => $token
//         ]);
//     } catch (\Exception $e) {
//         return response()->json(['error' => 'Unable to create meeting'], 500);
//     }
// }


public function createMeeting()
{
    
        $name = 'agora'.rand(1111,9999);
        $meetingData = $this->createAgoraProject($name);
  
            $meeting = new User_Meeting();
            $meeting->user_id = auth('account')->user()->id;
            $meeting->app_id = $meetingData->project->vendor_key;
            $meeting->appCertificate = $meetingData->project->sign_key;
            $meeting->channel = $meetingData->project->name;
            $meeting->uid = rand(1111,9999);
            $meeting->save();
    $meeting = Auth::user()->getUserMeetingInfo()->first();
    $token = createToken($meeting->app_id, $meeting->appCertificate, $meeting->channel);
    $meeting->url = generateRandomString();
    $meeting->event = generateRandomString(5);
    $meeting->token = $token;
    $meeting->save();

    // if(Auth::user()->id == $meeting->user_id){
    //     Session::put('meeting',$meeting->url);
    // }
  
    return redirect('joinMeeting/'.$meeting->url);
   
}
public function createAgoraProject($name)
{
    $customerKey = env('customerKey');
    $customerSecret = env('customerSecret');
    $credentials = $customerKey.":".$customerSecret;

    $base64Credentials = base64_encode($credentials);
    $arr_header = "Authorization: Basic ".$base64Credentials;
    $curl = curl_init();
    
    curl_setopt_array($curl,array(
        CURLOPT_URL => 'https://api.agora.io/dev/v1/project',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => '{"name": "'.$name.'","enable_sign_key": true }',
        CURLOPT_HTTPHEADER => array(
            $arr_header,
            'Content-Type: application/json',
        ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    $result = json_decode($response);
    dd($result);
    return $result;
}

    public function getToken(Request $request,$id)
{
    // $appId = env('AGORA_APP_ID');
    // $appCertificate = env('AGORA_APP_CERTIFICATE');
    $appId = "d68157674b73485e8ce461ae2af71003";
    $appCertificate = "4cef74db59ff4244bb14a26dbd62cf47";
    // $channelName = $request->query('channel');
    $channelName = $request->json('channel');
 
    $uid = $request->json('account');
    $expirationTimeInSeconds = 86400;
    $currentTimeStamp = time();
 
    $privilegeExpiredTs = $currentTimeStamp + $expirationTimeInSeconds;
    $role = $request->json('role', 2);
    // $token = RtcTokenBuilder::buildTokenWithUid($appId, $appCertificate, $channelName, $uid,$role,$privilegeExpiredTs);

    // // Notify clients using Pusher
    // $this->notifyClients('video-call-channel', 'client-video-call-started', [
    //     'callLink' => url("/room?channel=$channelName&token=$token"),
    //     'actionValue' => $request->get('reciver_user_id')
    // ]);
    $token = $this->generateAgoraToken($appId, $appCertificate, $channelName, $uid, $role, $privilegeExpiredTs);
   
    $callLink = url("/room?channel=$channelName&token=$token");
    // return response()->json(['token' => $token, 'uid' => $uid]);
    $event = new Event();
        $event->jobseekertoken = $token;
        $event->user_id = $uid;
        $event->consultant_id = $id;
        $event->jobseekermeetlink = $callLink;
        $event->save();
    return response()->json([
        'token' => $token,
        'uid' => $uid,
        'callLink' => $callLink,  // Include call link in the response
        'success' => true,
        'message' => 'Token and call link generated successfully'
    ]);
}

private function generateAgoraToken($appId, $appCertificate, $channelName, $uid, $role, $privilegeExpiredTs)
{
    // Step 1: Set the token expiration timestamp
    $currentTimestamp = time();

    // Step 2: Create a message with the information to encode
    $msg = [
        'appid' => $appId,
        'channel' => $channelName,
        'uid' => $uid,
        'role' => $role,
        'expire' => $privilegeExpiredTs,
    ];

    // Step 3: Build the token signature using HMAC
    $msgJson = json_encode($msg);
    $compressedMsgJson = gzcompress($msgJson);
    // $signature = hash_hmac('sha256', $msgJson, $appCertificate);
    $signature = substr(hash_hmac('sha256', $msgJson, $appCertificate), 0, 16); // Shorten to 16 characters
    // Step 4: Create the token
    $token = base64_encode($compressedMsgJson . '.' . $signature);

    return $token;
}


public function getTokenSalon(Request $request, $salon)
{
    $salonInfo = Salon::where('name', $salon)->first();
    $appId = "d68157674b73485e8ce461ae2af71003";
    $appCertificate = "4cef74db59ff4244bb14a26dbd62cf47";
    $channelName = $salon;
    $uid = Auth::user()->id;
    $expirationTimeInSeconds = 86400;
    $currentTimeStamp = time();
    $privilegeExpiredTs = $currentTimeStamp + $expirationTimeInSeconds;

    $token = RtcTokenBuilder::buildTokenWithUid($appId, $appCertificate, $channelName, $uid, RtcTokenBuilder::RolePublisher, $privilegeExpiredTs);

    // Notify clients using Pusher
    $this->notifyClients('video-call-group-' . $salonInfo->name, 'client-group-video-call-started', [
        'callLink' => url("/room?channel={$salonInfo->id}&token=$token"),
        'actionValue' => $request->get('receiver_user_id')
    ]);

    return response()->json(['token' => $token, 'uid' => $uid]);
}

public function getTheToken($channelname)
{

    $eventId = request()->query('event_id');
    $event = Event::findOrFail($eventId);
    $appId = '7ba05910998743e281f6138b7a72405c';
  
    $appCertificate = 'fde05ab235cb493c9d70c4e96a2e5a2b';
    // $appId = env('AGORA_APP_ID');
  
    // $appCertificate = env('AGORA_APP_CERTIFICATE');
    $channelName = $channelname;
//    dd($channelname);

    if (!$appId || !$appCertificate || !$channelName) {
        // Handle error, perhaps return a message or log the issue
        throw new \Exception("Missing Agora App ID, Certificate, or Channel Name.");
    }
    $uid = auth('account')->user()->id;
    // $uid = 123456;
    // $uid = random_int(1, 2**32 - 1);
    $role = 2;
    
    $expirationTimeInSeconds = 3600;
    $currentTimeStamp = time();
 
    $privilegeExpiredTs = $currentTimeStamp + $expirationTimeInSeconds;
   
    // $token = $this->generateAgoraToken($appId, $appCertificate, $channelName, $uid, $role, $privilegeExpiredTs);
    
    $token = RtcTokenBuilder::buildTokenWithUid($appId, $appCertificate, $channelName, $uid, $role, $privilegeExpiredTs);
    // $token = $this->generateAgoraToken($appId, $appCertificate, $channelName, $uid, $role, $privilegeExpiredTs);
    Session::put('rtcToken', $token);
    return Theme::scope(
        'job-board.start2meeting',
        ['auth' => auth()->user(),
    'token' => $token,
    'channelName' =>$channelName,
    'uid' => $uid,
    'event' => $event,],
        'plugins/job-board::themes.start2meeting'
    )->render();
}



// ==================================For message System============================
public function messageSystem(Request $request)
{
    // Validate the incoming data
    $validated = $request->validate([
        'channel_name' => 'required|string',
        'sender_id' => 'required|string',
        'receiver_id' => 'nullable|string',
        'superadmin_id' => 'nullable|string',
        'message' => 'required|string',
        'event_id' => 'nullable|integer',
        'schedule_start_time' => 'nullable|date',
        'schedule_end_time' => 'nullable|date',
        'flag' => 'nullable|boolean',
    ]);

    // Create the new message record in the database
    $message = MessageSystem::create([
        'channel_name' => $validated['channel_name'],
        'sender_id' => $validated['sender_id'],
        'receiver_id' => $validated['receiver_id'] ?? null,
        'superadmin_id' => $validated['superadmin_id'] ?? null,
        'message' => $validated['message'],
        'event_id' => $validated['event_id'] ?? null,
        'schedule_start_time' => $validated['schedule_start_time'] ?? null,
        'schedule_end_time' => $validated['schedule_end_time'] ?? null,
        'flag' => $validated['flag'] ?? 0,
    ]);

    // Return a success response
    return response()->json(['success' => true, 'message' => $message]);
}


private function notifyClients($channel, $event, $data)
{
    $pusher = new Pusher(
        config('broadcasting.connections.pusher.key'),
        config('broadcasting.connections.pusher.secret'),
        config('broadcasting.connections.pusher.app_id'),
        [
            'cluster' => config('broadcasting.connections.pusher.options.cluster'),
            'useTLS' => false,
        ]
    );

    $pusher->trigger($channel, $event, $data);
}
}
