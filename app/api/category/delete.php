<?php

    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-type, Access-Control-Allow-Origin, Authorization, X-requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    // Instantiate DB & Connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog category object
    $category = new Category($db);

    // Get the data
    $data = json_decode(file_get_contents('php://input'));
    
    // set id of category
    $category->id = $data->id;
    
    // Delete Category
    if ($category->destroy()) {
        echo json_encode( array('message' => 'Category Deleted!'));

    } else {
        echo json_encode( array('message' => 'Post Not Deleted!!'));
    }