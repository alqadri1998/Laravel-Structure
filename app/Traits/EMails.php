<?php

namespace App\Traits;

use Swift_TransportException;

trait EMails {
    
    public function sendMail($data, $view, $subject, $replyTo = 'info@sdtyres.com', $from = 'info@sdtyres.com',$attachment=null) {

        try {
            \Mail::send($view, $data, function($message) use ($data, $subject, $replyTo, $from,$attachment) {
                $message->getHeaders()->addTextHeader('Reply-To', config('settings.email'));
                $message->getHeaders()->addTextHeader('Return-Path', config('settings.email'));
                $message->to($data['receiver_email'], $data['receiver_name']);
                $message->subject($subject);
                $message->from(config('settings.email'), config('settings.company_name'));
                $message->sender(config('settings.email'), $data['sender_name']);
                if (!empty($attachment)) {
                    $message->attach($attachment);
                }
            });
            return "Success";
        } catch (Swift_TransportException $ex) {
            return redirect()->back()->with('err','Something went wrong. If you do not get an email, contact the admin.');
        }

    }
    
}