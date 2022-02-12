<?php
$list = scandir("PinsBase");
$list = array_filter($list, function ($i) {return str_ends_with($i, ".geojson");});
$list = array_map(function ($i) {
    $cut = strpos($i, ".geojson");
    return substr($i, 0, $cut);
}, $list);
$list = array_values($list);

function return_json($array) {
    header('Content-type: application/json');
    echo json_encode($array);
    exit();
}

return_json($list);