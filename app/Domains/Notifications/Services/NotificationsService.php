<?php

namespace App\Domains\Notifications\Services;

use App\Domains\Notifications\Models\CactusNotification;
use App\Domains\Notifications\Models\EmailNotification;
use App\Domains\Notifications\Models\Recipient;
use Exception;

class NotificationsService
{
    public function __construct()
    {

    }

    public function send(CactusNotification $cactusNotification): bool
    {
        $notifications = $cactusNotification->get();

        foreach($notifications as $notification){
            if ($notification instanceof EmailNotification) {
                try {
                    $notification->prepare();
                    $response = $notification->send();
                } catch (Exception $e) {
                    \Log::error('Notification exception: '. $e->getMessage());
                }
            }
        }

        return true;
    }

}
