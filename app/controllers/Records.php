<?php
  class Records extends Controller {
    public $recordsModel;
    public $enrollsModel;
    public $userModel;
    public function __construct(){
        if(!isLoggedIn()){
            redirect('users/login');
        }

        $this->recordsModel = $this->model('Record');
        $this->enrollsModel = $this->model('Enroll'); 
        $this->userModel = $this->model('User');
    }

    public function getPrograms(){
		$row = $this->recordsModel->getProgram();
		echo json_encode($row);
	}

    public function getProgramNames($idprogram){
		$row = $this->recordsModel->getProgramNames($idprogram);
        //print_r($row);
		echo json_encode($row[0]);
	}

    public function index(){
        $this->view("records/index");
    }

    public function read(){
			if($_SERVER['REQUEST_METHOD']=='POST'){
		//if($_POST){
			//die('Submit');
			$_POST= filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
			$page = (isset($_POST['page']) && !empty($_POST['page']))?$_POST['page']:1;
			$data = [
				'action'=>trim($_POST['action']),
				'firstload'=>$_POST['firstload'],
				'arrayCampos'=>(empty($_POST['search']))?[]:$_POST['search'],
				'order_by'=>'created_at desc',
				'length'=>$_POST['length'],
				'page'=>$page,
				'per_page'=>'',
				'adjacents'=>'',
				'offset'=>'',
				'offsetToShow'=>'',
				'numrows'=>'',
				'total_pages'=>'',
				'c'=>'',
				'pagination'=>'',
			];
			//print_r($data);
			//die('Submit');
		}else{
			$data = [
				'action'=>'',
				'firstload'=>'YES',
				'arrayCampos'=>[],
				'order_by'=>'date(created_at) desc',
				'length'=>10,
				'page'=>1,
				'per_page'=>'',
				'adjacents'=>'',
				'offset'=>'',
				'offsetToShow'=>'',
				'numrows'=>'',
				'total_pages'=>'',
				'c'=>'',
				'pagination'=>'',
				'fields'=>'',
			];
				}
			
			
		
			//print_r($data);
			$camposBase=array("customer_id","first_name","second_name","phone_number","email","dob","city","state","zipcode","order_id","program_benefit","created_at","source");
			$addWhere="";
			for($index=0;$index<count($data['arrayCampos']);$index++){
				$count += ($ArrayCampos[$index]!='')?1:0;
				
					if(!empty($data['arrayCampos'][$index])){

							if($count<=1){
								$addWhere.=" ".$camposBase[$index]." LIKE '%".$data['arrayCampos'][$index]."%'";
							}else{
								$addWhere.=" and ".$camposBase[$index]." LIKE '%".$data['arrayCampos'][$index]."%'";
							}


					}
				}
			//$status  = $this->getOrderStatus();
			
			$consultaBusqueda = "";
			$contarCuantasBusquedas = 0;
            $camposAscDesc="";
			$per_page = $data['length']; //la cantidad de registros que desea mostrar
			$adjacents  = 2; //brecha entre páginas después de varios adyacentes
			$offset = ($data['page'] - 1) * $per_page;
			$offsetnumeroMostrar = ($data['page']-1) * $per_page + 1;
			$numrows = $this->recordsModel->countRegisters($addWhere,$data['firstload']);
			$total_pages = ceil($numrows/$per_page);
			$reload = 'index.php';
			$data['per_page']=$per_page;
			$data['adjacents']=$adjacents;
			$data['offset']=$offset;
			$data['offsetToShow'] = $offsetnumeroMostrar;
			$data['numrows']=$numrows;
			$data['total_pages']=$total_pages;
			$paginate = $this->paginate($reload,$data['page'] , $total_pages, $adjacents, $data['arrayCampos'],$data['length'],$camposAscDesc);
			$data['pagination']=$paginate;
			//$per_page = 30; //la cantidad de registros que desea mostrar
			
			$getOrders = $this->recordsModel->getData($data['offset'],$data['per_page'],$addWhere,$data['order_by'], $data['firstload']);

			$data['fields']=$getOrders;
		
			echo json_encode($data);
			//return $getOrders;
			
			//$this->view('dashboard/index',$data);
		//header('Content-type: application/json; charset=utf-8');
			
		}

	
	
	public function paginate($reload, $page, $tpages, $adjacents,$ArrayCampos,$example_length,$camposAscDesc) {

		//$ArrayCampos="";
			$ArrayCampos = json_encode($ArrayCampos);
			$camposAscDesc = json_encode($camposAscDesc);
			//print("<pre>".print_r($ArrayCampos,true)."</pre>");
			//$camposAscDesc="";
		
			$prevlabel = "&lsaquo;";
			$nextlabel = "&rsaquo;";
			$out = '<ul class="pagination">';
			 
			// previous label
		
			if($page==1) {
				$out.= "<li class='page-item disabled'><span><a class='page-link'>$prevlabel</a></span></li>";
			} else if($page==2) {
				$out.= "<li class='page-item'><a class='page-link' href='javascript:void(0);' onclick='load(1,".$ArrayCampos.",".$example_length.",".$camposAscDesc.")'>$prevlabel</a></li>";
			}else {
				$out.= "<li class='page-item'><a class='page-link' href='javascript:void(0);' onclick='load(".($page-1).",$ArrayCampos,$example_length,$camposAscDesc)'>$prevlabel</a></li>";
		
			}
			
			// first label
			if($page>($adjacents+1)) {
				$out.= "<li class='page-item'><a class='page-link' href='javascript:void(0);' onclick='load(1,".$ArrayCampos.",".$example_length.",".$camposAscDesc.")'>1</a></li>";
			}
			// interval
			if($page>($adjacents+2)) {
				$out.= "<li class='page-item'><a class='page-link'>...</a></li>";
			}
		
			// pages
		
			$pmin = ($page>$adjacents) ? ($page-$adjacents) : 1;
			$pmax = ($page<($tpages-$adjacents)) ? ($page+$adjacents) : $tpages;
			for($i=$pmin; $i<=$pmax; $i++) {
				if($i==$page) {
					$out.= "<li class='page-item active'><a class='page-link'>$i</a></li>";
				}else if($i==1) {
					$out.= "<li class='page-item'><a class='page-link' href='javascript:void(0);' onclick='load(1,".$ArrayCampos.",".$example_length.",".$camposAscDesc.")'>$i</a></li>";
				}else {
					$out.= "<li class='page-item'><a class='page-link' href='javascript:void(0);' onclick='load(".$i.",$ArrayCampos,$example_length,$camposAscDesc)'>$i</a></li>";
				}
			}
		
			// interval
		
			if($page<($tpages-$adjacents-1)) {
				$out.= "<li class='page-item'><a class='page-link'>...</a></li>";
			}
		
			// last
		
			if($page<($tpages-$adjacents)) {
				$out.= "<li class='page-item'><a class='page-link' href='javascript:void(0);' onclick='load($tpages,".$ArrayCampos.",".$example_length.",".$camposAscDesc.")'>$tpages</a></li>";
			}
		
			// next
		
			if($page<$tpages) {
				$out.= "<li class='page-item'><span><a class='page-link' href='javascript:void(0);' onclick='load(".($page+1).",$ArrayCampos,$example_length,$camposAscDesc)'>$nextlabel</a></span></li>";
			}else {
				$out.= "<li class='page-item disabled'><span><a class='page-link'>$nextlabel</a></span></li>";
			}
			
			$out.= "</ul>";
			return $out;
		}

        public function edit($customerId){
            $data = $this->recordsModel->getCustomerInfo($customerId);
            //print_r($data);
            $this->view("records/edit",$data);
        }

    public function getStaffs(){
		/*if($_SERVER['REQUEST_METHOD']=='POST'){
			$_POST= filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
			$source = $_POST['source'];*/
			$row = $this->userModel->getStaff();
			echo json_encode($row);
		/*}*/
	}

    public function getNotes(){
		if($_SERVER['REQUEST_METHOD']=='POST'){
			$_POST= filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
			$customer_id = $_POST['customer_id'];
			$row = $this->recordsModel->getNotes($customer_id);
			echo json_encode($row);
		}
	}

    	public function getResponses(){
		if($_SERVER['REQUEST_METHOD']=='POST'){
			$_POST= filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
			$customer_id = $_POST['customer_id'];
			$row = $this->recordsModel->getResponses($customer_id);
			echo json_encode($row);
		}
	}

}