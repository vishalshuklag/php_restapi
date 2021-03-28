<?php 

    // Headers
    header('Access-Control-Allow-Origin:  *');
    header('Content-type: application/json');
    header('Access-Control-Allow-Methos: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methos, Content-type, Access-Control-Allow-Origin, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Post.php';

    // Instantiate DB & Connect
    $databse = new Database();
    $db = $databse->connect();

    // Instantiate blog post object
    $post = new Post($db);

    // Get the raw posted data
    $data = json_decode(file_get_contents('php://input'));

    // Set ID of post
    $post->id = $data->id;

    // Set properties
    $post->title = $data->title;
    $post->body = $data->body;
    $post->author = $data->author;
    $post->category_id = $data->category_id;

    // Update post
    if ($post->edit()) {
        echo json_encode(
            array('message' => 'Post Updated !!')
        );
    } else {
        
        echo json_encode(
            array('message' => 'Post Not Updated !!')
        );
    }
