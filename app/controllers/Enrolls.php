<?php
  class Enrolls extends Controller {
    public $enrollModel;
    public function __construct(){
      $this->enrollModel = $this->model('Enroll');
    }
    
    public function index2(){
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
          "shipping_address1"=>(isset($_POST['shipaddress1'])?$_POST['shipaddress1']:""),
          "shipping_address2"=>(isset($_POST['shipaddess2']))?$_POST['shipaddess2']:"",
          "shipping_city"=>(isset($_POST['shipcity']))?$_POST['shipcity']:"", 
          "shipping_state"=>(isset($_POST['shipstate']))?$_POST['shipstate']:"", 
          "shipping_zipcode"=>(isset($_POST['shipzipcode']))?$_POST['shipzipcode']:"",
          "order_step"=>"Step 1"
        ];
        $lastId = $this->enrollModel->saveData($data,'lifeline_records');
        
        if($lastId>0){
          $data['lastId']=$lastId;
          $data['status']="success";
        }else{
          $data['status']="fail";
        }
        //print_r($data);
        echo json_encode($data);
      }
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