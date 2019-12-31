<?php

require_once(__DIR__ . '/connect.php');

class Health
{

    private $db;

    public function __construct()
    {
        $this->db = new Connect;
    }

    public function register($site_id , $status)
    {

        $query  = "INSERT INTO health (site_id , status) VALUES (?,?)";

        $result = $this->db->prepare($query);
        $result->execute([$site_id , $status]);

//            $output = $result->fetchAll(PDO::FETCH_ASSOC);
//            //return json_encode($output);
//            return $output;

//        return [];
    }

}