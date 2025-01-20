<?php

class Tag {
    private $conn;
    private $table = 'tags';

    private $id;
    private $name;

    public function __construct($name=null) {
        $this->setName($name);
        $this->conn = Database::getInstance();
        
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    // Setters
    public function setId($id) {
        $this->id = $id;
    }
    public function setName($name) {
        $this->name = $name;
    }

    // CRUD Operations
    public function create($array) {
       
        if (empty($array)) {
            return false;
        }
        
        $data = [];
        $id = 0;
        foreach ($array as $ctg) {
            $data[] = "(:name$id)";
            $id++;
        }
 
        $query = "INSERT INTO $this->table  ( name ) 
                VALUES " . implode(", ", $data) . "
                ON DUPLICATE KEY UPDATE name = VALUES(name)";  

        $id=0;
        foreach ($array as $ctg) {
            $params[":name$id"] = $ctg->getName(); 
            $id++;
        }

        try {
            $this->conn->query($query, $params);
            return true;
        } catch (PDOException $e) {
            error_log("Error add tags: " . $e->getMessage());
            return false;
        }
    }

    public function read($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $result = $this->conn->query($query, [':id' => $id])->fetch();
        
        if ($result) {
            $this->id = $result['id'];
            $this->name = $result['name'];
            return true;
        }
        return false;
    }

    public function update() {
        if (!$this->id) return false;

        $query = "UPDATE " . $this->table . " SET name = :name WHERE id = :id";
        return $this->conn->query($query, [
            ':name' => $this->name,
            ':id' => $this->id
        ]);
    }

    public function delete() {
        if (!$this->id) return false;

        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        return $this->conn->query($query, [':id' => $this->id]);
    }


    public function getAllTags() {
        $tags=[];
        $query = "SELECT * FROM " . $this->table . " ORDER BY name";
        $result = $this->conn->query($query);
        if($result){
            foreach($result as $tg){
                $new = new Tag();
                $new->setId($tg['id']);
                $new->setName($tg['name']);
                $tags[]= $new ;
            }
        }
        return $tags;
    }

}
