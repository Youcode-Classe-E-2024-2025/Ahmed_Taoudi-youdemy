<?php 

class HomeController extends BaseController
{
    private Course $courseModel ;
    private Category $categoryModel ;
    private Tag $tagModel ;

    public function __construct()
    {
        $this->courseModel = new Course();
        $this->categoryModel = new Category();
        $this->tagModel = new Tag();
    }

    public function index(){
        $courses =$this->courseModel->getCourses();
        $this->render('home',['courses'=>$courses]);
    }
    public function courses(){
        $categories = $this->categoryModel->getAllCategories();
        $tags = $this->tagModel->getAllTags();
        $courses = $this->courseModel->getCourses();
        $this->render('courses',
        ['courses'=>$courses ,
        'categories'=>$categories ,
        'tags'=>$tags ]);
    }
    

}