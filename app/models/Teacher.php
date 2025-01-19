<?php
require_once 'app/models/User.php';
// Teacher Class
class Teacher extends User implements UserCourse
{
    private array $courses = [];

    public function getMyCourses($limit = 0, $offset = 0)
    {

        $query = "SELECT c.*, f.id AS image_id, f.name AS image_name, f.path AS image_path 
                      FROM courses c
                      LEFT JOIN course_files cf ON c.id = cf.course_id
                      LEFT JOIN files f ON cf.file_id = f.id AND f.file_type_id = (SELECT id FROM file_types WHERE name = 'photo')
                      WHERE c.created_by = :id 
                      ORDER BY c.created_at DESC";
        $params = ['id'=>$this->getId()];

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
        $query = "SELECT  COUNT(*)
                FROM courses c  WHERE c.created_by = :id ";
        $params['id'] = $this->getId();
        return $this->conn->query($query, $params)->fetchColumn();
    }
}
