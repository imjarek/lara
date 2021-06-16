<?php
echo '<pre>';

$a = [
    1 => 'asdf',
    2 => 'sdf',
    3 => 'dfadf',
    4 => 'dfasrf',
    'adsf' => 'dasf',
    'regf' => 'erfi'
];


var_dump(elementBeforeLast($a));

function elementBeforeLast($a){
    $keys = array_keys($a);
    var_dump($keys);
    $len = count($keys);
    $index = $len - 2;
    return $a[$keys[$index]];
}
