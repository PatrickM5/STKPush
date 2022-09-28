
<!DOCTYPE HTML>
<html>  
<head>
  <title>Bootstrap 5 Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="p-5 bg-primary text-white text-center">


<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $phoneNumber = $_POST["phone"]; 

        date_default_timezone_set('Africa/Nairobi');
        # access token
        $consumerKey = "upjGv2xgPP1SAw8mNWbF1Wkh0F9jB6tb"; //Fill with your app Consumer Key
        $consumerSecret = "kuyr2oVPD9Nry4xA"; // Fill with your app Secret
        # define the variales
        # provide the following details, this part is found on your test credentials on the developer account
        $BusinessShortCode = "174379";
        $Passkey = "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919";   
        /*
            This are your info, for
            $PartyA should be the ACTUAL clients phone number or your phone number, format 2547********
            $AccountRefference, it maybe invoice number, account number etc on production systems, but for test just put anything
            TransactionDesc can be anything, probably a better description of or the transaction
            $Amount this is the total invoiced amount, Any amount here will be 
            actually deducted from a clients side/your test phone number once the PIN has been entered to authorize the transaction. 
            for developer/test accounts, this money will be reversed automatically by midnight.
        */
            //start phone formatting
        
        // $formattedPhone = '714463663';
        
        $formattedPhone = substr($phoneNumber,1);//789
        $keCode = "254";
        
        //end
        $PartyA = $keCode.$formattedPhone; // This is your phone number 2547123456789
        //   $PartyA = "254769861516";
        // $_SESSION['party_A'] = $PartyA;
        $AccountReference = "Test services";
        $TransactionDesc = "Test Payment";
        $Amount = 1;
        
        
        # Get the timestamp, format YYYYmmddhms -> 20181004151020
        $Timestamp = date('YmdHis');    
        # Get the base64 encoded string -> $password. The passkey is the M-PESA Public Key
        $Password = base64_encode($BusinessShortCode.$Passkey.$Timestamp);
        $_SESSION['Password'] = $Password;
        # header for access token
        $headers = ['Content-Type:application/json; charset=utf8'];
            # M-PESA endpoint urls
        $access_token_url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
        
        $initiate_url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
        
        # callback url
        $CallBackURL = "https://ternspin-listener.herokuapp.com/express/result";  
        
        $curl = curl_init($access_token_url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_HEADER, FALSE);
        curl_setopt($curl, CURLOPT_USERPWD, $consumerKey.':'.$consumerSecret);
        
        $result = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $result = json_decode($result);
        $access_token = $result->access_token;  
        
        curl_close($curl);
        
        # header for stk push
        $stkheader = ['Content-Type:application/json','Authorization:Bearer '.$access_token];
        
        # initiating the transaction
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $initiate_url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $stkheader); //setting custom header
        
        $curl_post_data = array(
            //Fill in the request parameters with valid values
            'BusinessShortCode' => $BusinessShortCode,
            'Password' => $Password,
            'Timestamp' => $Timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => $Amount,
            'PartyA' => $PartyA,
            'PartyB' => $BusinessShortCode,
            'PhoneNumber' => $PartyA,
            'CallBackURL' => $CallBackURL,
            'AccountReference' => $AccountReference,
            'TransactionDesc' => $TransactionDesc
        );
        
        $data_string = json_encode($curl_post_data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        $curl_response = curl_exec($curl);
        // print_r($curl_response);
        //   header('location: thankyou.php');
        
        // echo $curl_response;
        if ($curl_response) {
        //refresh the page 
        $page = $_SERVER['PHP_SELF'];
            $sec = "10";
            header("Refresh: $sec; url=$page");
            
        }else{
            
        }

  }

 
?>

<div class="container-fluid p-5 bg-primary text-white text-center">
  <h1>Test STK Push</h1>
  <p>Enter Your Phone number and submit</p> 
  <form method="post" action="">
  Phone Number <input type="text" name="phone" class="m-2" placeholder="0700000000" ><br>
   <input type="submit" class="btn btn-success" value="Submit Request" >
</form>

<?= isset( $_POST['message'] ) ? $_POST['message'] : ''; ?>
</div>
</div>



</body>
</html>
