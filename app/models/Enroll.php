<?php 

class Enroll {
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }

    public function getLifelinePrograms(){
            $this->db->query('SELECT * FROM lifeline_programs where active = 1;');
            $result = $this->db->resultSet();

            return $result;
        }

    public function getAgreementsItems($states){
            $this->db->query('SELECT * FROM lifeline_agrements_items WHERE active = 1 and states="all" or states=:states;');
            $this->db->bind(":states",$states);
            $result = $this->db->resultSet();

            return $result;
        }

    public function saveData($data,$table){
        $this->db->insertQuery($table,$data);
        $id=$this->db->lastinsertedId();
        return $id;
    }

    public function getCustomerData($customerId){
        $this->db->query("SELECT * FROM lifeline_records WHERE customer_id=:customer_id");
        $this->db->bind(":customer_id",$customerId);
        $result = $this->db->resultSet();
        return $result;
    }

    public function updateData($data,$table){
        $this->db->updateQuery($table,$data,"customer_id=:customer_id");
    }

    public function updateDataById($data,$table){
       $result =  $this->db->updateQuery($table,$data,"id=:id");
       return $result;
    }

    public function updateCusId($lastId,$customerId,$table){
        $data=[
            "id"=>$lastId,
            "customer_id"=>$customerId
        ];
        $this->db->updateQuery($table,$data,"id=:id");

    }

    public function getCredentials(){
         $this->db->query('SELECT * FROM clec_credentials where active = 1;');
            $result = $this->db->resultSet();

            return $result;
    }

    public function getPackages(){
        $this->db->query("SELECT * FROM packages WHERE active=1;");
        $result = $this->db->resultSet();
        return $result;
    }

    public function checkIdFile($customerId){
        $this->db->query("SELECT * FROM lifeline_documents WHERE customer_id=:custId and type_doc='ID';");
        $this->db->bind(":custId",$customerId);
        $result = $this->db->single();
        return $result;
    }

}