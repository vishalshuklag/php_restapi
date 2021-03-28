<?php 
    // Headers
    header('Access-Control-Allow-Origin:  *');
    header('Content-type: application/json; charset=UTF-8');

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    // Instantiate DB 
    $database = new Database();
    $db = $database->connect();

    // instantiate category object
    $category = new Category($db);

    // Blog Category query
    $result = $category->index();

    // Get row count
    $num = $result->rowCount();

    // Check if any category
    if($num > 0) {

        // category array
        $category_arr = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

            extract($row);

            $category_item = array (
                'id' => $id,
                'name' => $name,
                'created_at' => $created_at
            );

            array_push($category_arr, $category_item);

        }
        // set response code - 200 OK
        http_response_code(200);
        // var_dump($category_arr);
        // print_r($category_arr);
        echo json_encode($category_arr);
    } else {

       // set response code - 404 Not found
        http_response_code(404);
    
        // tell the user no products found
        echo json_encode(
            array("message" => "No products found.")
        );
    }
