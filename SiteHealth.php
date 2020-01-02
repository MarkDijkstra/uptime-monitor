<?php

require_once(__DIR__ . '/connect.php');

class SiteHealth
{

    private $db;

    public function __construct()
    {
        $this->db = new Connect;
    }

    public function register($site_id , $status)
    {

        $query  = "INSERT INTO site_health (site_id , status) VALUES (?,?)";

        $result = $this->db->prepare($query);
        $result->execute([$site_id , $status]);

//            $output = $result->fetchAll(PDO::FETCH_ASSOC);
//            //return json_encode($output);
//            return $output;

//        return [];
    }

    public function getStats($site_id , $limit = 10)
    {

        $query  = 'SELECT * FROM site_health WHERE site_id = '.$site_id.' ORDER BY added DESC LIMIT '.$limit;

        $result = $this->db->prepare($query);

        if ($result->execute()) {
            $output = $result->fetchAll(PDO::FETCH_ASSOC);

            return $output;
        }

        return [];
    }

}