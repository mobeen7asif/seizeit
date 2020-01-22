<?php
/**
 * Created by PhpStorm.
 * User: waqas
 * Date: 3/17/2016
 * Time: 12:08 PM
 */

namespace App\Libs\Auth;

use App\Repositories\UsersRepository;
use App\User;
use Illuminate\Support\Facades\Hash;
class PAuth extends Auth
{

    /**
     * @param array $credentials
     * @return bool
     */
    public static function attempt(array $credentials)
    {
        $check = false;
        $check1 = false;
        try{
            $user = (new UsersRepository())->findByEmail($credentials['email']);
            if($user == null){
                $check = false;
            }
            else{
                if(!Hash::check($credentials['password'], $user->password)){
                    $check = false;
                }
                else{
                    $logUser = (new UsersRepository())->findByEmail($credentials['email']);
                    $check = true;
                }
            }
            $user1 = (new UsersRepository())->findByUserName($credentials['email']);
            if($user1 == null){
                $check1 = false;
            }
            else{
                if(!Hash::check($credentials['password'], $user1->password)){
                    $check1 = false;
                }
                else{
                    $logUser = (new UsersRepository())->findByUserName($credentials['email']);
                    $check1 = true;
                }
            }

            if($check or $check1){
                return $logUser;
            }else{
                return null;
            }
        }

        catch (\Exception $e){
            return false;
        }

    }

}