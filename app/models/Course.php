<?php

class Course
{
    private $conn;
    private $table = 'courses';

    // Course properties
    private $id;
    private $name;
    private $description;
    private Category $category;
    private $tags = [];
    private Teacher  $created_by;
    private File $image;
    private File $content;
    private $created_at;
    private bool $visibility;

    // Constructor
    public function __construct($name = null, $description = null, $category_id = null, $tags = [], $created_by = null, $created_at = null, File $image = new File(), File $content = new File())
    {

        $this->setName($name);
        $this->setDescription($description);
        $this->setOwner($created_by);
        $this->setCreatedAt($created_at);
        $this->setCategory($category_id);
        $this->setImage($image);
        $this->setContent($content);
        $this->tags = $tags;
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
    public function getImage()
    {
        return $this->image;
    }
    public function getContent()
    {
        return $this->content;
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

    public function  setImage($file)
    {
        $this->image = $file;
    }

    public function  setContent($file)
    {
        $this->content = $file;
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

    public function setTags($tags_ids)
    {
        foreach ($tags_ids as $id) {
            $tag = new Tag();
            if ($tag->read($id)) {
                $this->tags[] = $tag;
            }
        }
    }

    public function getCourses($limit = 0, $offset = 0, $search = '')
    {
        $query = "SELECT c.*,   MAX(f.id) AS image_id,    MAX(f.name) AS image_name,   MAX(f.path) AS image_path
                FROM $this->table c
                LEFT JOIN course_files cf ON c.id = cf.course_id
                LEFT JOIN files f ON cf.file_id = f.id 
                    AND f.file_type_id = (SELECT id FROM file_types WHERE name = 'photo')  ";

        $params = [];
        if (!empty($search)) {
            $query .= " WHERE c.name LIKE :search OR c.description LIKE :search";
            $params['search'] = '%' . $search . '%';
        }

        $query .= " GROUP BY c.id
                ORDER BY c.created_at DESC";


        $results = $this->conn->pagination($query, $params, $limit, $offset)->fetchAll();
        $courses = [];
        foreach ($results as $row) {
            $courses[] = $this->createObject($row);
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
        $query = " SELECT c.*, MAX(f.id) AS image_id, MAX(f.name) AS image_name, MAX(f.path) AS image_path
            FROM $this->table c
            LEFT JOIN course_files cf ON c.id = cf.course_id
            LEFT JOIN files f ON cf.file_id = f.id 
            AND f.file_type_id = (SELECT id FROM file_types WHERE name = 'photo') 
            WHERE c.id = :id
            GROUP BY c.id";
        $params = [':id' => $id];
        $result = $this->conn->query($query, $params)->fetch();
        if ($result) {
            $this->setId($result['id']);
            $this->setName($result['name']);
            $this->setDescription($result['description']);
            $this->setOwner($result['created_by']);
            $this->setImage(new File($result['image_name'], $result['image_path'], 'photo'));
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

            $id = $tag->getId();
            $tagCoursePairs[] = "(:course_id, :tag_id_$id)";
        }

        $query = "INSERT INTO course_tags (course_id, tag_id) 
                VALUES " . implode(", ", $tagCoursePairs) . "
                ON DUPLICATE KEY UPDATE tag_id = VALUES(tag_id)";

        $params = [':course_id' => $this->id];

        foreach ($this->tags as $tag) {
            $id = $tag->getId();
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

    public function getCoursesByCategory($ctg_id, $limit = 0, $offset = 0 , $search='')
    {
        $query = " SELECT c.*,   MAX(f.id) AS image_id,    MAX(f.name) AS image_name,   MAX(f.path) AS image_path
                FROM $this->table c
                LEFT JOIN course_files cf ON c.id = cf.course_id
                LEFT JOIN files f ON cf.file_id = f.id 
                AND f.file_type_id = (SELECT id FROM file_types WHERE name = 'photo') 
                WHERE c.category_id = :ctg_id ";
                 $params = [];
                 $params['ctg_id'] = $ctg_id;

                 if (!empty($search)) {
                     $query .= " AND c.name LIKE :search OR c.description LIKE :search";
                     $params['search'] = '%' . $search . '%';
                 }
         
                 $query .= " GROUP BY c.id
                         ORDER BY c.created_at DESC";

        $results = $this->conn->pagination($query, $params, $limit, $offset)->fetchAll();
        $courses = [];

        foreach ($results as $row) {
            $courses[] = $this->createObject($row);
        }

        return $courses;
    }

    public function createObject($row)
    {
        $course = new Course($row['name'], $row['description'], $row['category_id'], $this->getTagsBycourse($row['id']), $row['created_by'], $row['created_at'], new File($row['image_name'], $row['image_path'], 'photo'));
        $course->setId($row['id']);
        return $course;
    }

    public function getCount($ctg_id = null,$search = '')
    {

        $query = "SELECT  COUNT(*)
                FROM $this->table c WHERE 1=1 ";
        $params = [];

        if (!empty($search)) {
            $query .= " AND c.name LIKE :search OR c.description LIKE :search";
            $params['search'] = '%' . $search . '%';
        }

        if ($ctg_id) {
            $query .= " AND c.category_id = :id ";
            $params['id'] = $ctg_id;
        }

        return $this->conn->query($query, $params)->fetchColumn();
    }

    public function findById($id)
    {
        $query = "SELECT *
                FROM $this->table c 
                WHERE c.id = :id ";
        $params['id'] = $id;
        $result = $this->conn->query($query, $params)->fetch();

        if ($result) {
            return true;
        }
        return false;
    }

    public function isUserEnrolled($userId)
    {
        $query = "SELECT * FROM student_course WHERE student_id = :user_id AND course_id = :course_id";
        $params = ['user_id' => $userId, 'course_id' => $this->getId()];

        $result = $this->conn->query($query, $params)->fetch();
        if ($result) {
            return true;
        }
        return false;
    }

    public function enrollUser($userId)
    {
        $query = "INSERT INTO student_course (course_id, student_id  ) VALUES ( :course_id , :user_id) ";
        $params = ['user_id' => $userId, 'course_id' => $this->getId()];

        $result = $this->conn->query($query, $params);
        if ($result) {
            return true;
        }
        return false;
    }
    public function showContent()
    {
       
        $fileType = $this->getContent()->getFileType(); 
        
        if ($fileType == 'video') {

             return  $this->getContent()->getPath();

        } elseif ($fileType == 'markdown') {
            
            $filePath =$this->getContent()->getPath();
            if (file_exists($filePath)) {
                return file_get_contents($filePath);
            } else {
                return 'Markdown file not found.';
            }
        } else {
         
            return null;
        }
    }
    
}
