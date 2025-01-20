<?php


class StudentController extends BaseController
{
    public Student $studentModel;
    private Course $courseModel ;
    private Category $categoryModel ;
    private Tag $tagModel ;


    public function __construct()
    {
        parent::__construct();
        $this->studentModel = new Student($this->user['name'],$this->user['email']);
        $this->studentModel->setId($this->user["id"]);
        $this->courseModel = new Course();
        $this->categoryModel = new Category();
        $this->tagModel = new Tag();
    }


    public function index()
    {
        $this->requireRole(Role::STUDENT);
        // Debug::dd($this->user);
        if ($this->isGet()) {
            $content = "app/views/student/dashboard.php";
            $this->render('student',
            ['content'=>$content ]);
        }else{
            $this->_404();
        }
    }
    public function myCourses()
    {
        $this->requireRole(Role::STUDENT);
        
        if ($this->isGet()) {
            $this->studentModel->setId($this->user["id"]);
            $limit=9;
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1 ; 
            $count = $this->studentModel->getCount();
            // Debug::pd($count);
            $totalPages =ceil( $count/$limit) ;
            // validation
            if($page <= 0 || $page >$totalPages){
                
                $page=1;
            }
            $offset = $limit * ($page-1);
            $content = "app/views/student/my-courses.php";
            $courses = $this->studentModel->getMyCourses($limit,$offset);
            $this->render('student',
            ['content'=>$content ,
             'courses'=>$courses ,
             'page'=>$page ,
             'totalPages'=>$totalPages]);

        }else{
            $this->_404();
        }
    }

    public function courses(){
        $limit = 9;
        $ctg_id = isset($_GET['category']) ? (int)$_GET['category'] : null ; 
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1 ; 
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';  
        $count = $this->courseModel->getCount($ctg_id,$search);
        $totalPages =ceil( $count/$limit) ;
        // validation
        if($page <= 0 || $page >$totalPages){ 
            $page=1;
        }
        // Debug::pd($page);
        $offset = $limit * ($page-1);
        if($ctg_id){

            $courses = $this->courseModel->getCoursesByCategory($ctg_id,$limit,$offset, $search);
        }else{
            $courses = $this->courseModel->getCourses($limit,$offset, $search);
        }

        $categories = $this->categoryModel->getAllCategories();
        $tags = $this->tagModel->getAllTags();
        $content = "app/views/student/courses.php";
        $this->render('student',
        ['courses'=>$courses ,
        'content'=>$content,
        'categories'=>$categories ,
        'page'=>$page ,
        'totalPages'=>$totalPages ,
        'tags'=>$tags ]);
    }

}
