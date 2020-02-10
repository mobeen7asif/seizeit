<?php
/**
 * Created by PhpStorm.
 * User: SHANKS
 * Date: 4/27/2017
 * Time: 12:08 PM
 */
namespace App\Traits;
use App\User;
use Requests\Request;

trait CheckProfile{
   public function profileStatus($user){
       $count = 0;
       if(isset($user->user_info->dnr)){$count++;}
       if(isset($user->user_info->ssn)){$count++;}
       if(isset($user->user_info->age)){$count++;}
       if(isset($user->user_info->gender)){$count++;}
       if(isset($user->user_info->location)){$count++;}
       if(isset($user->user_info->state)){$count++;}
       if(isset($user->user_info->dl_number)){$count++;}
       if(isset($user->user_info->blood_type)){$count++;}
       if(isset($user->user_info->first_name)){$count++;}
       if(isset($user->user_info->last_name)){$count++;}

       if($count >= 4){
           $count = 1;
           return $count;
       }
       return 0;

   }
}
