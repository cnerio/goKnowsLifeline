<?php 

Class APIprocess{


    public function shockwaveProcess($customerId,$enrollModel){
      //'G-SN3C0031'
      
        $customerData = $enrollModel->getCustomerData($customerId);
       
        if($customerData && $customerData[0]['customer_id']){
         
        $credentials=$enrollModel->getCredentials();
        $processData['customer_id']=$customerId;
        $packages = $enrollModel->getPackages();
    
        $createResponse=create_shockwave_account($customerData[0],$credentials[0],$packages);
        
        $processData['process_status']="addSubscriberOrder API";
        $enrollModel->updateData($processData,'lifeline_records');
        
        $saveCreateLog=[
          "customer_id"=>$customerId,
          "url"=>$createResponse['url'],
          "request"=>$createResponse['request'],
          "response"=>json_encode($createResponse['response']),
          "title"=>$createResponse['title']
        ];
        $enrollModel->saveData($saveCreateLog,'lifeline_apis_log');
        if($createResponse['status']=="success"){
          
          if($createResponse['order_id']>0){
            $dataOrder=[
                "customer_id"=>$customerId,
                "order_id"=>$createResponse['order_id'],
                "account"=>$createResponse['account'],
                "acp_status"=>$createResponse['acp_status'],
                "status_text"=>$createResponse['status_text'],
                "process_status"=>"saving Order ID > 0"
              ];
              $enrollModel->updateData($dataOrder,"lifeline_records");
               $row = $enrollModel->getCustomerData($customerId);

              $checkID = $this->getIdfile($customerId,$enrollModel);
              if($checkID){
                // Read the image file into a binary string
                $imageData = file_get_contents($checkID['filepath']);

                // Encode the binary data to base64
                $IDbase64 = base64_encode($imageData);
                $uploadId=UploadDocument($credentials[0], $row[0]['order_id'], $customerId.".png", $IDbase64, '100001');
                if($uploadId['status']=="success"){
                  $saveCreateIDLog=[
                    "customer_id"=>$customerId,
                    "url"=>$uploadId['url'],
                    "request"=>$uploadId['request'],
                    "response"=>json_encode($uploadId['response']),
                    "title"=>$uploadId['title']
                  ];
                  $enrollModel->saveData($saveCreateIDLog,'lifeline_apis_log');
                  $fileId = ["customer_id"=>$customerId,"to_unavo"=>1];
                 // $enrollModel->saveData($fileId,'lifeline_documents');
                 $enrollModel->updateData($fileId ,'lifeline_documents');
                }
              }


            $consentFile64=$this->getConsentFile($row[0]['order_id']);
            //$consentFile64 = getConsent64($row[0]);
            // print_r($consentFile64);
              $processData['process_status']="generating consent File";
              $enrollModel->updateData($processData,'lifeline_records');
            // exit();
            if($consentFile64['status']=="success"){
              //echo "base64 success";
              $fileData = [
                "customer_id"=>$customerData[0]['customer_id'],
                "filepath"=>$consentFile64['URL'],
                "type_doc"=>"Consent"
              ];
              $uploadConsent=UploadDocument($credentials[0], $row[0]['order_id'], $consentFile64['docName'], $consentFile64['pdfBase64'], '100025');
              //$uploadConsent['customer_id']=$customerId;
              $processData['process_status']="submitting Consent API";
              $enrollModel->updateData($processData,'lifeline_records');
              $saveCreateLog=[
                "customer_id"=>$customerId,
                "url"=>$uploadConsent['url'],
                "request"=>$uploadConsent['request'],
                "response"=>json_encode($uploadConsent['response']),
                "title"=>$uploadConsent['title']
              ];
              $enrollModel->saveData($saveCreateLog,'lifeline_apis_log');
              if($uploadConsent['status']=="success"){
                
                $fileData['to_unavo']='1';
                $result=[
                  "status"=>"success",
                  "msg"=>"Consent file submitted"
                ];
              }else{
                  $result=[
                  "status"=>"success",
                  "msg"=>"Something went wrong uploading your file"
                ];
              }
              $fileData['statusScreen']=($enrollModel->saveData($fileData,'lifeline_documents'))?true:false;
              
              
              //echo "after orderId>0";
              $dataOrder=[
                "customer_id"=>$customerId,
                "process_status"=>$result['msg']
              ];
              $enrollModel->updateData($dataOrder,"lifeline_records");
              //   $result = [
              //   "status"=>"success",
              //   "msg"=>"Shockwave process Success"
              // ];
            }else{
              //echo "base64 error";
              $result=[
                "status"=>"success",
                "msg"=>"We couldn't create a consent file"
              ];
               $processData['process_status']="Couldn't create a consent file";
              $enrollModel->updateData($processData,'lifeline_records');
            }
            
            //print_r($result);
          }else{
              //echo "else orderId 0";
            $dataOrder=[
              "customer_id"=>$customerId,
              "order_id"=>$createResponse['order_id'],
              "account"=>$createResponse['account'],
              "acp_status"=>$createResponse['acp_status'],
              "status_text"=>$createResponse['status_text'],
              "process_status"=>"Shockwave process success"
            ];
            $enrollModel->updateData($dataOrder,"lifeline_records");
              $result = [
              "status"=>"success",
              "msg"=>"Shockwave process Success"
            ];
          }
          //print_r($result);

        }else{
          
          $result = [
          "status"=>"success",
          "msg"=>"Something went wrong submitting your application"
        ];
        $processData['process_status']="Something went wrong submitting your application";
        $enrollModel->updateData($processData,'lifeline_records');
        }
        //print_r($result);
      }else{
        $result = [
          "status"=>"error",
          "msg"=>"Invalid Customer ID"
        ];
      }
      //print_r($result);
      return $result;
    }

    public function getIdfile($customerID,$enrollModel){
      $checkID = $enrollModel->checkIdFile($customerID);
      //print_r($checkID);
      return $checkID;
    }

    public function getConsentFile($orderId){

        //echo URLROOT.'/public/files/consentPDF/';
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => URLROOT.'/public/files/consentPDF/',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
            "orderId":'.$orderId.'
        }',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
          ),
        ));

        $response = curl_exec($curl);
        $curl_error = curl_error($curl);
        $curl_errno = curl_errno($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        
        // Step 1: Check if cURL itself failed (connection problems, timeouts, DNS, etc.)
        if ($curl_errno) {
            //echo "cURL error: $curl_error"; // This includes many kinds of outages
            $result = [
              "status"=>"error",
              "msg"=>$curl_error
            ];
            // Optionally log or retry here
        } 
        // Step 2: Check if API returned an HTTP error
        elseif ($http_code >= 400) {
            //echo "API HTTP error: $http_code";
            $result = [
              "status"=>"error",
              "msg"=>"HTTP ERROR CODE: ".$http_code
            ];
            // Optional: you might want to parse $response for error details
        }
        // Step 3: All good
        else {
            $result = json_decode($response,true);
        }
        return $result;

    }
}
