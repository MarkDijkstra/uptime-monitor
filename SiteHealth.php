<?php

require_once(__DIR__ . '/connect.php');

/**
 * Class SiteHealth
 */
class SiteHealth
{

    private $db;

    /**
     * SiteHealth constructor.
     */
    public function __construct()
    {
        $this->db = new Connect;
    }

    /**
     * @param $site_id
     * @param $status
     * @param $total_time
     * @param $redirect_time
     */
    public function register($site_id , $status , $total_time , $redirect_time)
    {

        $query  = "INSERT INTO site_health (site_id, status, total_time, redirect_time) VALUES (?,?,?,?)";
        $result = $this->db->prepare($query);

        $result->execute([$site_id , $status, $total_time , $redirect_time]);

    }

    /**
     * @param $site_id
     * @param int $limit
     * @return array
     */
    public function getStats($site_id , $limit = 10)
    {

        $query  = 'SELECT * FROM site_health WHERE site_id = '.$site_id.' ORDER BY added DESC LIMIT '.$limit;

        $result = $this->db->prepare($query);

        if ($result->execute()) {
            $output = $result->fetchAll(PDO::FETCH_ASSOC);

            return $output;
        }

    }

}