<?php

    require_once(__DIR__ . '/sites.php');
require_once(__DIR__ . '/sitehealth.php');

    $allSites = new Sites;
    $sites    = $allSites->select();
    $data     = $sites;
    $sites    = json_encode((array)$sites);

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <title>Uptime Monitor</title>
    <meta name="description" content="Uptime monitor">
    <meta name="author" content="MarkDijkstra">

    <link rel="stylesheet" href="assets/css/core.css?v=1.0">

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous"></script>

    <script>
        $('document').ready(function($){
            var sites = <?= $sites?>;

            // build the containers
            // if site fails to load it will show an empty container
            for (i=0; i<sites.length; i++) {
                $('#blocks').append('<div class="placeholder" data-placeholder-id="'+sites[i]['id']+'" data-index="'+i+'">');
            }

            // run and display the site
            function runCheck(){
                for (i=0; i<sites.length; i++) {

                    siteId = sites[i]['id'];

                    (function(siteId){
                        $.ajax({
                            url: "/ajax/ajax.block.php",
                            method: "POST",
                            cache: false,
                            dataType: "html",
                            data: {id: siteId},
                            success: function (data) {

                                var placeholder = $('[data-placeholder-id=' + siteId + ']');

                                placeholder.html('').append(data);

                                var box = $('[data-id=' + siteId + ']');

                                // reset offline boxes that are back online to there original index
                                if(placeholder.attr('data-offline-level') != undefined && box.attr('data-status') == 200){
                                    var indexBox = placeholder.attr('data-index');
                                    var index    = indexBox - 1;
                                    if(indexBox != 0){
                                        $($('[data-placeholder-id=' + siteId + ']')).insertAfter($('[data-index='+index+']'));
                                    }
                                    placeholder.removeAttr('data-offline-level');
                                }

                                // push the boxes that are offline to the front of the stack,
                                // they need to be visible
                                if(box.attr('data-status') != 200){
                                    var dataOffline = placeholder.attr('data-offline-level');
                                    if(dataOffline == undefined){
                                        var level = 1;
                                    }else{
                                        var currentLevel = dataOffline;
                                        var level        = parseInt(currentLevel) + 1;
                                    }
                                    placeholder.attr('data-offline-level' , level);
                                    $('.container').prepend($('[data-placeholder-id=' + siteId + ']'));
                                }

                                // visual countdown timer
                                var start=Date.now(),r=document.getElementById('count-'+siteId);
                                (function f(){
                                    var diff=Date.now()-start,ns=(((3e5-diff)/1000)>>0),m=(ns/60)>>0,s=ns-m*60;
                                    r.textContent=m+':'+((''+s).length>1?'':'0')+s;
                                    if(diff>(3e5)){start=Date.now()}
                                    setTimeout(f,1000);
                                })();

                            }
                        });
                    })(siteId);

                }
            }
            runCheck();
            setInterval(runCheck , 300000);
        });
    </script>

</head>
<body>
    <div class="container">
        <div id="blocks"></div>
    </div>

    <hr class="line"/>

    <?php foreach($data as $item){?>
        <div class="stats__block">
            <div class="stats__title">
                <?= $item['title'];?>
            </div>
            <div class="stats__data">
                <div class="cssbars">
                    <?php

                    $stats = new SiteHealth;
                    $allStats = $stats->getStats($item['id'] , 25 );

                    foreach($allStats as $key => $value){

                        if($allStats[$key]['status'] == 200){
                            $height = '100';
                            $color   = 'green';
                        }elseif($allStats[$key]['status'] == 0){
                            $height = '20';
                            $color   = 'red';
                        }else{
                            $height = '50';
                            $color   = 'orange';
                        }

                        echo '<div><span style="height: '.$height.'%;background:'.$color.'"></span></div>';

                    } ?>

                </div>
            </div>
        </div>
    <?php }?>

</body>
</html>