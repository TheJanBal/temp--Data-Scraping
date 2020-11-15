<?php
require_once 'simple_dom/simple_html_dom.php';
//get html content from the site.
$dom = file_get_html('https://www.worldometers.info/coronavirus/', false);

$details = array();

if( !empty($dom) ){
    $tablerow = $cell = '';
    $i = $z = 0;
    // MAKE AN ARRAY FOR EACH ROW AND A MULITDIMENTIAL ARRAY FOR EACH CELL IN THE ROWS
    foreach ( $dom->find("table#main_table_countries_today > tbody > tr") as $tablerow ){
        foreach ( $tablerow->find("td") as $cell ) {
            $details[$i][$z] = $cell->plaintext.'<br>';
            $z++;
        }
        $i++;$z=0;
    }
}

//print_r($details);
//$detslen = count($details);
//echo $detslen.'<br>';

//for($x = 0; $x < $detslen; $x++) {
// START NEW MULTIDIMENTIONAL ASSOCIATED ARRAY WITH ONLY NEEDED DATA FOR JSON
$countryInfections = array();
for($x = 0; $x < 227; $x++) { // totals start at entry 227
    if ( $x > 7 ){ // regions end at entry 7
        //echo 'Country '.$x.': '.$details[$x][1].'&emsp; Total Cases: '.$details[$x][2].'&emsp; new cases: '.$details[$x][3].'&emsp; total deaths: '.$details[$x][4].'&emsp; new deaths: '.$details[$x][5].'&emsp; total recovered: '.$details[$x][6].'<br>';
        $country = $details[$x][1];
        $totalCases = $details[$x][2];
        $newCases = $details[$x][3];
        $totalDeaths = $details[$x][4];
        $newDeaths = $details[$x][5];
        $totalRecovered = $details[$x][6];

        $countryInfections[$country] = array("totalCases"=>$totalCases, "newCases"=>$newCases, "totalDeaths"=>$totalDeaths, "newDeaths"=>$newDeaths, "totalRecovered"=>$totalRecovered);
    }
}
//print_r($countryInfections);
// ENCODE TO JSON OUTPUT
echo json_encode($countryInfections);

exit;
?>