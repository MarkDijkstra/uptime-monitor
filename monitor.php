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

    /**
     * @param $list
     * @return string
     */
    public function build($list)
    {

        if (is_array($list)) {
            $insertOneResult = $db->inventory->insertOne([
                'item' => 'canvas',
                'qty' => 100,
                'tags' => ['cotton'],
                'size' => ['h' => 28, 'w' => 35.5, 'uom' => 'cm'],
            ]);
            $i = 0;

            foreach ($list as $title => $url){

                $page   = $this->getPage($url);
                $status = $page['http_code'] == 200 ? 'status--green' : 'status--red';

                ?>
                <div class="pingblock" data-pingblock="<?= $i ?>">
                    <div class="pingblock__item <?= $status; ?>"  data-pingblock-child="<?= $i ?>">
                         <div class="row">
                            <div class="col">
                                <h3><?= $title?></h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col bold">URL:</div>
                            <div class="col"><?= $page['url'];?></div>
                        </div>
                        <div class="row">
                            <div class="col bold">Response:</div>
                            <div class="col"><?= $page['http_code'];?></div>
                        </div>
                        <div class="row">
                            <div class="col bold">Total Time:</div>
                            <div class="col"><?= $page['total_time'];?></div>
                        </div>
                        <div class="row">
                            <div class="col bold">Last check:</div>
                            <div class="col"><?= date('d-m-Y H:i:s');?></div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="togo__bar"><span></span></div>
                            </div>
                        </div>

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