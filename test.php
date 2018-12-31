<?php
/**
 * Created by PhpStorm.
 * User: rolf
 * Date: 12/31/18
 * Time: 2:09 AM
 */

require_once "vendor/autoload.php";

use Rolfisub\ArrayFlatten\ArrayFlatten;

$a = [
    [
        "a" => 2,
        "at" => [
            "b" => 3
        ]
    ],
    [
        "a" => 1,
        "at" => [
            "b" => 1
        ]
    ]
];
$r = [];
foreach ($a as $key => $arr) {
    array_push($r, ArrayFlatten::flatten($arr));
}

var_dump($r);



$c = array_column($r, 'b');

var_dump($c);

$b = array_multisort($c, SORT_ASC, $a);

var_dump($b);

var_dump($a);