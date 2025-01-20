<?php

require_once "app/models/User.php";

// Student Class
class Student extends User implements UserCourse
{

    private array $courses = [];

    public function getMyCourses($limit = 0, $offset = 0)
    {

        $query = "SELECT c.*,  MAX(f.id) AS image_id,  MAX(f.name) AS image_name, MAX(f.path) AS image_path
                        FROM courses c
                        JOIN student_course sc ON c.id = sc.course_id
                        LEFT JOIN course_files cf ON c.id = cf.course_id
                        LEFT JOIN files f ON cf.file_id = f.id 
                        AND f.file_type_id = (SELECT id FROM file_types WHERE name = 'photo') 
                        WHERE sc.student_id = :student_id
                        GROUP BY c.id 
                        ORDER BY c.created_at DESC";
        $params = ['student_id' => $this->getId()];

        $results = $this->conn->pagination($query, $params, $limit, $offset)->fetchAll();
        $courses = [];
        foreach ($results as $row) {
            $course = new Course();
            $courses[] = $course->createObject($row);
        }

        return $courses;
        return $this->courses;
    }
    public function getCount()
    {
        $query = "SELECT COUNT(*) 
                 FROM  student_course sc 
                 WHERE  sc.student_id = :student_id ";

        $params['student_id'] = $this->getId();
        return $this->conn->query($query, $params)->fetchColumn();
    }
    
}
