<?php


namespace App\Traits;


trait ChatTrait
{
    private function getSenderReceiver($message, $user) {
        $persons = ['sender' => new \stdClass(), 'receiver' => new \stdClass()];
        $persons[(($user->is_saloon==1) ? 'sender':'receiver')] = [
            'id' => $message->conversation->saloon->id,
            'full_name' => $this->translateRelation($message->conversation->saloon, 'saloonTranslations')->title,
            'image' => $message->conversation->saloon->image,
            'is_saloon' => 1,
        ];
        $persons[(($user->is_saloon==0) ? 'sender':'receiver')] = [
            'id' => $message->conversation->user->id,
            'full_name' => $message->conversation->user->full_name,
            'image' => $message->conversation->user->image,
            'is_saloon' => 0,
        ];
        return $persons;
    }
}