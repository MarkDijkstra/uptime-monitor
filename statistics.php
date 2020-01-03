<?php

require_once(__DIR__ . '/sites.php');
require_once(__DIR__ . '/sitehealth.php');

$allSites = new Sites;
$sites    = $allSites->select();
$data     = $sites;

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

</head>
<body>

<div class="heatmap">
    <?php foreach($data as $item){?>
        <div class="css_heatmap__row">
            <div class="css_heatmap__title">
                <?= $item['title'];?>
            </div>
            <div class="css_heatmap__wrapper">
                <div class="css_heatmap__blocks">
                    <?php

                    $stats    = new SiteHealth;
                    $allStats = $stats->getStats($item['id'] , 24 );

                    foreach($allStats as $key => $value){

                        if($allStats[$key]['status'] == 200){
                            $color  = 'green';
                        }else{
                            $factor = 'red';
                        }

                        echo '<div style="background:'.$color.'"></div>';

                    } ?>

                </div>
            </div>
        </div>
    <?php }?>
</div>

</body>
</html>