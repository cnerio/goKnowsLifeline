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