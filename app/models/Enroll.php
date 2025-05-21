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
            $this->db->query('SELECT * FROM lifeline_agrements_items WHERE active = 1 and states=:states;');
            $this->db->bind(":states",$states);
            $result = $this->db->resultSet();

            return $result;
        }

}