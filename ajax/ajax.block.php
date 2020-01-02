<?php

// build a block

require_once(__DIR__ . '/../monitor.php');
require_once(__DIR__ . '/../sites.php');

if (isset($_POST['id']) && is_numeric($_POST['id']) ) {

    $stamp = date('d-m-Y H:i:s');;
    $site  = new Sites;
    $site  = $site->select($_POST['id'])[0];

    $blocks = new Monitor;
    $block  = $blocks->check($site['id'], $site['url']);

    $status = $block['http_code'] == 200 ? 'status--green' : 'status--red';

    ?>

    <div class="pingblock" data-id="<?= $site['id'] ?>" data-status="<?= $block['http_code']?>">
        <div class="pingblock__item <?= $status; ?>">
            <div class="countdown" id="count-<?= $site['id']?>">120</div>
            <div class="row">
                <div class="col">
                    <h3>
                        <?= $site['title'] ?>
                    </h3>
                </div>
            </div>
            <div class="row">
                <div class="col bold">URL:</div>
                <div class="col">
                    <?= $site['url'] ?>
                </div>
            </div>
            <div class="row">
                <div class="col bold">Response:</div>
                <div class="col">
                    <?= $block['http_code'] ?>
                </div>
            </div>
            <div class="row">
                <div class="col bold">Total Time:</div>
                <div class="col">
                    <?= $block['total_time'] ?>
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

<!--                    <div class="togo__bar">-->
<!--                        <span></span>-->
<!--                    </div>-->
                </div>
            </div>
        </div>
    </div>

<?php

}