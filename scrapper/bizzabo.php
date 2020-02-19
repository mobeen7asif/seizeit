<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
set_time_limit(0);

require_once __DIR__."/curl.php";
require_once __DIR__."/functions.php";
$url = $_GET['url'];

//$url = "https://blog.bizzabo.com/education-events";
$curl = new curl;
$name = $curl->get($url);
@$doc = new DOMDocument();
@$doc->loadHTML($name);
$xpath = new DomXPath($doc);
$rows = $xpath->query("//table[@class='blog-table']/tbody/tr");
$excludes = array("Name", "Location", "Start Date", "Description");
$Setkeys = array("Name", "Location", "Date", "Description");
$data = [];


foreach($rows as $i=>$row){
    $tds=$xpath->query('td',$row);
    $cellData = null;
    $links =  $row->getElementsByTagName('a');
    foreach($tds as $key => $td){
       //echo "Td($i):", $td->nodeValue,"<br>";
        if ( !in_array($td->nodeValue, $excludes) ) {
            $cellData[$Setkeys[$key]] = $td->nodeValue;
        }
    }
    foreach ($links as $onelink){
        $cellData['Link'] = $onelink->getAttribute('href');
        $cellData['Summary'] = "";
        $cellData['Email'] = "";
        $cellData['Time'] = "";
    }



    $data[] = $cellData;
}

$newPrintData = array_filter($data);
echo json_encode($newPrintData);
exit;

echo "<pre>";
print_r($newPrintData);
echo "</pre>";

$filename = 'bizzabo.csv';
//header("Content-type: text/csv");
//header("Content-Disposition: attachment; filename=$filename");
$output = fopen($filename, 'w');
$header = array_keys($newPrintData[0]);
fputcsv($output, $header);
foreach($newPrintData as $row) {
 fputcsv($output, $row);
}
fclose($output);
echo "<a href='{$filename}'>{$filename}</a>";

?>
