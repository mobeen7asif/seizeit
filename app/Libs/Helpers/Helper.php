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

    public static function clean($string) {
       // $x = "Barnes &amp; Noble College is a retail environment like no other &ndash; uniquely focused on delivering outstanding customer service. Our stores can carry everything from text and trade books, technology, and school supplies to clothing, regalia, and food- everything a college student desires, their parents want, and our faculty needs.\n\nAs an Assistant Department Manger (Full-Time): Operations\u002FTrade\u002FMarketing you will support all store operations and departments in partnership with the management team. You will manage the daily activities in a Bookmaster store to assist campus or campus and general community customers with locating academic or leisure materials for purchase. You will ensure the availability of complementary products and supplies; manage promotions, book fairs, author, and faculty author events; while spending time on the sales floor training and modeling skills to ensure well stocked and visually appealing areas. There may be times where you will spend significant time outside of the store setting, engaged in sales activities such as outreach, client meetings, and presentations with the goal of obtaining sales commitments from existing and prospective clients. You must have effective presentation skills, the ability to influence audiences in formal and informal settings, and exceptional listening and communication abilities to adapt to various environments and situations. When on site in the store you will support all store operations and departments in partnership with the management team to include management of daily sales activities, maintenance of appealing displays, and providing direction and support to booksellers. You will use your rapport building and collaborative abilities to generate and sustain relationships with clients, peers, and the store team.\n\n\nExpectations:\n\nManage Trade Department &ndash; Follow daily instructions on INSIDE and complete tasks accordingly. Refresh and merchandise title selections by responding to national trends as well as campus &amp; current events and hyper-local interests.\nDepartment Liaison - Research campus events and faculty authors to establish a relationship with these contacts. Follow up with phone calls, emails and department meetings &amp; visits. Increase trade sales by asking about a department's budget and spending abilities. Develop concierge book ordering and delivery program.\nCommunity Liaison - Reach out to local elementary, middle, high and private schools for book lists sales opportunities. Annually coordinate the Giving Tree operations, including book orders, marketing and sales at each register. Work with local non-profit organizations to offer books sold.\nDrive bulk book sales and store traffic through outreach to prospective institutional, corporate, and local community groups and organizations by conducting sales calls and making presentations.\nConduct strategic and effective sales presentations with representatives of local schools, nonprofit agencies, and literary organizations to cultivate existing accounts and to generate new business.\nResearch the local community and identify business opportunities, create and implement programs to expand sales potential.\nSpecial Events- Plan, promote, and oversee the execution of store events in partnership with store management. Work across all departments to develop and execute events that drive in-store traffic and engagement.\nAssist Operations Department - Assist Operations Manager with bookseller interviews, hiring process, on-boarding paperwork and initial informational training during Rush recruiting.\nOrientation Liaison &ndash; Work with First Year Experience to coordinate training materials, donations and O-Team&rsquo;s training sessions. During UCF&rsquo;s Transfer and First Time In College orientations, create and present bookstore information to incoming students.\nSocial Media - Manage the bookstore's social media accounts. Working with the Home Office's direction for corporate vs in-store postings, create a calendar identifying days that need a post. Partner with department managers to promote store events, sales and other happenings. Recognize media trends and viral videos to create relevant content that speaks to our customers.\nMaintain a presence on the sales floor to greet customers, answer questions about general or reference books, recommend products and\u002For services, and help locate or obtain materials using ISBNs, knowledge of authors, and publications and provide daily support, direction, and guidance to booksellers..\nAbility to use department specific technology and assist in the daily operation of the store in partnership with the Store Manager, Assistant Store Manager and the management team.\nAssist with processing sales transactions involving cash, credit, or financial aid payments.\n Full-time positions require availability to work at least 30 hours on a weekly basis year round. Schedules may be set or vary to meet the needs of the store.\n\n\nPhysical Demands:\n\nFrequent movement within the store, among the community, and campus to access various departments, areas, and\u002For products.\nAbility to remain in a stationary position for extended periods.\nFrequent lifting.\nOccasional reaching, stooping, kneeling, crouching, and climbing ladders.\n\n\nQualifications:\n\n2+ years&rsquo; experience in a retail setting as a manager or buyer or experience in commercial sales or public relations is required. Graduate of the Barnes &amp; Noble College Bestseller program is a plus.\nExperience in one or more of the following fields- sales (preferably outbound sales in retail), education, marketing, fundraising and development, or public relations.\nOutstanding computer skills including proficiency with the internet, social media, Excel, Word, and PowerPoint.\nStrong presentation, written, and verbal communication skills.\nExcellent customer service and communication skills needed.\nStrong interpersonal, communication, and problem solving skills.\nValid driver&rsquo;s license and access to reliable transportation.\nAbility to work a flexible schedule including evenings, weekends, and holidays.\n\n\nBarnes &amp; Noble College is an Equal Employment Opportunity and Affirmative Action Employer committed to diversity in the workplace. Qualified applicants will receive consideration for employment without regard to race, color, religion, sex, national origin, sexual orientation, gender identity, disability or protected veteran status.";
        $string = htmlspecialchars_decode($string);

        $str = preg_replace_callback('/\\\\u([0-9a-fA-F]{4})/', function ($match) {
            return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
        }, $string);

        return $str;
    }

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
