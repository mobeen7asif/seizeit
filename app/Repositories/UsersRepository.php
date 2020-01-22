<?php
/**
 * Created by PhpStorm.
 * user: nomantufail
 * Date: 10/10/2016
 * Time: 10:13 AM
 */

namespace App\Repositories;

use App\Models\FranchiseInfo;
use App\User;
use Illuminate\Support\Facades\DB;

class UsersRepository extends Repository
{
    public function __construct()
    {
        $this->setModel(new User());
    }

    public function getByIds($ids = [])
    {
        return  $this->getModel()->whereIn('id', $ids)->get();
    }
    public function findByToken($token)
    {
        $usersTable = $this->getModel()->getTable();
        return $this->getModel()->where('session_id', $token)
            ->first();
    }
    public function getAllUsers(){
        return $this->getModel()->where('user_type',0)->orderBy('sort_id','ASC')->get();
    }
    public function getAdmins(){
        return $this->getModel()->where('user_type',1)->orWhere('user_type',2)->orderBy('sort_id','ASC')->get();
    }
//    public function deleteUsers($ids){
//        return $this->getModel()->whereIn('id', $ids)->delete();
//    }
    public function getAdmin(){
        return $this->getModel()->where('user_type',1)->first();
    }
    public function updateSortId($query){
dd($query);
        return DB::raw($query);
    }
    public function makeUsersAdmin($admin_ids){
        return $this->getModel()->whereIn('id' , $admin_ids)->update(['user_type' => 1]);
    }


}
