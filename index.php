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
  <meta name="description" content="The HTML5 Herald">
  <meta name="author" content="SitePoint">

<!--  <link rel="stylesheet" href="css/styles.css?v=1.0">-->

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

    <style>
        .pingblock{
            min-width: 300px;
            margin:0 20px 20px 0;
            float:left;
        }
        .pingblock__item{
            padding:20px;
            width: calc(100% - 40px);
            float:left;
            transform: scale(1);
        }
        .status--green{
            background-color: #28b02d;
            color: #fff;
        }
        .status--red{
            background-color: #bf2424;
            color: #fff;
        }
        /*.popbox{*/
        /*    animation-name: activity;*/
        /*    animation-duration: 1s;*/
        /*}*/
        .togo__bar{
            width: 100%;
            height: 4px;
            float: left;
            position: relative;
            margin-top: 20px;
            background-color: rgba(255,255,255,0.3);
        }
        /*@keyframes activity {*/
        /*    0% {*/
        /*        opacity:0.5;*/
        /*    }*/
        /*    100% {*/
        /*        opacity:1;*/
        /*    }*/
        /*}*/
        .togo__bar span{
             width: 100%;
             height: 4px;
             position: absolute;
             right: 0;
             top: 0;
             background-color: #fff;
             animation-name: togobar;
             /*animation-iteration-count: infinite;*/
             animation-duration: 60s;
        }
        @keyframes togobar {
            0% {
                width: 100%;
            }
            100% {
                width: 0;
            }
        }
    </style>

</head>
<body>

    <?php
        $block = new Monitor;
        $block->build($list); 
    ?>

</body>
</html>