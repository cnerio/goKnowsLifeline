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
          "email"=>trim($_POST['email']),
          "phone_number"=>$phonenumber,
          "address1"=>trim($_POST['address1']),
          "address2"=>trim($_POST['addess2']),
          "city"=>$_POST['city'],
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
        echo json_encode($initialData);
      }
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