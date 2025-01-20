<?php


class TeacherController extends BaseController
{
    public Teacher $teacherModel;
    private Course $courseModel ;
    private Category $categoryModel ;
    private Tag $tagModel ;

    public function __construct()
    {
        parent::__construct();
        $this->teacherModel = new Teacher($this->user['name'],$this->user['email']);
        $this->teacherModel->setId($this->user["id"]);
        $this->tagModel = new Tag();
        $this->categoryModel = new Category();
    }


    public function index()
    {
        $this->requireRole(Role::TEACHER);

        if ($this->isGet()) {
            $content = "app/views/teacher/dashboard.php";
            $this->render('teacher',['content'=>$content]);
        }else{
            $this->_404();
        }
    }
    public function courses()
    {
        $this->requireRole(Role::TEACHER);
        
        if ($this->isGet()) {
            $this->teacherModel->setId($this->user["id"]);
            $limit=9;
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1 ; 
            $count = $this->teacherModel->getCount();
            // Debug::pd($count);
            $totalPages =ceil( $count/$limit) ;
            // validation
            if($page <= 0 || $page >$totalPages){
                
                $page=1;
            }
            $offset = $limit * ($page-1);
            $content = "app/views/teacher/courses.php";
            $courses = $this->teacherModel->getMyCourses($limit,$offset);
            $this->render('teacher',
            ['content'=>$content ,
             'courses'=>$courses ,
             'page'=>$page ,
             'totalPages'=>$totalPages]);

        }else{
            $this->_404();
        }
    }
    public function add()
    {
        $this->requireRole(Role::TEACHER);

        if ($this->isGet()) {
            $content = "app/views/teacher/add.php";
            $categories = $this->categoryModel->getAllCategories();
            $tags = $this->tagModel->getAllTags();
            $this->render('teacher',
            ['content'=>$content ,
            'tags'=>$tags ,
            'categories'=> $categories]);
        }else{
            $this->_404();
        }
    }

}
