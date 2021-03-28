<?php
// Headers
    header('Access-Control-Allow-Origin:  *');
    header('Content-type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    // Instantiate DB & Connect
    $databse = new Database();
    $db = $databse->connect();

    // Instantiate blog post object
    $category = new Category($db);

    // Get ID
    $category->id = isset($_GET['id']) ? $_GET['id'] : die();

    $category->show();

    // create array
    $category_arr = array(
        'id' => $category->id,
        'name' => $category->name,
        'created_at' => $category->created_at
    );

    // Turn to json & output
    echo json_encode($category_arr);