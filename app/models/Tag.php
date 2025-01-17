<?php

class Tag {
    private $conn;
    private $table = 'tags';

    private $id;
    private $name;

    public function __construct() {
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
    public function create() {
        $query = "INSERT INTO " . $this->table . " (name) VALUES (:name)";
        $stmt = $this->conn->query($query, [':name' => $this->name]);
        
        if ($stmt) {
            $this->id = $this->conn->lastInsertId();
            return true;
        }
        return false;
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

    public function getTagsByTask($course_id) {
        $tags=[];
        $query = "SELECT t.* FROM  $this->table  t
                 JOIN course_tags tt ON t.id = tt.tag_id
                 WHERE tt.course_id = :course_id
                 ORDER BY t.name ";
        $result = $this->conn->query($query, [':course_id' => $course_id]);
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
