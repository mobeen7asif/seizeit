<?php
/**
 * Created by PhpStorm.
 * user: nomantufail
 * Date: 10/10/2016
 * Time: 10:13 AM
 */

namespace App\Repositories;

use App\Event;
use App\Uni;
use App\User;
use Illuminate\Support\Facades\DB;

class EventsRepository extends Repository
{
    public function __construct(Event $event)
    {
        $this->setModel($event);
    }

    public function getByIds($ids = [])
    {
        return  $this->getModel()->whereIn('id', $ids)->get();
    }
    public function getEvents($event_id){
        return $this->getModel()->where('id',$event_id)->with('sessions')->get();
    }
    public function getEventDetails($number = 0){
        return $this->getModel()->with('sessions','sessions.sessionSpeakers')->with('sessions.sessionSpeakers.speaker')
            ->skip($number*5)
            ->take(5)
            ->get();
    }
}
