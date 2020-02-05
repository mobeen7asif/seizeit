<?php
require_once __DIR__."/curl.php";
$keyWord = "physician assistant";
$Location = "Orlando, FL";
$keyWord = urlencode($keyWord);
$Location = urlencode($Location);
$mkURL = "https://www.indeed.com/jobs?as_and={$keyWord}&as_phr=&as_any=&as_not=&as_ttl=&as_cmp=&jt=all&st=&as_src=&salary=&radius=100&l=Orlando%2C+FL&fromage=any&limit=100&sort=&psf=advsrch&from=advancedsearch";
//$mkURL = $_GET['url'];
$curl = new curl;
$name = $curl->get($mkURL);
preg_match_all('/\d\]= {(.*?)};/', $name, $output_array);
$outputArr = null;
$sites = null;
if (!empty($output_array) ) {
    foreach ($output_array[0] as $arr) {
        $Names = null;
        $exploded = explode("]= ", $arr);
            $outputArr[] = $exploded[1]; //json_decode($newJson, true);
            //$outputArr[] = json_decode(stripslashes($exploded[1]), true);
            preg_match('/title:\'(.*?)\'/',$exploded[1],$title);
            $Names['Title'] = stripslashes($title[1]);

            preg_match('/jk:\'(.*?)\'/',$exploded[1],$jk);
            preg_match("/\,efccid: \\'(.*?)\\'/", $exploded[1], $efccid);
            $Names['Link'] = "https://www.indeed.com/rc/clk?jk=".stripslashes($jk[1])."&fccid=".stripslashes($efccid[1])."&vjs=3";

            preg_match('/loc:\'(.*?)\'/',$exploded[1],$loc);
            $Names['Description'] = stripslashes($loc[1]);
            $descriptionLink = "https://www.indeed.com/rpc/jobdescs?jks=".stripslashes($jk[1]);
            $DescContent = file_get_contents($descriptionLink);
            preg_match('/\":\"(.*?)\"\}/',$DescContent,$description);
            $Names['Description'] = strip_tags($description[1]);
            $Names['date'] = "";

        $Names['Summary'] = "";
        $Names['Email'] = "";
        $Names['ContactAddress'] = "";
        $Names['Time'] = "";
            $sites[] = $Names;
    }
}
echo json_encode($sites);
exit;

$filename = 'indeed.csv';
//header("Content-type: text/csv");
//header("Content-Disposition: attachment; filename=$filename");
$output = fopen($filename, 'w');
$header = array_keys($sites[0]);
fputcsv($output, $header);
foreach($sites as $row) {
 fputcsv($output, $row);
}
fclose($output);
echo "<a href='{$filename}'>{$filename}</a>";
