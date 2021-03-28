<?php
    // Headers
    header('Access-Control-Allow-Origin:  *');
    header('Content-type: application/json');
    header('Access-Control-Allow-Methos: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methos, Content-type, Access-Control-Allow-Origin, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    // Instantiate DB & Connect
    $databse = new Database();
    $db = $databse->connect();

    // Instantiate blog post object
    $category = new Category($db);

    // Get the raw category data
    $data = json_decode(file_get_contents('php://input'));
    $category->id = $data->id;
    $category->name = $data->name;
    
    // create category
    if ($category->create()) {
        echo json_encode(
            array('message' => 'category created !!')
        );
    } else {
        
        echo json_encode(
            array('message' => 'category Not created !!')
        );
    }
