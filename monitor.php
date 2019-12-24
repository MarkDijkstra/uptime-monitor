<?php
    
class Monitor 
{

    public function __contruct()
    {
        $this->build();
    }


    public function getPage( $url )
    {

        $options = array(
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_HEADER         => false,    // don't return headers
            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_ENCODING       => "",       // handle all encodings
            CURLOPT_USERAGENT      => "spider", // who am i
            CURLOPT_AUTOREFERER    => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 60,       // timeout on connect
            CURLOPT_TIMEOUT        => 60,       // timeout on response
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


    public function build($list)
    {

        if (is_array($list)) {

            $i = 0;

            foreach ($list as $title => $url){

                $page   = $this->getPage($url);
                $status = $page['http_code'] == 200 ? 'status--green' : 'status--red';

                ?>
                <div class="pingblock" data-pingblock="<?= $i ?>">
                    <div class="pingblock__item <?= $status; ?>"  data-pingblock-child="<?= $i ?>">
                        <?php

                            echo '<h3>'. $title . '</h3>';
                            echo 'url: ' . $page['url'];
                            echo '<br/>';
                            echo 'response: ' . $page['http_code'];
                            echo '<br/>';
                            echo 'total time: ' . $page['total_time'];
                            echo '<br/>';
                        ?>
                        <div class="timestamp"><?= date('d-m-Y H:i:s');?></div>
                        <div class="togo__bar"><span></span></div>
                    </div>
                </div>

                <?php

                $i++;

            }

        }else{
            return 'invalid';
        }

    }

}