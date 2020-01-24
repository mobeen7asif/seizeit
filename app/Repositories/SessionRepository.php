<?php
/**
 * Created by PhpStorm.
 * user: nomantufail
 * Date: 10/10/2016
 * Time: 10:13 AM
 */

namespace App\Repositories;

use App\Models\FranchiseInfo;
use App\Session;
use App\Uni;
use App\Major;
use App\User;
use Illuminate\Support\Facades\DB;

class SessionRepository extends Repository
{
    public function __construct(Session $session)
    {
        $this->setModel($session);
    }

    public function getByIds($ids = [])
    {
        return  $this->getModel()->whereIn('id', $ids)->get();
    }
    public function getSessionByEventId($event_id){
        return $this->getModel()->where('event_id',$event_id)->get();
    }

    public function getSessionsDetail($session_id){
        return $this->getModel()->where('id',$session_id)->with('sessionSpeakers')->get();

        return DB::table('sessions')
            ->select(DB::raw('sessions.*,session_speakers.*,uni.id as s_id'))
            ->leftJoin('session_speakers','session_speakers.session_id', '=', 'sessions.id')
            ->leftJoin('uni','session_speakers.speaker_id', '=', 'uni.id')
            ->where('sessions.id', '=' ,$session_id)
            ->get();
    }

    public function getSessions(){
        return $this->getModel()->where('send_status',0)->get();
    }


}
