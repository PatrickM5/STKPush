<?php
$request=file_get_contents('php://input');
//process the received content into an array
$array = json_decode($request, true);
//print_r($array);exit;
$transactiontype="Pay Bill";// $array['TransactionType'];
$transid=$array['TransID'];
$transtime=$array['TransTime'];
$transamount=$array['TransAmount'];
$businessshortcode=$array['BusinessShortCode'];
$billrefno=$array['BillRefNumber'];
$invoiceno=$array['InvoiceNumber'];
$msisdn=$array['MSISDN'];
$orgaccountbalance=$array['OrgAccountBalance'];
$firstname=$array['FirstName'];
$middlename=$array['MiddleName'];
$lastname=$array['LastName'];
$date =date("Y-m-d H:i:s");

$t = $billrefno;
$v = 'T';

if(preg_match("/{$v}/i", $t)) {

$d = array('ResultCode' =>0 ,'ResultDesc'=> "Accepted" );
header('Content-type: application/json; charset=utf-8');
echo json_encode($d);
}else{

$d2 = array('ResultCode' =>1 ,'ResultDesc'=> "Rejected" );
header('Content-type: application/json; charset=utf-8');
echo json_encode($d2);
}

?>