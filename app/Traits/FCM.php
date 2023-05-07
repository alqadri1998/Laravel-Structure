<?php

namespace App\Traits;

trait FCM {

    public function pushFCMNotification($fields) {

        $headers = array(
            env('FCM_URL'),
            'Content-Type: application/json',
            'Authorization: key=' . env('FCM_SERVER_KEY')
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, env('FCM_URL'));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        logger('=========FCM RESULT============', [$result]);
        curl_close($ch);
        if ($result === FALSE) {
            return 0;
        }
        $res = json_decode($result);
        logger('=========FCM============', [$res]);
        if (isset($res->success)) {
            return $res->success;
        } else {
            return 0;
        }
    }

}
