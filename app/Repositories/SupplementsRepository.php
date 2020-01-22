<?php
/**
 * Created by PhpStorm.
 * user: nomantufail
 * Date: 10/10/2016
 * Time: 10:13 AM
 */

namespace App\Repositories;

use App\Models\FranchiseInfo;
use App\Uni;
use App\Sponsor;
use App\Supplement;
use App\User;
use Illuminate\Support\Facades\DB;

class SupplementsRepository extends Repository
{
    public function __construct(Supplement $supplement)
    {
        $this->setModel($supplement);
    }

    public function getByIds($ids = [])
    {
        return  $this->getModel()->whereIn('id', $ids)->get();
    }
    public function getSponsors(){
        return $this->getModel()->all();
    }
    public function getAllSupplements(){
        return $this->getModel()->orderBy('sort_id','ASC')->get();
    }

    public function getSupplements($number = 0){
        return $this->getModel()->orderBy('sort_id','ASC')
            ->skip($number*5)
            ->take(5)
            ->get();
    }
}
