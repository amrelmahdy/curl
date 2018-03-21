<?php

class Curl{
    // curl get request
    public function getRequest()
    {
        $url = 'https://tracking-56b2f.firebaseio.com/Users.json?' . http_build_query([
                'print' => 'pretty',
            ]);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        return $response;
    }


// post curl request
    public function postRequest()
    {
        $data = '{"userId" : 13,
                  "userLat" : 30.0521266,
                  "userLng" : 31.35061 }';

        $url = "https://tracking-56b2f.firebaseio.com/Users.json";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/plain'));
        $jsonResponse = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Curl error: ' . curl_error($ch);
        }
        curl_close($ch);


        // further processing ....
        if ($jsonResponse == "OK") {
            return "true";
        } else {
            return $jsonResponse;
        }


    }



    public function push_notification($tite, $body, $action, $notification, $tokens){
        #prep the bundle
        $msg = array
        (
            'body' 	            => $body,
            'title'	            => $tite,
            'action' 	        => $action,
            'notification_id'	=> $notification->id,
            'vibrate'	=> 1,
            'sound' => 1,
            'largeIcon'	=> 'large_icon',
            'smallIcon'	=> 'small_icon'
        );


        $fields = array
        (
            'registration_ids'		=> $tokens,
            //'to' => 'fertrr5AzuA:APA91bEr8m5T4aezVfiABDAoaRKZSFoNTODOlM3u7irYj2ZroIwRPIYu2RsPMLimTCSo7WyUUxoKx0q8jiDJdnL_AMZSk_WT-fA8hg0TgngO5bJQkmQ3N4mkHxLGKneEX_DWh-exmwRe',
            'notification'	=> $msg,
            'data'	=> $msg
        );

        $headers = array
        (
            'Authorization: key=' . API_ACCESS_KEY,
            'Content-Type: application/json'
        );
        #Send Reponse To FireBase Server
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch );
        curl_close( $ch );
        return $result;
    }

}

