<?php
/**
 * Created by PhpStorm.
 * user: JR Tech
 * Date: 4/14/2016
 * Time: 12:27 PM
 */

namespace App\Libs\Helpers;


use Carbon\Carbon;

class Helper
{
    public static function propertyToArray(array $objects, $property)
    {
        $array = [];
        foreach($objects as $object)
        {
            $array[] = $object->$property;
        }
        return $array;
    }

    public static function rands($length = 5) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    public static function userTransform($user)
    {
        $user = json_decode($user);
        $image = $user->user_info->user_image;
        if(isset($image))
        {
            $user->user_info->user_image = url('/').'/'.$image;
//            $user->medical_history_count = $this->medicalHistoryRepo->getMedicalHistoryList($user->id)->count();
//            $user->medical_document_count = $this->medicalDocRepo->getMedicalDocuments($user->id)->count();
        }
        return $user;
    }


    public static function towfixDateFormat($date)
    {
        $date = explode(' ',$date)[0];
        $months = config('constants.MONTHS');
        $day_symbol = config('constants.DAY_SYMBOL');
        $dateArray = explode('-', $date);
        $formattedDate = $dateArray[2]."<sup>".$day_symbol[intval($dateArray[2])]."</sup> ".ucfirst($months[intval($dateArray[1])-1])." ".$dateArray[0];
        return $formattedDate;
    }

    public static function distance() {

        $lat1 = 31.60257;
        $lon1 = 74.36255;
        $lat2=31.4876403;
        $lon2=74.312928;
        $unit = 'K';
        $theta = $lon1 - $lon2;
       // $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));


        dd( rad2deg(acos(sin(deg2rad($lat1)))) );
        return ((rad2deg(acos(sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)))))*60 * 1.1515);


        //return ((rad2deg(acos(sin(($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)))))*60*1.1515);
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        //return $miles;
        $unit = strtoupper($unit);

        if ($unit == "K") {
            return ($miles * 1.609344);
        } else if ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
    }

    public static function get_distance() {
        $latitude1 = 31.60257;
        $longitude1  = 74.36255;
        $latitude2 = 31.4876403;
        $longitude2 = 74.312928;
        $theta = $longitude1 - $longitude2;
        $distance = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) +
            (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) *
                cos(deg2rad($theta)));
        $distance = acos($distance);
        $distance = rad2deg($distance);
        $distance = $distance * 60 * 1.1515;

        return $distance;
        switch($unit) {
            case 'Mi':
                break;
            case 'Km' :
                $distance = $distance * 1.609344;
        }
        return (round($distance,2));
    }

}