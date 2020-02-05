<?php
require_once __DIR__."/curl.php";
require_once __DIR__."/functions.php";
$url = $_GET['url'];
//$url = "https://valenciacollege.edu/academics/programs/";
$curl = new curl;
$name = $curl->get($url);
@$doc = new DOMDocument();
@$doc->loadHTML($name);
$xpath = new DomXPath($doc);
$rows = $xpath->query("//div[@class='card']");
$data = null;
$mainPageLinks = null;
foreach($rows as $onetag) {
    $links =  $onetag->getElementsByTagName('a');
    foreach ($links as $onelink){
        $mainPageLinks[] = $onelink->getAttribute('href');
    }
}

/* Course Links */
$dataCourse = null;
foreach ($mainPageLinks as $SubPageLink) {
    $curl = new curl;
    $name = $curl->get($SubPageLink);
    @$doc = new DOMDocument();
    @$doc->loadHTML($name);
    $xpath = new DomXPath($doc);
    $Certifies = $xpath->query("//h3[text()='Certificate']/following::ul[1]");
    foreach ($Certifies as $CertData) {
        $links =  $CertData->getElementsByTagName('a');
        foreach ($links as $onelink){
            $cellData[] = $onelink->getAttribute('href');
        }
    }
}
/* Course Links Ends */


/* Data Fetch Details */
$sublinkings = array_unique($cellData);
$pageContent = [];
foreach($sublinkings as $Sub) {
$tag = null;
$curl = new curl;
$name = $curl->get($Sub);
@$doc = new DOMDocument();
@$doc->loadHTML($name);
$xpath = new DomXPath($doc);
$h1 = $xpath->query("(//*[@class='tab_content'])[last()]/h1[1]");
$p = $xpath->query("(//*[@class='tab_content'])[last()]/p[1]");
$tag['Link'] = $Sub;
$tag['date'] = null;
    foreach ($h1 as $element) {
        $tag['Title'] = $element->nodeValue;
    }

    foreach ($p as $element) {
        $tag['Description'] = $element->nodeValue;
    }
    if ( !empty($tag['description'])) {
        $pageContent[] = $tag;
    }

    $tag['Time'] = '';
    $tag['ContactAddress'] = '';

    $tag['Summary'] = "";
    $tag['Email'] = "";


}

echo json_encode($pageContent);
exit;


/* Data Fetch Details Ends */
echo "<pre>";
print_r($pageContent);
//print_r(array_unique($cellData));
echo "</pre>";

$filename = 'valenciacollege.csv';
//header("Content-type: text/csv");
//header("Content-Disposition: attachment; filename=$filename");
$output = fopen($filename, 'w');
$header = array_keys($pageContent[0]);
fputcsv($output, $header);
foreach($pageContent as $row) {
 fputcsv($output, $row);
}
fclose($output);
echo "<a href='{$filename}'>{$filename}</a>";
?>
