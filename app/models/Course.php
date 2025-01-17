<?php

class Course
{
    private $conn;
    private $table = 'courses';

    // Course properties
    private $id;
    private $name;
    private $description;
    private $category;  
    private $tags = [];  
    private $created_by;
    private $created_at;

    // Constructor
    public function __construct()
    {
        $this->conn = Database::getInstance();
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getOwner() {
        return $this->created_by;
    }

    public function getCreatedAt() {
        return $this->created_at;
    }
    public function getCategory() {
        return $this->category;
    }

    public function getTags() {
        return $this->tags;
    }

    // Setters
    public function setId($id) {
        $this->id = $id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setCategory($categoryID) {
        $this->category =new Category();
        $this->category->read($categoryID);
    }

    public function setOwner($user_id) {

        $this->created_by = new Teacher();
        $this->created_by->getById($user_id);
    }
    public function setCreatedAt($date) {
        $this->created_at = $date ;
    }


    public function getCourses($limit = 0, $offset = 0)
    {
        $query = "SELECT * FROM $this->table c
                  ORDER BY created_at DESC ";
        $params = [];

        $results = $this->conn->pagination($query, $params, $limit ,$offset)->fetchAll();
        $courses = [];
        foreach ($results as $row) {
            $course = new Course();
            $course->setId($row['id']);
            $course->setName($row['name']);
            $course->setDescription($row['description']);
            $course->setOwner($row['created_by']);
            
            $course->setCategory($row['category_id']);
            
            $course->tags = $this->getTagsBycourse($row['id']);

            $courses[] = $course;
        }

        return $courses;
    }

    private function getTagsBycourse($id)
    {
        $tags = [];

        $query="SELECT  GROUP_CONCAT(ct.tag_id) AS tag_ids 
                FROM course_tags ct 
                WHERE ct.course_id = :id ";
        $tagIds= $this->conn->query($query,['id'=>$id])->fetchColumn();
        if($tagIds){
            $tagIdsArray = explode(',', $tagIds);

            foreach ($tagIdsArray as $index => $tagId) {
                $tag = new Tag();
                $tag->read($tagId);
                // Debug::dd($tag);
                $tags[] = $tag;
            }
        }
        

        return $tags;
    }

    // Get a single course by ID
    public function getById($id)
    {
        $query = "SELECT * FROM $this->table WHERE id = :id";
        $params = [':id' => $id];
        $result = $this->conn->query($query, $params)->fetch();
        if($result)
        {
            $this->setId($result['id']);
            $this->setName($result['name']);
            $this->setDescription($result['description']);
            $this->setOwner($result['created_by']);
            $this->setCategory($result['category_id']);
            $this->tags = $this->getTagsBycourse($result['id']);
        }

    }

    // Create a new course
    public function create($data)
    {
        $query = "INSERT INTO $this->table (name, description, category_id, created_by, created_at) 
                  VALUES (:name, :description, :category_id, :created_by, NOW())";
        $params = [
            ':name' => $data['name'],
            ':description' => $data['description'],
            ':category_id' => $data['category_id'],
            ':created_by' => $data['created_by']
        ];

        try {
            $this->conn->query($query, $params);
            return $this->conn->lastInsertId(); // Return id
        } catch (PDOException $e) {
            error_log("Error creating course: " . $e->getMessage());
            return false;
        }
    }

    // Update a course
    public function update($id, $data)
    {
        $query = "UPDATE $this->table 
                  SET name = :name, description = :description, category_id = :category_id 
                  WHERE id = :id";
        $params = [
            ':name' => $data['name'],
            ':description' => $data['description'],
            ':category_id' => $data['category_id'],
            ':id' => $id
        ];

        try {
            $this->conn->query($query, $params);
            return true;
        } catch (PDOException $e) {
            error_log("Error updating course: " . $e->getMessage());
            return false;
        }
    }

}