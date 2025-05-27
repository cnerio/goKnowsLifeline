<?php 
class Record {
	private $db;
	
	public function __construct(){
		$this->db = new Database;
	}
	
	
	public function saveApiLog($customer_id,$url,$request,$response,$title){
		$data=[
		"customer_id"=>$customer_id,
		"url"=>$url,
		"request"=>$request,
		"response"=>$response,
		"title"=>$title
		];
		$this->db->insertQuery("c1_surgephone.agent_acp_apis_log",$data);
	}
	
	public function internalNotes($data){
		/*$data=[
			"customer_id"=>$customer_id,
			"date_note"=>$date_note,
			"type_note"=>$type_note,
			"message_send"=>$message_send,
			"message_confirmation"=>$message_confirmation,
			"id_script"=>$id_script
			"id_user"=>$id_user
		];*/
		$this->db->insertQuery("c1_surgephone.internal_notes",$data);
	}
	
	public function updateOrder($data){
		$this->db->updateQuery("lifeline_records",$data,"id=:id");
	}
	
	public function countRegisters($search,$firstload){

			if ($firstload=="YES"){
				
					$this->db->query("SELECT count(*) as total FROM lifeline_records order by created_at  desc");

			}else{

				if ($search!="") {
					$this->db->query("SELECT count(*) as total FROM lifeline_records WHERE $search order by created_at desc");
				}else{
					$this->db->query("SELECT count(*) as total FROM lifeline_records order by created_at  desc");
				}


			}

			$this->db->execute();
			$count = $this->db->single();
			return $count['total'];
	}
	
	public function getProgram(){
		$this->db->query("SELECT * FROM lifeline_programs");
		$this->db->execute();
		$row = $this->db->resultSet();
		return $row;
	}

    public function getProgramNames($idProgram){
		$this->db->query("SELECT * FROM lifeline_programs WHERE id_program=:id_program");
        $this->db->bind(":id_program",$idProgram);
		$this->db->execute();
		$row = $this->db->resultSet();
		return $row;
	}
	

	
	public function getScript($source){
		$this->db->query("SELECT * FROM c1_surgephone.script WHERE source=:source");
		$this->db->bind("source",$source);
		$this->db->execute();
		$row = $this->db->resultSet();
		return $row;
	}
	
	
	public function getOrder($orderid){
		$this->db->query('SELECT ar.id,ar.customer_id,ar.first_name,ar.second_name,ar.phone_number,ar.email,ar.address1,ar.address2,ar.city,ar.state,ar.zipcode,ar.program_before,ar.program_benefit,ar.dob,ar.source,ar.fcc_agreement,ar.transferconsent,ar.order_status,ar.account,ar.order_id,ar.company,ar.acp_status,ed.filename,ar.ssn,ar.tookstaff,ar.shockwave_id,ar.surgepays_id FROM lifeline_records ar LEFT JOIN c1_surgephone.ebb_documents ed ON ed.customer_id = ar.customer_id WHERE ar.id=:id');
		$this->db->bind("id",$orderid);
		$getOrder = $this->db->single();
		return $getOrder;
		
	}

    public function getCustomerInfo($customer_id){
        $this->db->query('SELECT * FROM lifeline_records lr JOIN lifeline_programs lp ON lr.program_benefit = lp.id_program  WHERE customer_id=:id');
		$this->db->bind("id",$customer_id);
		$getOrder = $this->db->single();

        $this->db->query('SELECT * FROM lifeline_documents WHERE customer_id=:id');
        $this->db->bind("id",$customer_id);
		$getDocuments = $this->db->resultSet();
        
        $getOrder['documents']=$getDocuments;
		return $getOrder;
    }
	
	public function datatoExport(){
		$this->db->query('SELECT arc.customer_id as "CUSTOMER ID",arc.first_name as "FIRST NAME",arc.second_name as "LAST NAME",arc.phone_number as "PHONE NUMBER", arc.email as "EMAIL",arc.dob as "DOB",arc.address1 as "ADDRESS1",arc.address2 as "ADDRESS2",arc.city as "CITY",arc.state as "STATE",arc.zipcode as "ZIPODE", arc.program_before as "PROGRAM BEFORE", ebp.description as "PROGRAM BENEFIT",arc.order_id as "ORDER ID",arc.account as "ACCOUNT",arc.acp_status as "ACP STATUS",arc.company as "COMPANY ENROLLED",UPPER(arc.source) as "SOURCE",arc.created_at as "CREATED AT" FROM lifeline_records arc JOIN c1_surgephone.ebb_programs ebp ON ebp.type_id=arc.program_benefit;');
		$row = $this->db->resultSet();
		return $row;
	}
	
	public function getData($offset,$per_page,$search,$orderby,$firstload){
		$date_now = date('Y-m-d').'%';
		//echo "select firstname,lastname,email_address,email_status,CAST(email_open_datetime AS DATE) as date_opened,delivered,received,unsubscribe from mailCampaigns.contacts  ORDER BY $orderby limit $offset,$per_page;";
			if ($firstload=="YES"){

					$this->db->query("select * from lifeline_records  ORDER BY $orderby limit $offset,$per_page;");
			

			}else{


				if ($search!="") {
					$this->db->query("select * from lifeline_records WHERE $search   ORDER BY $orderby  limit $offset,$per_page;");
					
				}else{
					$this->db->query("select * from lifeline_records ORDER BY $orderby limit $offset,$per_page;");
					
				}				
			}
		$this->db->execute('Read');
	$getOrders = $this->db->resultSet();
	return $getOrders;
	}

    public function getNotes($customer_id){
		$this->db->query("SELECT * FROM internal_notes WHERE customer_id=:customer_id");
		$this->db->bind("customer_id",$customer_id);
		$this->db->execute();
		$row = $this->db->resultSet();
		return $row;
	}

    public function getResponses($customer_id){
		$this->db->query("SELECT * FROM lifeline_apis_log WHERE customer_id=:customer_id");
		$this->db->bind("customer_id",$customer_id);
		$this->db->execute();
		$row = $this->db->resultSet();
		return $row;
	}
}