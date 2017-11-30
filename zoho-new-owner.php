<?php 
function download_page($path){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$path);
    curl_setopt($ch, CURLOPT_FAILONERROR,1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    $retValue = curl_exec($ch);          
    curl_close($ch);
    return $retValue;
}

//Get the latest lead sorted by created time
function getLeadRecordsLatest()
{
    $token = '123456'; //Your token
    $url = "https://crm.zoho.com/crm/private/xml/Leads/getRecords";
    $param= "authtoken=".$token."&scope=crmapi&newFormat=2&selectColumns=All&version=2&toIndex=1&fromIndex=1&sortColumnString=Created Time&sortOrderString=desc"; 

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $param);

    // FIX THIS
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);        

    $result = curl_exec($ch);
    curl_close($ch);

    // First deal with problem with Simple XML and CDATA
    $sxo = simplexml_load_string($result, null, LIBXML_NOCDATA);

    $data = ($sxo->xpath('/response/result/Leads/row'));

    //Set the variables you're expecting to capture
    $arrVariables = array("SMOWNERID");
    $retArr = NULL;

    foreach($data as $row)                      // Iterate over all the results
    {
        foreach($arrVariables as $arrVar)       // Iterate through the variables we're looking for
        {
            $rowData = ($row->xpath('FL[@val="'.$arrVar.'"]'));
            @$arrReturn[$arrVar] = (string)$rowData[0][0];
        }
        $retArr[] = $arrReturn;
    }
    
    return $retArr;
}

//Get the team users
$sXML = download_page('zoho-team.php');
$oXML = new SimpleXMLElement($sXML);
//Create empty arrays for storing ids and emails for each user
$ids = array();
$emails = array();
foreach($oXML->user as $oEntry){
    $sales = $oEntry['profile'];
    //The profile group that the users are in
    if($sales == 'Sales'){ 
        array_push($ids, $oEntry['id']);
        array_push($emails, $oEntry['email']);
    }
}

//Team
$team = array_combine($ids, $emails);

$array_variable = getLeadRecordsLatest();

$leadsownerid = $array_variable[0][SMOWNERID];

//Debug here
//print_r($team);
//echo $leadsownerid;

//Check if the previous lead Lead Owner is in the array of $team else assign a random user in $team
//If true get the next team user else reset the array $team
if (array_key_exists($leadsownerid, $team)) {
    $keys = array_keys($team);
    $nextid = $keys[array_search($leadsownerid,$keys)+1];
    if($nextid){
        $leadowner = $team[$nextid];
    }
    else{
        $leadowner = reset($team);
    }
}
else{
    $leadowner = $team[array_rand($team)];
}

//Return new lead owner
echo $leadowner;
?>