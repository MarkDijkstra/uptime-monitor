<?php

require_once(__DIR__ . '/sitehealth.php');

class Monitor 
{

    public $http_code;
    public $total_time;

    public function __contruct()
    {
    }

    /**
     * @param $url
     * @return mixed
     */
    public function checkPage($url)
    {

        $options = array(
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_HEADER         => false,    // don't return headers
            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_ENCODING       => "",       // handle all encodings
            CURLOPT_USERAGENT      => "spider", // who am i
            CURLOPT_AUTOREFERER    => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 0,        // timeout on connect
            CURLOPT_TIMEOUT        => 0,        // timeout on response
            CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
            CURLOPT_SSL_VERIFYPEER => false     // Disabled SSL Cert checks
        );

        $ch      = curl_init( $url );
        curl_setopt_array( $ch, $options );
        $content = curl_exec( $ch );
        $err     = curl_errno( $ch );
        $errmsg  = curl_error( $ch );
        $header  = curl_getinfo( $ch );
        curl_close( $ch );

        $header['errno']   = $err;
        $header['errmsg']  = $errmsg;
        $header['content'] = $content;

        return $header;

    }

    /**
     * @param $id
     * @param $url
     */
    public function check($id, $url)
    {

        $page = $this->checkPage($url);

         // register status
        $health = new SiteHealth;
        $health->register($id, $page['http_code']);

        $this->http_code  = $page['http_code'];
        $this->total_time = $page['total_time'];

    }

}