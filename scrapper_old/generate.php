<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
set_time_limit(0);
require_once __DIR__."/curl.php";
require_once __DIR__."/functions.php";

$url = $_GET['url'];
$skip = $_GET['skip'];
$numberOfResults = $_GET['size'];
//$url = "$url&top={$numberOfResults}&filter=&query=&skip=$skip";

//$url = "https://valenciacollege.campuslabs.com/engage/api/discovery/search/organizations?orderBy[0]=UpperName%20asc&top=600&filter=&query=&skip=0";

$siteData = null;
$data = json_decode( file_get_contents($url), true);
$data = $data['value'];
$arr = null;
foreach($data as $keys) {
    $arr[] = $keys['WebsiteKey'];
}
if (isset($arr) && is_array($arr) ) {
    foreach($arr as $nUrl) {
        $cData = null;
        $mkURL = "https://valenciacollege.campuslabs.com/engage/organization/{$nUrl}";
        $curl = new curl;
        $name = $curl->get($mkURL);
        preg_match_all('#<script(.*?)<\/script>#is', $name, $matches);
        $str = str_replace("<script>window.initialAppState = ", "", $matches[0][2]);
        $str = str_replace(";</script>", "", $str);
        $company = json_decode( $str, true);
        $cData['Link'] = $mkURL;
        $cData['Title'] = $company['preFetchedData']['organization']['name'];
        $cData['Description'] = strip_tags( $company['preFetchedData']['organization']['description']);
        $cData['Summary'] = $company['preFetchedData']['organization']['summary'];
        $cData['Email'] = $company['preFetchedData']['organization']['email'];

        $cStreet1 = $company['preFetchedData']['organization']['contactInfo'][0]['street1']." ";
        $cStreet2 = $company['preFetchedData']['organization']['contactInfo'][0]['street2']." ";
        $cZip = $company['preFetchedData']['organization']['contactInfo'][0]['zip']." ";
        $cState = $company['preFetchedData']['organization']['contactInfo'][0]['state']." ";
        $cCity = $company['preFetchedData']['organization']['contactInfo'][0]['city']." ";
        $cCountry = $company['preFetchedData']['organization']['contactInfo'][0]['country']." ";
        $cData['ContactAddress'] = $cStreet1.$cStreet2.$cCity.$cState.$cCountry;
        $cData['Date'] = '';
        $siteData[] = $cData;
    }
    echo json_encode($siteData);
    exit;

}
else {
    echo json_encode([]);
    exit;
}

$filename = 'campuslabs.csv';
//header("Content-type: text/csv");
//header("Content-Disposition: attachment; filename=$filename");
$output = fopen($filename, 'w');
$header = array_keys($siteData[0]);
fputcsv($output, $header);
foreach($siteData as $row) {
 fputcsv($output, $row);
}
fclose($output);
echo "<a href='{$filename}'>{$filename}</a>";

?>
