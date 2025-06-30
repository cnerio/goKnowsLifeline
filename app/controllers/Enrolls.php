<?php
class Enrolls extends Controller
{
  public $enrollModel;
  public $APIService;
  public function __construct()
  {
    $this->enrollModel = $this->model('Enroll');
  }

  public function index2()
  {
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

  public function index()
  {
    $data = [
      'title' => 'About Us',
      'description' => 'App to share posts with other users'
    ];

    $this->view('enrolls/index', $data);
  }

  public function ca()
  {
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

  public function genCustomerId($data, $lastId)
  {
    $flfn = ($data['first_name']) ? strtoupper(substr($data['first_name'], 0, 1)) : "X";
    $flsn = ($data['second_name']) ? strtoupper(substr($data['second_name'], 0, 1)) : "X";
    $fdpn = ($data['phone_number']) ? substr($data['phone_number'], 0, 1) : "0";
    $flea = ($data['email']) ? strtoupper(substr($data['email'], 0, 1)) : "X";
    $num = str_pad($lastId, 4, '0', STR_PAD_LEFT);

    $customerId = "G-" . $flfn . $flsn . $fdpn . $flea . $num;

    return $customerId;
  }

  public function savestep1()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      $post_data = http_build_query(
          array(
              'secret' => "6Lc3rlsrAAAAAPisCZMU480WzdRQCua2JsT-E5GD",
              'response' => $_POST['g-recaptcha-response'],
              'remoteip' => $_SERVER['REMOTE_ADDR']
          )
      );
      $opts = array('http' =>
          array(
              'method'  => 'POST',
              'header'  => 'Content-type: application/x-www-form-urlencoded',
              'content' => $post_data
          )
      );


      $context  = stream_context_create($opts);
      $response = file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context);
      $result = json_decode($response);
      //print_r($result);
      if (!$result->success) {
        $data['status'] = "fail";
        $data['msg']= 'CAPTCHA verification failed';
      }else{
        $phonenumber = preg_replace('/[^0-9]/', '', $_POST['phone']);
        $dob = date("m/d/Y", strtotime($_POST['dobM'] . "/" . $_POST['dobD'] . "/" . $_POST['dobY']));
        if(isset($_POST['customer_id'])){
          $customer_id = $_POST['customer_id'];
        }else{
          $customer_id =null;
        };
        $data = [
          "first_name" => trim(ucfirst(strtolower($_POST['firstname']))),
          "second_name" => trim(ucfirst(strtolower($_POST['lastname']))),
          "ssn" => trim($_POST['ssn']),
          "dob" => $dob,
          "email" => trim(strtolower($_POST['email'])),
          "phone_number" => $phonenumber,
          "address1" => trim($_POST['address1']),
          "address2" => trim($_POST['addess2']),
          "city" => trim(ucfirst(strtolower($_POST['city']))),
          "state" => $_POST['state'],
          "zipcode" => $_POST['zipcode'],
          "shipping_address1" => (isset($_POST['shipaddress1']) ? $_POST['shipaddress1'] : null),
          "shipping_address2" => (isset($_POST['shipaddess2'])) ? $_POST['shipaddess2'] : null,
          "shipping_city" => (isset($_POST['shipcity'])) ? $_POST['shipcity'] : null,
          "shipping_state" => (isset($_POST['shipstate'])) ? $_POST['shipstate'] : null,
          "shipping_zipcode" => (isset($_POST['shipzipcode'])) ? $_POST['shipzipcode'] : null,
          "order_step" => "Step 1",
          "URL" => $_POST['url'],
          "company" => $_POST['company'],
          "utm_source" => (isset($_GET['utm_source'])) ? $_GET['utm_source'] : null,
          "utm_medium" => (isset($_GET['utm_medium'])) ? $_GET['utm_medium'] : null,
          "utm_campaign" => (isset($_GET['utm_campaign'])) ? $_GET['utm_campaign'] : null,
          "utm_content" => (isset($_GET['utm_content'])) ? $_GET['utm_content'] : null,
          "match_type" => (isset($_GET['match_type'])) ? $_GET['match_type'] : null,
          "utm_adgroup" => (isset($_GET['utm_adgroup'])) ? $_GET['utm_adgroup'] : null,
          "gclid" => (isset($_GET['gclid'])) ? $_GET['gclid'] : null,
          "fbclid" => (isset($_GET['fbclid'])) ? $_GET['fbclid'] : null
        ];
        if($customer_id){
          $data['customer_id']=$customer_id;
          
          $this->enrollModel->updateData($data, 'lifeline_records');
            //$data['customer_id'] = $customerId;
            $data['status'] = "success";
            $data['action']="update";
        }else{
          $lastId = $this->enrollModel->saveData($data, 'lifeline_records');
          
          if ($lastId > 0) {
            //$data['lastId']=$lastId;
            $customerId = $this->genCustomerId($data, $lastId);
            $this->enrollModel->updateCusId($lastId, $customerId, 'lifeline_records');
            $data['customer_id'] = $customerId;
            $data['action']="insert";
            $data['status'] = "success";
          } else {
            $data['status'] = "fail";
          }
        }
        
      }
      //print_r($data);
      echo json_encode($data);
    }
  }

  public function savestep2()
  {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
      //print_r($_POST);
      $data = [
        "program_benefit" => $_POST['eligibility_program'],
        "nverification_number" => trim($_POST['nv_application_id']),
        "customer_id" => $_POST['customer_id'],
        "current_benefits" => $_POST['current_benefits'],
        "phone_type" => $_POST['type_phone'],
        "order_step" => "Step 2"

      ];

      $this->enrollModel->updateData($data, 'lifeline_records');
      if (!empty($_POST['govId'])) {
        $base64_string = $_POST['govId'];
        $customer_id = $data['customer_id'];
        $filepath = saveBase64File($base64_string, $customer_id, "ID");
        $fileData = [
          "customer_id" => $customer_id,
          "filepath" => $filepath,
          "type_doc" => "ID"
        ];
        $fileData['statusFile'] = ($this->enrollModel->saveData($fileData, 'lifeline_documents')) ? true : false;
      } else {
        $fileData['statusFile'] = true;
      }


      echo json_encode($fileData);
    }
  }

  public function savestep3()
  {
      // Inicia sesión solo si no ha sido iniciada aún
  if (session_status() !== PHP_SESSION_ACTIVE) {
      session_start();
  }

    // Prevent multiple submissions within a short time
    if (isset($_SESSION['form_submitted']) && $_SESSION['form_submitted'] === true) {
        echo json_encode(['error' => 'Form already submitted.']);
        exit;
    }

    // Mark the form as submitted
    $_SESSION['form_submitted'] = true;

    try {
      if ($_SERVER['REQUEST_METHOD'] == "POST") {
        //print_r($_POST);
        $data = [
          "signature_text" => trim($_POST['signaturename']),
          "datetimeConsent" => $_POST['datetimeconsent'],
          "agree_terms" => $_POST['terms'],
          "agree_sms" => $_POST['sms'],
          "agree_pii" => $_POST['know'],
          "customer_id" => $_POST['customer_id'],
          "order_step" => "Step 3"
        ];

        $this->enrollModel->updateData($data, 'lifeline_records');
        $initialData = [
          "initials1" => trim(strtoupper($_POST['initials_1'])),
          "initials2" => trim(strtoupper($_POST['initials_2'])),
          "initials3" => trim(strtoupper($_POST['initials_3'])),
          "initials4" => trim(strtoupper($_POST['initials_4'])),
          "initials5" => trim(strtoupper($_POST['initials_5'])),
          "initials6" => trim(strtoupper($_POST['initials_6'])),
          "initials7" => trim(strtoupper($_POST['initials_7'])),
          "initials8" => trim(strtoupper($_POST['initials_8'])),
          "initials9" => trim(strtoupper($_POST['initials_9'])),
          "customer_id" => $data['customer_id']
        ];

        $initialData['statusfinale'] = ($this->enrollModel->saveData($initialData, 'lifeline_agreement')) ? true : false;
        //echo json_encode($initialData);

        // $customerData = $this->enrollModel->getCustomerData($data['customer_id']);
        $this->APIService = new APIprocess();
        $result = $this->APIService->shockwaveProcess($data['customer_id'], $this->enrollModel);

        $row2 = $this->enrollModel->getCustomerData($data['customer_id']);
        $this->sendNotification($row2[0]);

        echo json_encode($result);
      }
    } catch (Exception $e) {
    echo json_encode(['status' => 'error','msg' => 'An error occurred: ' . $e->getMessage()]);
    } finally {
        // Reset the form submitted flag after a short period or once the request is done
        $_SESSION['form_submitted'] = false;
    }
  }

  public function sendIdFile($customerId){
    $this->APIService = new APIprocess();
    $row = $this->enrollModel->getCustomerData($customerId);
    //print_r($row);
    $checkID = $this->APIService->getIdfile($customerId,$this->enrollModel);
    $credentials=$this->enrollModel->getCredentials();
    if($row[0]['order_id']>0){
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
                  $this->enrollModel->saveData($saveCreateIDLog,'lifeline_apis_log');
                  $fileId = ["customer_id"=>$customerId,"to_unavo"=>1];
                 // $enrollModel->saveData($fileId,'lifeline_documents');
                 $this->enrollModel->updateData($fileId ,'lifeline_documents');
                 echo "ID FILE UPLOADED";
                }else{
                echo "ID FILE COULDN'T BE UPLOAD";
              }
              }else{
                echo "ID FILE NOT FOUND";
              }
    }else{
      echo "ORDER ID NOT FOUND";
    }
  }

  public function testprocess()
  {
    $this->APIService = new APIprocess();
    $row = $this->APIService->getIdfile('G-TT3E0002',$this->enrollModel);
    //print_r($row);
    if($row){
      // Read the image file into a binary string
    $imageData = file_get_contents($row['filepath']);

    // Encode the binary data to base64
    $base64 = base64_encode($imageData);
    //echo $base64;
    }else{
      echo "File not found";
    }
    //$row2 = $this->enrollModel->getCustomerData('G-SN3X0005');
    //$this->sendNotification($row2[0]);
  }

 

  public function savescreen()
  {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
      $base64_string = $_POST['base64screen'];
      $customer_id = $_POST['customer_id'];
      $filepath = saveBase64File($base64_string, $customer_id, "Screenshot");
      $fileData = [
        "customer_id" => $customer_id,
        "filepath" => $filepath,
        "type_doc" => "Screenshot"
      ];
      $fileData['statusScreen'] = ($this->enrollModel->saveData($fileData, 'lifeline_documents')) ? true : false;
      echo json_encode($fileData);
    }
  }

  public function checkZipcode($zipcode, $state, $city)
  {

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'http://api.zippopotam.us/us/' . trim($zipcode),
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
        "status" => "error",
        "msg" => $curl_error
      ];
      // Optionally log or retry here
    }
    // Step 2: Check if API returned an HTTP error
    elseif ($http_code >= 400) {
      //echo "API HTTP error: $http_code";
      $row = [
        "status" => "error",
        "msg" => "HTTP ERROR CODE: " . $http_code
      ];
      // Optional: you might want to parse $response for error details
    }
    // Step 3: All good
    else {
      $result = json_decode($response, true);
      print_r($result);
      echo $state;
      if ($result['places']) {
        if (strtoupper($state) == $result['places'][0]['state abbreviation'] && trim(ucfirst(strtolower($city))) == $result['places'][0]['place name']) {
          $row = [
            "status" => "success",
            "msg" => "state and city match"
          ];
        } else {
          $row = [
            "status" => "error",
            "msg" => "state and city does not match"
          ];
        }
      } else {
        $row = [
          "status" => "error",
          "msg" => "city and state couldn't be validated "
        ];
      }
    }

    print_r($row);
  }

  public function getConsentFile($orderId)
  {

    //echo URLROOT.'/public/files/consentPDF/';
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => URLROOT . '/public/files/consentPDF/',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => '{
            "orderId":' . $orderId . '
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
        "status" => "error",
        "msg" => $curl_error
      ];
      // Optionally log or retry here
    }
    // Step 2: Check if API returned an HTTP error
    elseif ($http_code >= 400) {
      //echo "API HTTP error: $http_code";
      $result = [
        "status" => "error",
        "msg" => "HTTP ERROR CODE: " . $http_code
      ];
      // Optional: you might want to parse $response for error details
    }
    // Step 3: All good
    else {
      $result = json_decode($response, true);
    }
    return $result;
  }

  public function thankyou()
  {
    $this->view('enrolls/thankyou');
  }

  public function check()
  {
    //$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $data = [
        "email" => trim(strtolower($_POST['email'])),
        "zipcode" => trim($_POST['zipcode']),
        "status" => "success"
      ];
      echo json_encode($data);
    }
  }

  public function getprograms()
  {
    $row = $this->enrollModel->getLifelinePrograms();
    //print_r($row);
    echo json_encode($row);
  }

  public function getagreementitems($states)
  {
    $row = $this->enrollModel->getAgreementsItems($states);
    //print_r($row);
    echo json_encode($row);
  }

  public function sendNotification($custmerData)
  {

    //$fullname = ucfirst(strtolower($data['firstname']))." ".ucfirst(strtolower($data['lastname']));
    $message = '<table role="presentation" class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background: #ffffff; border-radius: 3px; width: 100%;" width="100%">
  <!-- START MAIN CONTENT AREA -->
  <tr>
    <td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;" valign="top"><table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;" width="100%">
        <tr>
          <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top"><p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">Hello!</p>
            <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">New Lifeline Order has been submitted </p>
            <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><strong>First Name: </strong>' . $custmerData['first_name'] . '</p>
            <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><strong>Last Name: </strong>' . $custmerData['second_name'] . '</p>
            <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><strong>Email: </strong>' . $custmerData['email'] . '</p>
            <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><strong>City: </strong>' . $custmerData['city'] . '</p>
			<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><strong>State: </strong>' . $custmerData['state'] . '</p>
            <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><strong>Order ID: </strong>' . $custmerData['order_id'] . '</p>
			
			<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><strong>Shockwave API Response: </strong>' . $custmerData['acp_status'] . '</p>
			</td>
        </tr>
      </table>
      </td>
  </tr>
  <!-- END MAIN CONTENT AREA -->
</table>';
    //$message = preg_replace($subtr,$sust,$template );

    $mailer = new PHPMailer_Lib();
    $mail = $mailer->load();
    $mail->SMTPDebug = 0;                                       // Enable verbose debug output
    $mail->isSMTP();                                            // Set mailer to use SMTP
    $mail->Host       = 'smtp-mail.outlook.com';            // Specify main and backup SMTP servers
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'lifeline@goknows.com';                     // SMTP username
    $mail->Password   = 'D*391924961273uc';                               // SMTP password
    $mail->SMTPSecure = 'TLS/StartTLS';                                  // Enable TLS encryption, `ssl` also accepted
    $mail->Port       = 587;                                 // TCP port to connect to
    //Recipients
    $mail->setFrom('lifeline@goknows.com', 'Lileline Orders');
    //$mail->addAddress('xneriox@gmail.com');
    $mail->addAddress('lifeline@goknows.com');
    //$mail->addCC('jparker@galaxydistribution.com'); 
    //$mail->addCC('currutia44@gmail.com');      // Add a recipient
    //$mail->addBCC('xneriox@gmail.com');
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'A new lifeline order has been submitted';
    $mail->Body    = $message;
    $mail->CharSet = 'UTF-8';
    $mail->send();
  }
}
