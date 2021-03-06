<?php
/**
 * Created by PhpStorm.
 * user: nomantufail
 * Date: 10/10/2016
 * Time: 10:13 AM
 */

namespace App\Repositories;


use Illuminate\Support\Facades\DB;

class Repository
{
    protected $model = null;
    public function setModel($model)
    {
        $this->model = clone($model);
        return $this;
    }

    public function getModel()
    {
        return clone($this->model);
    }

    public function all()
    {
        return $this->getModel()->all();
    }

    public function store($attrs = [])
    {
        return $this->getModel()->create($attrs);
    }

    public function insertMultiple($records = [])
    {
        return DB::table($this->getModel()->getTable())->insert($records);
    }

    public function deleteById($id)
    {
        return $this->getModel()->destroy($id);
    }

    public function findById($id)
    {
        return $this->getModel()->find($id);
    }
    public function findByEmail($email)
    {
        return $this->getModel()->where('email', $email)->first();
    }
    public function findByUserName($user_name)
    {
        return $this->getModel()->where('user_name', $user_name)->first();
    }

    public function updateWhere($where, $attrs)
    {
        $query = $this->getModel();
        foreach($where as $key => $value){
            $query = $query->where($key,'=',$value);
        }
        return $query->update($attrs);
    }
    public function deleteRecords($ids){
        return $this->getModel()->whereIn('id', $ids)->delete();
    }
    public function getWhere($where){
        return $this->getModel()->where($where)->get();
    }
}