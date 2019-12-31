<?php

require_once(__DIR__ . '/sites.php');
require_once(__DIR__ . '/health.php');

class Monitor 
{

    public function __contruct()
    {
        $this->build();
    }

    /**
     * @param $url
     * @return mixed
     */
    public function getPage($url)
    {

        $options = array(
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_HEADER         => false,    // don't return headers
            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_ENCODING       => "",       // handle all encodings
            CURLOPT_USERAGENT      => "spider", // who am i
            CURLOPT_AUTOREFERER    => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 0,       // timeout on connect
            CURLOPT_TIMEOUT        => 0,       // timeout on response
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
     * @param $title
     * @param $url
     */
    public function build($id, $title, $url)
    {

        if (is_numeric($id)) {

            $page = $this->getPage($url);
            $status = $page['http_code'] == 200 ? 'status--green' : 'status--red';
            $stamp = date('d-m-Y H:i:s');;

            //register status
            $health = new Health;
            $health->register($id, $page['http_code'], $stamp);

            ?>

            <div class="pingblock" data-id="<?= $id ?>">
                <div class="pingblock__item <?= $status; ?>">
                    <div class="row">
                        <div class="col">
                            <h3>
                                <?= $title ?>
                            </h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col bold">URL:</div>
                        <div class="col">
                            <?= $url; ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col bold">Response:</div>
                        <div class="col">
                            <?= $page['http_code']; ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col bold">Total Time:</div>
                        <div class="col">
                            <?= $page['total_time']; ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col bold">Last check:</div>
                        <div class="col">
                            <?= $stamp ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="togo__bar">
                                <span></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php

        }

    }

}