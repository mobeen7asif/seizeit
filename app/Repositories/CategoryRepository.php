<?php
/**
 * Created by PhpStorm.
 * user: nomantufail
 * Date: 10/10/2016
 * Time: 10:13 AM
 */

namespace App\Repositories;

use App\Category;
use App\Major;
use App\User;
use Illuminate\Support\Facades\DB;

class CategoryRepository extends Repository
{
    public function __construct(Category $category)
    {
        $this->setModel($category);
    }

    public function getByIds($ids = [])
    {
        return  $this->getModel()->whereIn('id', $ids)->get();
    }
    public function getCategories($number = 0){
        return $this->getModel()->orderBy('sort_id','ASC')
            ->skip($number*5)
            ->take(5)
            ->get();
    }

    public function getAllCategories(){
        return $this->getModel()->orderBy('sort_id','ASC')
            ->get();
    }

}
