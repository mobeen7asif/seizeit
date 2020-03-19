<?php
require_once __DIR__."/curl.php";

try {
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    set_time_limit(0);
    $url = $_GET['url'];
/*    $WeekCalender = "2020/1/10";
    $mkURL = "https://events.valenciacollege.edu/calendar/week/{$WeekCalender}";*/
    $mkURL = $url;
    set_time_limit(0);
    $curl = new curl;
    $name = $curl->get($mkURL);
    @$doc = new DOMDocument();
    @$doc->loadHTML($name);
    $xpath = new DomXPath($doc);
    $newArr = [];
    $Events = $xpath->query('//div[@class="item event_item vevent"]');

    foreach($Events as $uIndex => $event) {
        $nameArr = null;
        $descArr = null;
        $TimeArr = null;
        $linkArr = null;
        $locationArr = null;
        $AllArr = null;
        /* Event Link */
        $singlelink = $event->getElementsByTagName('a');

        foreach ($singlelink as $index => $onelink){
            if ($index == 0) {
                $linkArr = $onelink->getAttribute('href');
            }
        }

        /* Event Link Ends */

        /* Event Name */
        $Names = $event->getElementsByTagName('h3');
        foreach ($Names as $index => $oneHeading){
            if ($index == 0) {
                $nameArr = $oneHeading->nodeValue;
            }
        }
        /* Event Name Ends*/


        /* Event Description */
        $Names = $event->getElementsByTagName('h4');
        foreach ($Names as $index => $oneDesc){
            if ($index == 0) {
                $descArr = $oneDesc->nodeValue;
            }
        }
        /* Event Description Ends*/

        /* Event Description */
        $Time = $event->getElementsByTagName('abbr');
        foreach ($Time as $index => $oneTime){
            if ($index == 0) {
                //$time_old = $oneTime->getAttribute('title');
                $TimeArr = trim($oneTime->nodeValue);
                //$TimeArr = date("Y-m-d H:i:s", strtotime($time_old));
            }
        }

        /* Event Description Ends*/


        /* Event Location */
        $locURL = $linkArr;
        $curl = new curl;
        $name = $curl->get($locURL);
        @$doc2 = new DOMDocument();
        @$doc2->loadHTML($name);
        $xpath2 = new DomXPath($doc2);
        $newFinder = $xpath2->query('//p[@class="location"]');
        foreach ($newFinder as $loc) {
            $locationArr = trim($loc->nodeValue);
        }

        /* Event Location Ends*/
        $AllArr['Link'] = $linkArr;
        $AllArr['Title'] = preg_replace('/\s+/', ' ', $nameArr);
        $AllArr['Description'] = $descArr;
        $AllArr['Time'] = $TimeArr;
        $AllArr['ContactAddress'] = preg_replace('/\s+/', ' ', $locationArr);
        $AllArr['Summary'] = "";
        $AllArr['Email'] = "";
        $newArr[] =  $AllArr;
    }


    echo json_encode($newArr);
    exit;


    $filename = 'events.csv';
//header("Content-type: text/csv");
//header("Content-Disposition: attachment; filename=$filename");
    $output = fopen($filename, 'w');
    $header = array_keys($newArr[0]);
    fputcsv($output, $header);
    foreach($newArr as $row) {
        fputcsv($output, $row);
    }
    fclose($output);
    echo "<a href='{$filename}'>{$filename}</a>";
}
catch(Exception $e) {
    echo null;
    exit;
}


