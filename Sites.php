<?php

require_once(__DIR__ . '/connect.php');

class Sites
{

    private $db;

    public function __construct()
    {
        $this->db = new Connect;
    }

    public function select($id = false)
    {

       // $sites = [];
        if ($id === false) {
            $query  = 'SELECT * FROM sites ORDER BY id';
        } else {
            $query  = 'SELECT * FROM sites WHERE id = '.$id;
        }

        $result = $this->db->prepare($query);

        if ($result->execute()) {

            $output = $result->fetchAll(PDO::FETCH_ASSOC);
            //return json_encode($output);
            return $output;
        }

        return [];

    }

}