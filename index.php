<?php
    require_once(__DIR__ . '/monitor.php');
    require_once(__DIR__ . '/sites.php');

    $allSites = new Sites;
    $sites    = $allSites->select();
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
                $('.container').append('<div class="placeholder" data-placeholder-id="'+sites[i]['id']+'" data-index="'+i+'">');
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
                                if(placeholder.attr('data-offline') == 1 && box.attr('data-status') == 200){
                                    var indexBox = placeholder.attr('data-index');
                                    var index    = indexBox - 1;
                                    if(indexBox != 0){
                                        $($('[data-placeholder-id=' + siteId + ']')).insertAfter($('[data-index='+index+']'));
                                    }
                                    placeholder.removeAttr('data-offline');
                                }

                                // push the boxes that are offline to the front of the stack,
                                // they need to be visible
                                if(box.attr('data-status') != 200){
                                    placeholder.attr('data-offline' , 1);
                                    $('.container').prepend($('[data-placeholder-id=' + siteId + ']'));
                                }

                            }
                        });
                    })(siteId);

                }
            }
            runCheck();
            setInterval(runCheck , 120000);
        });
    </script>

</head>
<body>
    <div class="container"></div>
</body>
</html>