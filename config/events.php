<?php

return [
    'events' => ['signup', 'cancel_booking', 'new_booking', 'page_creating', 'page_delete', 'page_edit'],
    'eventData' => [
        'signup' => ['title' => '', 'description' => ''],
        'cancel_booking' => ['title' => '', 'description' => ''],
        'new_booking' => ['title' => '', 'description' => ''],
        'page_creating' => ['title' => 'Page Created', 'description' => 'Page Created Successfully'],
        'page_delete' => ['title' => 'Page Deleted', 'description' => 'Page Deleted Successfully'],
        'page_edit' => ['title' => 'Page Updated', 'description' => 'Page Updated Successfully'],
    ]
];