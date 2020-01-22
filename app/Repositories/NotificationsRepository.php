<?php
/**
 * Created by PhpStorm.
 * user: nomantufail
 * Date: 10/10/2016
 * Time: 10:13 AM
 */

namespace App\Repositories;

use App\Event;
use App\Notification;
use App\Uni;
use App\User;
use Illuminate\Support\Facades\DB;

class NotificationsRepository extends Repository
{
    public function __construct(Notification $notification)
    {
        $this->setModel($notification);
    }

}
