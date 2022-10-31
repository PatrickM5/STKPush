<?php
header('Content-Type: application/json');  // <-- header declaration
header("HTTP/1.0 200 OK");

        $data = file_get_contents('php://input');
        //print_r($data);
        $data = json_decode($data);

        // Process the data...
        // We have been paid by one of our customers!!
        $TransactionType = $data->{"TransactionType"};
        $TransID = $data->{"TransID"};
        $TransTime = $data->{"TransTime"};
        $TransAmount = $data->{"TransAmount"};
        $BusinessShortCode = $data->{"BusinessShortCode"};
        $BillRefNumber = $data->{"BillRefNumber"};
        $InvoiceNumber = $data->{"InvoiceNumber"};
        $OrgAccountBalance = $data->{"OrgAccountBalance"};
        $ThirdPartyTransID = $data->{"ThirdPartyTransID"};
        $MSISDN = $data->{"MSISDN"};
        $FirstName = $data->{"FirstName"};
        $MiddleName = $data->{"MiddleName"};
        $LastName = $data->{"LastName"};

            if ($BusinessShortCode == 7146151) {
                echo '{"ResultCode":"0","ResultDesc":"Accepted"}';
               
                $this->saveValidation($data,"SUCCESS", "");
            }else if ($BusinessShortCode == 328100) {
                echo '{"ResultCode":"0","ResultDesc":"Accepted"}';
               
                $this->saveValidation($data,"SUCCESS", "");
            }else if ($BusinessShortCode == 328103) {
                echo '{"ResultCode":"0","ResultDesc":"Accepted"}';
               
                $this->saveValidation($data,"SUCCESS", "");
            }
            else{
                echo '{"ResultCode":"0","ResultDesc":"Accepted"}';
                $this->saveValidation($data,"SUCCESS", "");
            }

?>