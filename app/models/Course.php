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
    private File $image;
    private $content;
    private $created_at;

    // Constructor
    public function __construct()
    {
        $this->conn = Database::getInstance();
    }

    // Getters
    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getOwner()
    {
        return $this->created_by;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }
    public function getCategory()
    {
        return $this->category;
    }

    public function getTags()
    {
        return $this->tags;
    }
    public function getImage(){
        return $this->image;
    }

    // Setters
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function setCategory($categoryID)
    {
        $this->category = new Category();
        $this->category->read($categoryID);
    }
    
     public function  setImage($file){
       $this->image = $file;
    }

    public function setOwner($user_id)
    {

        $this->created_by = new Teacher();
        $this->created_by->getById($user_id);
    }
    public function setCreatedAt($date)
    {
        $this->created_at = date('d M Y', strtotime($date));
    }

    public function setTags($tags_ids){
        foreach($tags_ids as $id){
            $tag = new Tag();
           if ($tag->read($id)){
            $this->tags[]= $tag;
           }
        }
    }

    public function getCourses($limit = 0, $offset = 0)
    {
        $query = "SELECT c.*, f.id AS image_id, f.name AS image_name, f.path AS image_path 
                      FROM $this->table c
                      LEFT JOIN course_files cf ON c.id = cf.course_id
                      LEFT JOIN files f ON cf.file_id = f.id AND f.file_type_id = (SELECT id FROM file_types WHERE name = 'photo')
                      ORDER BY c.created_at DESC"; 
        $params = [];

        $results = $this->conn->pagination($query, $params, $limit, $offset)->fetchAll();
        $courses = [];
        foreach ($results as $row) {
            $course = new Course();
            $course->setId($row['id']);
            $course->setName($row['name']);
            $course->setDescription($row['description']);
            $course->setOwner($row['created_by']);
            $course->setCreatedAt($row['created_at']);
            $course->setCategory($row['category_id']);
            $course->setImage( new File($row['image_name'],$row['image_path'],'photo'));
            $course->tags = $this->getTagsBycourse($row['id']);

            $courses[] = $course;
        }

        return $courses;
    }

    private function getTagsBycourse($id)
    {
        $tags = [];

        $query = "SELECT  GROUP_CONCAT(ct.tag_id) AS tag_ids 
                FROM course_tags ct 
                WHERE ct.course_id = :id ";
        $tagIds = $this->conn->query($query, ['id' => $id])->fetchColumn();
        if ($tagIds) {
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
        if ($result) {
            $this->setId($result['id']);
            $this->setName($result['name']);
            $this->setDescription($result['description']);
            $this->setOwner($result['created_by']);
            $this->setCategory($result['category_id']);
            $this->tags = $this->getTagsBycourse($result['id']);
        }
    }

    // Create a new course
    // 
    //         $this->conn->connection->beginTransaction();

    public function create()
    {
        $query = "INSERT INTO $this->table (name, description, category_id, created_by ) 
                  VALUES (:name, :description, :category_id, :created_by )";
        $params = [
            ':name' => $this->getName(),
            ':description' => $this->getDescription(),
            ':category_id' => $this->getCategory()->getId(),
            ':created_by' => $this->getOwner()->getId()
        ];
        $this->conn->connection->beginTransaction();
        try {
            $result = $this->conn->query($query, $params);
            if ($result) {

                $this->id = $this->conn->lastInsertId(); // Return id
                // Handle tags
                if (!empty($this->tags)) {
                    $this->addTagsToCourses();
                }

                $this->conn->connection->commit();
                return $this->id;
            }

            if ($this->conn->connection->inTransaction()) {
                $this->conn->connection->rollback();
            }
            return false;
        } catch (PDOException $e) {
            if ($this->conn->connection->inTransaction()) {
                $this->conn->connection->rollback();
            }
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


    public function addTagsToCourses()
    {
        if (empty($this->tags)) {
            return false;
        }
        
        $tagCoursePairs = [];
        
        foreach ($this->tags as $tag) {
            
            $id =$tag->getId();
            $tagCoursePairs[] = "(:course_id, :tag_id_$id)";
        }
 
        $query = "INSERT INTO course_tags (course_id, tag_id) 
                VALUES " . implode(", ", $tagCoursePairs) . "
                ON DUPLICATE KEY UPDATE tag_id = VALUES(tag_id)";  
 
        $params = [':course_id' => $this->id]; 

        foreach ($this->tags as $tag) {
            $id =$tag->getId();
            $params[":tag_id_$id"] = $id; 
        }

        try {
            $this->conn->query($query, $params);
            return true;
        } catch (PDOException $e) {
            error_log("Error add tags: " . $e->getMessage());
            return false;
        }
    }
}
