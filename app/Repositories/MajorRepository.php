<?php
/**
 * Created by PhpStorm.
 * user: nomantufail
 * Date: 10/10/2016
 * Time: 10:13 AM
 */

namespace App\Repositories;

use App\Major;
use App\User;
use Illuminate\Support\Facades\DB;

class MajorRepository extends Repository
{
    public function __construct(Major $major)
    {
        $this->setModel($major);
    }

    public function getByIds($ids = [])
    {
        return  $this->getModel()->whereIn('id', $ids)->get();
    }
    public function getMajors($number = 0){
        return $this->getModel()->orderBy('sort_id','ASC')
            ->skip($number*5)
            ->take(5)
            ->get();
    }

    public function getAllMojors(){
        return $this->getModel()->orderBy('sort_id','ASC')
            ->get();
    }

}
