<?php
  class Enrolls extends Controller {
    public $enrollModel;
    public function __construct(){
      $this->enrollModel = $this->model('Enroll');
    }
    
    public function index2(){
      echo $projectRoot = '../public/uploads/';
      //echo $uploadFolder = $projectRoot . '/public/uploads/';
      // if(isLoggedIn()){
      //   redirect('posts');
      // }
      $data = [
        'title' => 'SharePosts',
        'description' => 'Simple social network built on the Emmizy MVC framework',
        'info' => 'You can contact me with the following details below if you like my program and willing to offer me a contract and work on your project',
        'name' => 'Omonzebaguan Emmanuel',
        'location' => 'Nigeria, Edo State',
        'contact' => '+2348147534847',
        'mail' => 'emmizy2015@gmail.com'
      ];
     
      $this->view('pages/index', $data);
    }

    public function index(){
      $data = [
        'title' => 'About Us',
        'description' => 'App to share posts with other users'
      ];

      $this->view('enrolls/index', $data);
    }

    public function ca(){
      $data = [
          'title' => 'Contact Us',
          'description' => 'You can contact us through this medium',
          'info' => 'You can contact me with the following details below if you like my program and willing to offer me a contract and work on your project',
          'name' => 'Omonzebaguan Emmanuel',
          'location' => 'Nigeria, Edo State',
          'contact' => '+2348147534847',
          'mail' => 'emmizy2015@gmail.com'
      ];

      $this->view('enrolls/ca', $data);
    }

    public function genCustomerId($data,$lastId){
      $flfn = ($data['first_name'])?strtoupper(substr($data['first_name'], 0, 1)):"X";
      $flsn = ($data['second_name'])?strtoupper(substr($data['second_name'], 0, 1)):"X";
      $fdpn = ($data['phone_number'])?substr($data['phone_number'],0,1):"0";
      $flea = ($data['email'])?strtoupper(substr($data['email'],0,1)):"X";
      $num = str_pad($lastId, 4, '0', STR_PAD_LEFT);

      $customerId="G-".$flfn.$flsn.$fdpn.$flea.$num;

      return $customerId;
    
    }

    public function savestep1(){
      if($_SERVER['REQUEST_METHOD']=='POST'){
        $phonenumber = preg_replace('/[^0-9]/', '', $_POST['phone']);
        $dob = date('Y-m-d', strtotime($_POST['dobY']."-".$_POST['dobD']."-".$_POST['dobM']));
        $data=[
          "first_name"=>trim(ucfirst(strtolower($_POST['firstname']))),
          "second_name"=>trim(ucfirst(strtolower($_POST['lastname']))),
          "ssn"=>trim($_POST['ssn']),
          "dob"=>$dob,
          "email"=>trim(strtolower($_POST['email'])),
          "phone_number"=>$phonenumber,
          "address1"=>trim($_POST['address1']),
          "address2"=>trim($_POST['addess2']),
          "city"=>trim(ucfirst(strtolower($_POST['city']))),
          "state"=>$_POST['state'],
          "zipcode"=>$_POST['zipcode'],
          "shipping_address1"=>(isset($_POST['shipaddress1'])?$_POST['shipaddress1']:null),
          "shipping_address2"=>(isset($_POST['shipaddess2']))?$_POST['shipaddess2']:null,
          "shipping_city"=>(isset($_POST['shipcity']))?$_POST['shipcity']:null, 
          "shipping_state"=>(isset($_POST['shipstate']))?$_POST['shipstate']:null, 
          "shipping_zipcode"=>(isset($_POST['shipzipcode']))?$_POST['shipzipcode']:null,
          "order_step"=>"Step 1",
          "URL"=>$_POST['url'],
          "company"=>$_POST['company']
        ];
        $lastId = $this->enrollModel->saveData($data,'lifeline_records');
        
        if($lastId>0){
          //$data['lastId']=$lastId;
          $customerId = $this->genCustomerId($data,$lastId);
          $this->enrollModel->updateCusId($lastId,$customerId,'lifeline_records');
          $data['customer_id']=$customerId;
          $data['status']="success";
        }else{
          $data['status']="fail";
        }
        //print_r($data);
        echo json_encode($data);
      }
    }

    public function savestep2(){
      if($_SERVER['REQUEST_METHOD']=="POST"){
        //print_r($_POST);
        $data=[
          "program_benefit"=>$_POST['eligibility_program'],
          "nverification_number"=>trim($_POST['nv_application_id']),
          "customer_id"=>$_POST['customer_id'],
          "current_benefits" => $_POST['current_benefits'],
          "phone_type"=>$_POST['type_phone'],
          "order_step"=>"Step 2"
          
        ];

        $this->enrollModel->updateData($data,'lifeline_records');
        if(!empty($_POST['govId'])){
          $base64_string = $_POST['govId'];
          $customer_id = $data['customer_id'];
          $filepath = saveBase64File($base64_string,$customer_id,"ID");
          $fileData = [
            "customer_id"=>$customer_id,
            "filepath"=>$filepath,
            "type_doc"=>"ID"
          ];
          $fileData['statusFile']=($this->enrollModel->saveData($fileData,'lifeline_documents'))?true:false;
        }else{
          $fileData['statusFile']=true;
        }
        

        echo json_encode($fileData);
      }
    }

    public function savestep3(){
      if($_SERVER['REQUEST_METHOD']=="POST"){
        //print_r($_POST);
        $data=[
          "signature_text"=>trim($_POST['signaturename']),
          "datetimeConsent"=>$_POST['datetimeconsent'],
          "agree_terms"=>$_POST['terms'],
          "agree_sms"=>$_POST['sms'],
          "agree_pii"=>$_POST['know'],
          "customer_id"=>$_POST['customer_id'],
          "order_step"=>"Step 3"
        ];

        $this->enrollModel->updateData($data,'lifeline_records');
        $initialData=[
          "initials1"=>trim(strtoupper($_POST['initials_1'])),
          "initials2"=>trim(strtoupper($_POST['initials_2'])),
          "initials3"=>trim(strtoupper($_POST['initials_3'])),
          "initials4"=>trim(strtoupper($_POST['initials_4'])),
          "initials5"=>trim(strtoupper($_POST['initials_5'])),
          "initials6"=>trim(strtoupper($_POST['initials_6'])),
          "initials7"=>trim(strtoupper($_POST['initials_7'])),
          "initials8"=>trim(strtoupper($_POST['initials_8'])),
          "initials9"=>trim(strtoupper($_POST['initials_9'])),
          "customer_id"=>$data['customer_id']
        ];

        $initialData['statusfinale']=($this->enrollModel->saveData($initialData,'lifeline_agreement'))?true:false;
        //echo json_encode($initialData);

       // $customerData = $this->enrollModel->getCustomerData($data['customer_id']);
        $result = $this->shockwaveProcess($data['customer_id']);

        echo json_encode($result);

      }
    }

    public function shockwaveProcess($customerId){
      //'G-SN3C0031'
      
        $customerData = $this->enrollModel->getCustomerData($customerId);
       
        if($customerData && $customerData[0]['customer_id']){
         
        $credentials=$this->enrollModel->getCredentials();
        $processData['customer_id']=$customerId;
    
        $createResponse=create_shockwave_accountTEST2($customerData[0],$credentials[0]);
        
        $processData['process_status']="addSubscriberOrder API";
        $this->enrollModel->updateData($processData,'lifeline_records');
        
        $saveCreateLog=[
          "customer_id"=>$customerId,
          "url"=>$createResponse['url'],
          "request"=>$createResponse['request'],
          "response"=>$createResponse['response'],
          "title"=>$createResponse['title']
        ];
        
        $this->enrollModel->saveData($saveCreateLog,'lifeline_apis_log');
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
              $this->enrollModel->updateData($dataOrder,"lifeline_records");

            $consentFile64=$this->getConsentFile($createResponse['order_id']);
            // print_r($consentFile64);
              $processData['process_status']="generating consent File";
              $this->enrollModel->updateData($processData,'lifeline_records');
            // exit();
            if($consentFile64['status']=="success"){
              //echo "base64 success";
              $fileData = [
                "customer_id"=>$customerData[0]['customer_id'],
                "filepath"=>$consentFile64['URL'],
                "type_doc"=>"Consent"
              ];
              $uploadConsent=UploadDocumentTest($credentials[0], $createResponse['order_id'], $consentFile64['docName'], $consentFile64['pdfBase64'], '100025');
              //$uploadConsent['customer_id']=$customerId;
              $processData['process_status']="submitting Consent API";
              $this->enrollModel->updateData($processData,'lifeline_records');
              $saveCreateLog=[
                "customer_id"=>$customerId,
                "url"=>$uploadConsent['url'],
                "request"=>$uploadConsent['request'],
                "response"=>json_encode($uploadConsent['response']),
                "title"=>$uploadConsent['title']
              ];
              $this->enrollModel->saveData($saveCreateLog,'lifeline_apis_log');
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
              $fileData['statusScreen']=($this->enrollModel->saveData($fileData,'lifeline_documents'))?true:false;
              
              
              //echo "after orderId>0";
              $dataOrder=[
                "customer_id"=>$customerId,
                "process_status"=>$result['msg']
              ];
              $this->enrollModel->updateData($dataOrder,"lifeline_records");
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
              $this->enrollModel->updateData($processData,'lifeline_records');
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
            $this->enrollModel->updateData($dataOrder,"lifeline_records");
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
        $this->enrollModel->updateData($processData,'lifeline_records');
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

    public function savescreen(){
      if($_SERVER['REQUEST_METHOD']=="POST"){
        $base64_string = $_POST['base64screen'];
          $customer_id = $_POST['customer_id'];
          $filepath = saveBase64File($base64_string,$customer_id,"Screenshot");
          $fileData = [
            "customer_id"=>$customer_id,
            "filepath"=>$filepath,
            "type_doc"=>"Screenshot"
          ];
          $fileData['statusScreen']=($this->enrollModel->saveData($fileData,'lifeline_documents'))?true:false;
          echo json_encode($fileData);
      }
    }

    public function checkZipcode($zipcode,$state,$city){

      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://api.zippopotam.us/us/'.trim($zipcode),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
      ));

      $response = curl_exec($curl);

      
      $curl_error = curl_error($curl);
        $curl_errno = curl_errno($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
      // Step 1: Check if cURL itself failed (connection problems, timeouts, DNS, etc.)
        if ($curl_errno) {
            //echo "cURL error: $curl_error"; // This includes many kinds of outages
            $row = [
              "status"=>"error",
              "msg"=>$curl_error
            ];
            // Optionally log or retry here
        } 
        // Step 2: Check if API returned an HTTP error
        elseif ($http_code >= 400) {
            //echo "API HTTP error: $http_code";
            $row = [
              "status"=>"error",
              "msg"=>"HTTP ERROR CODE: ".$http_code
            ];
            // Optional: you might want to parse $response for error details
        }
        // Step 3: All good
        else {
            $result = json_decode($response,true);
            print_r($result);
            echo $state;
            if($result['places']){
              if(strtoupper($state)==$result['places'][0]['state abbreviation'] && trim(ucfirst(strtolower($city)))==$result['places'][0]['place name'] ){
                $row = [
              "status"=>"success",
              "msg"=>"state and city match"
            ];
              }else{
                                $row = [
              "status"=>"error",
              "msg"=>"state and city does not match"
            ];
              }
            }else{
                              $row = [
              "status"=>"error",
              "msg"=>"city and state couldn't be validated "
            ];

            }
        }

        print_r($row);

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

    public function thankyou(){
      $this->view('enrolls/thankyou');
    }

    public function check(){
      //$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
          $data=[
            "email"=>trim(strtolower($_POST['email'])),
            "zipcode"=>trim($_POST['zipcode']),
            "status"=>"success"
          ];
          echo json_encode($data);
        }
    }

    public function getprograms(){
      $row = $this->enrollModel->getLifelinePrograms();
      //print_r($row);
      echo json_encode($row);
    }

    public function getagreementitems($states){
      $row = $this->enrollModel->getAgreementsItems($states);
      //print_r($row);
      echo json_encode($row);
    }
  }