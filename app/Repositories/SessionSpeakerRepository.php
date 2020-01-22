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
use App\SessionSpeaker;
use App\Uni;
use App\Sponsor;
use App\User;
use Illuminate\Support\Facades\DB;

class SessionSpeakerRepository extends Repository
{
    public function __construct(SessionSpeaker $sessionSpeaker)
    {
        $this->setModel($sessionSpeaker);
    }

    public function getByIds($ids = [])
    {
        return  $this->getModel()->whereIn('id', $ids)->get();
    }
    public function getSponsors(){
        return $this->getModel()->all();
    }
    public function deleteSessionSpeakers($session_id){
        return $this->getModel()->where('session_id',$session_id)->delete();
    }
}
