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
use App\User;
use Illuminate\Support\Facades\DB;

class UniRepository extends Repository
{
    public function __construct(Uni $uni)
    {
        $this->setModel($uni);
    }

    public function getByIds($ids = [])
    {
        return  $this->getModel()->whereIn('id', $ids)->get();
    }
    public function getUni($number = 0){
        return $this->getModel()->orderBy('sort_id','ASC')
            ->skip($number*5)
            ->take(5)
            ->get();
    }
    public function getAllUni(){
        return DB::table('uni')->orderBy('sort_id','ASC')
            ->get();
    }
    public function getByNames(){
        return $this->getModel()->orderBy('name','ASC')
            ->get();
    }
}
