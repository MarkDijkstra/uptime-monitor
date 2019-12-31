<?php
// build a block with a thru an AJAX call

require_once(__DIR__ . '/../monitor.php');

if (isset($_POST['id']) && isset($_POST['title']) && isset($_POST['url'])) {

    $block = new Monitor;
    $block->build($_POST['id'], $_POST['title'], $_POST['url']);
    $response['status'] = 'gfgdfg';

}