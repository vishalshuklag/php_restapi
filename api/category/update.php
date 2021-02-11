<?php 

    // Headers
    header('Access-Control-Allow-Origin:  *');
    header('Content-type: application/json');
    header('Access-Control-Allow-Methos: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methos, Content-type, Access-Control-Allow-Origin, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    // Instantiate DB & Connect
    $databse = new Database();
    $db = $databse->connect();

    // Instantiate blog post object
    $category = new Category($db);

    // Get the raw categoryed data
    $data = json_decode(file_get_contents('php://input'));

    // Set ID of category
    $category->id = $data->id;

    // Set properties
    $category->name = $data->name;

    // Update category
    if ($category->edit()) {
        echo json_encode(
            array('message' => 'category Updated !!')
        );
    } else {
        
        echo json_encode(
            array('message' => 'category Not Updated !!')
        );
    }
