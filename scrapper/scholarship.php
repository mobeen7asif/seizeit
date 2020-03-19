<?php
require_once __DIR__."/curl.php";
$mkURL = "https://valenciacollege.edu/finaid/scholarship-bulletin-board.php";
$curl = new curl;
$name = $curl->get($mkURL);
@$doc = new DOMDocument();
@$doc->loadHTML($name);
$xpath = new DomXPath($doc);

error_reporting(E_ERROR | E_WARNING | E_PARSE);
set_time_limit(0);

$printArr = null;
$scholar = $xpath->query('//table/tbody/tr[not(@id) and not(@class)]');
foreach($scholar as $uIndex => $data) {
    $newArr = null;
    /* Name */
    $linkArr = null;
    $name = $data->getElementsByTagName('td');
    foreach ($name as $index => $fName){
        if ($index == 0) {
            $linkArr = $fName->nodeValue;
        }
    }
    /* Name Ends*/

    /* Date */
    $dated = null;
    $dates = $data->getElementsByTagName('td');
    foreach ($dates as $index => $fDate){
        if ($index == 2) {
            $dated = $fDate->nodeValue;
        }
    }
    /* Date Ends*/

    /* link */
    $links = null;
    $nlinks = $data->getElementsByTagName('a');
    $numItems = $nlinks->length;
    $nnindex = $numItems-1;
    foreach ($nlinks as $index => $fLinks){
        if ($index == $nnindex) {
            $links = $fLinks->getAttribute('href');
        }
    }
    //$links = $numItems;
    /* link Ends*/

    $newArr['Title'] = trim($linkArr);
    $newArr['Time'] = $dated;
    $newArr['Link'] = $links;
    $newArr['Location'] = "";
    $printArr[] = $newArr;
}

echo json_encode($printArr);
exit;

/*echo "<pre>";
print_r($printArr);
echo "</pre>"; */

$filename = 'scholarship.csv';
//header("Content-type: text/csv");
//header("Content-Disposition: attachment; filename=$filename");
$output = fopen($filename, 'w');
$header = array_keys($printArr[0]);
fputcsv($output, $header);
foreach($printArr as $row) {
 fputcsv($output, $row);
}
fclose($output);
echo "<a href='{$filename}'>{$filename}</a>";
