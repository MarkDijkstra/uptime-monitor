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

    <script src="/assets/js/sparklines.min.js"></script>



    <script>
        $('document').ready(function($){
            var sites = <?= $sites?>;
            for (i=0; i<sites.length; i++) {
                $('.container').append('<div class="placeholder" data-placeholder-id="'+sites[i]['id']+'">');
            }

            function runCheck(){
                for (i=0; i<sites.length; i++) {
                    siteId    = sites[i]['id'];
                    siteTitle = sites[i]['title'];
                    siteUrl   = sites[i]['url'];

                    (function(siteId){
                        $.ajax({
                            url: "/ajax/ajax.block.php",
                            method: "POST",
                            cache: false,
                            dataType: "html",
                            data: {id: siteId, title: siteTitle, url: siteUrl},
                            success: function (data) {
                                $('[data-placeholder-id=' + siteId + ']').html('').append(data);
                            }
                        });
                    })(siteId);

                }
            }
            runCheck();
           // setInterval(runCheck , 120000);
        });
    </script>

</head>
<body>
    <div class="container"></div>
</body>
</html>