<?php
    require_once(__DIR__ . '/monitor.php');
    require_once(__DIR__ . '/sites.php');

$list = array(
        'Google NL' => 'https://www.google.nl',
    );

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
            function runCheck(){
                $('.pingblock').each(function (i) {
                    $("[data-pingblock=" + i + "]").load(location.href + " [data-pingblock-child=" + i + "]");
                    //console.log('refresh block :'+ i +' | '+ new Date().toLocaleString());
                });
            }
            setInterval(runCheck , 60000);
        });
    </script>

</head>
<body>
    <div class="container">
        <?php
            $block = new Monitor;
            $block->build($list);


        $sites = new Sites;
        print_r($sites->select());
        ?>
    </div>
</body>
</html>