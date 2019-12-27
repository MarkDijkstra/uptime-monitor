<?php
    require_once(__DIR__ . '/monitor.php'); 

    $list = array(
        'Google' => 'https://www.google.nl',
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

            $('.pingblock').each(function(i,e){

                setInterval(function(){

                    $("[data-pingblock="+i+"]").load(location.href + " [data-pingblock-child="+i+"]").children('.pingblock__item');

                }, 60000);

            });
            var stamp = new Date().toLocaleString();
            stamp;
        });
    </script>

</head>
<body>

    <?php
        $block = new Monitor;
        $block->build($list); 
    ?>

</body>
</html>