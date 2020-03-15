<?php

//header
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Post.php';

//instantiate DB & conection
$database = new Database();
$db = $database->connect();

//Instantiate blog post object
$post = new Post($db);

$result = $post->read();

$num = $result->rowCount();

if($num > 0){
    //post array
    $post_arr = array();
    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $post_item = array(
            'id' => $id,
            'title' => $title,
            'body' => html_entity_decode($body),
            'author' => $author,
            'category_id' => $category_id,
            'category_name' => $category_name
        );

        array_push($post_arr, $post_item);
    }
    //turn to json & output
     echo json_encode($post_arr);
}else{
    echo json_encode(array(
        'message' => 'No post found'
    ));
}



