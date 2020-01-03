<?php

require_once(__DIR__ . '/connect.php');

/**
 * Class Sites
 */
class Sites
{

    private $db;

    /**
     * Sites constructor.
     */
    public function __construct()
    {
        $this->db = new Connect;
    }

    /**
     * @param bool $id
     * @return array
     */
    public function select($id = false)
    {

        if ($id === false) {
            $query  = 'SELECT * FROM sites ORDER BY id';
        } else {
            $query  = 'SELECT * FROM sites WHERE id = '.$id;
        }

        $result = $this->db->prepare($query);

        if ($result->execute()) {

            $output = $result->fetchAll(PDO::FETCH_ASSOC);

            return $output;
        }

    }

}