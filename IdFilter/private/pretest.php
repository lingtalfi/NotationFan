<?php


use NotationFan\IdFilter\IdFilterUtil;


require_once 'bigbang.php';





$o = new IdFilterUtil();

$strings = [
    '5',
    '5, 9',
    '5, 9, 15, 9',
    '5-8',
    '8-5',
    '8, 1-4, 6',
    '8, 1-4, 30-28, 7',
];

foreach ($strings as $s) {
    a($o->getSelectedIds($s));
}



