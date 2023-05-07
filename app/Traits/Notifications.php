<?php

namespace App\Traits;

use App\Models\Notification;

trait Notifications {
    public function sendNotification($userId, $companyId, $title='title', $description='message', $eventType='message', $sender, $isRead = 0, $url='', $extras='')
    {
        Notification::create([
            'user_id' => $userId,
            'company_id' => $companyId,
            'title' => $title,
            'description' => $description,
            'event_type' => $eventType,
            'sender' => $sender,
            'url' => $url,
            'is_read' => $isRead,
            'extras' => $extras
        ]);
    }
}