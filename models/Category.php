<?php 
class Category {
    // DB stuff
    private $conn;
    private $table = 'categories';

    // Post properties
    public $id;
    public $name;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    //  Get All posts
    public function index () {
        // create query
        $query = 'SELECT c.id, c.name, c.created_at
                                FROM ' . $this->table . ' c
                                ORDER BY
                                  c.created_at DESC';
        //  Prepared statement
        $stmt = $this->conn->prepare($query);
        // Execute query
        $stmt->execute();

        return $stmt;
    }

    // Get single post
    public function show() {
        // create query
        $query = 'SELECT c.id, c.name, c.created_at
        FROM ' . $this->table . ' c
                                WHERE
                                c.id = :id
                                LIMIT 0,1';
        //  Prepared statement
        $stmt = $this->conn->prepare($query);

        // Bind ID
        $stmt->bindParam(':id', $this->id);

        // Execute query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->id = $row['id'];
        $this->name = $row['name'];
        $this->created_at = $row['created_at'];
    }

    // Create Post
    public function create () {
        // create query
        $query = 'INSERT INTO ' .$this->table . '
            SET
                id = :id,
                name = :name';
        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // clean data
        $this->id = htmlspecialchars(strip_tags( $this->id));
        $this->name = htmlspecialchars(strip_tags( $this->name));

        // Bind Data
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':name', $this->name);

        // Execute query
        if($stmt->execute()) {
            return true;
          }

          // Print error if something goes wrong
          printf("Error: %s.\n", $stmt->error);

          return false;
    }

    // Update Post
    public function edit () {
        // create query
        $query = 'UPDATE ' .$this->table . '
            SET
                name = :name
            WHERE
                id = :id';
        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // clean data
        $this->id = htmlspecialchars(strip_tags( $this->id));
        $this->name = htmlspecialchars(strip_tags( $this->name));

        // Bind Data
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':name', $this->name);
        

        // Execute query
        if($stmt->execute()) {
            return true;
          }

          // Print error if something goes wrong
          printf("Error: %s.\n", $stmt->error);

          return false;
    }

    // Delete post 
    public function destroy () {
        // create query
        $query = 'DELETE
                FROM ' . $this->table . '
                WHERE id = :id';
        
        // prepare statement
        $stmt = $this->conn->prepare($query);

        //Get id & clean it
        $this->id = htmlspecialchars(strip_tags( $this->id));

        // bind id
        $stmt->bindParam(':id', $this->id);

        // Execute Query
        if ($stmt->execute()) {
            return true;
        }

        // Print Error if something goes wrong
        printf("Error : %s.\n", $stmt->error);
    }

}