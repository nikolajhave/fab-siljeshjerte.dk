<?php

class LocalImage 
{
}

$mysqli = new mysqli("localhost", "root", "root", "have_siljeshjerte");

// 14923 (page object)
// 14887 (image object)

$sql = 'SELECT * FROM object where id = 14923';
$sql = 'SELECT * FROM object where id = 14887';

$query = $mysqli->query($sql);

if ($result = $query->fetch_object()) {

    // var_dump($result);

    // Serialized data
    $serializedString = $result->data;

    // UTF-8 decode?
    $serializedString = utf8_decode($serializedString);

    // Fix
    /* $serializedString = preg_replace_callback ( '!s:(\d+):"(.*?)";!',
        function($match) {
            return ($match[1] == strlen($match[2])) ? $match[0] : 's:' . strlen($match[2]) . ':"' . $match[2] . '";';
        },
    $serializedString ); */

    // Unserialize data field
    $data = unserialize($serializedString);
    // var_dump($data->rawdata);

    //
    header('Content-type: image/jpeg');
    echo $data->rawdata;
    exit;

    file_put_contents('test.jpg', $data->rawdata);

    $query->close();

} else {
    echo "SQL Error: ". $sql;
}


