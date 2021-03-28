<?php 

    // Headers
    header('Access-Control-Allow-Origin:  *');
    header('Content-type: application/json');
    header('Access-Control-Allow-Methos: DELETE');
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

    // Delete post
    if ($post->destroy()) {
        echo json_encode(
            array('message' => 'Post Deleted !!')
        );
    } else {
        
        echo json_encode(
            array('message' => 'Post Not Deleted !!')
        );
    }
