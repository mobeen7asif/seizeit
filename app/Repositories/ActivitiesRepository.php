<?php
/**
 * Created by PhpStorm.
 * user: nomantufail
 * Date: 10/10/2016
 * Time: 10:13 AM
 */

namespace App\Repositories;

use App\Activity;
use App\Models\FranchiseInfo;
use App\Uni;
use App\Sponsor;
use App\User;
use Illuminate\Support\Facades\DB;

class ActivitiesRepository extends Repository
{
    public function __construct(Activity $activity)
    {
        $this->setModel($activity);
    }

    public function getByIds($ids = [])
    {
        return  $this->getModel()->whereIn('id', $ids)->get();
    }
    public function getActivities($number = 0){
        return $this->getModel()->orderBy('sort_id','ASC')
            ->skip($number*5)
            ->take(5)
            ->get();
    }

    public function getAllActivities(){
        return $this->getModel()->orderBy('sort_id','ASC')
            ->get();
    }
}
