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
        // $this->redirect(__DIR__."../../../uploads/courses/3");
        $categories = $this->categoryModel->getAllCategories();
        $courses =$this->courseModel->getCourses(3);
        $this->render('home',['courses'=>$courses , 'categories'=>$categories ]);
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
        $this->render('courses',
        ['courses'=>$courses ,
        'categories'=>$categories ,
        'page'=>$page ,
        'totalPages'=>$totalPages ,
        'tags'=>$tags ,
        'search' => $search ]);
    }

    public function courseDetails(){

        if($this->isGet()){
            $courseId =isset($_GET['id']) ? (int)$_GET['id'] : 0  ;

            if($courseId <= 0){
                $this->_404();
            }

            $this->courseModel->getById($courseId);
            $this->courseModel->getContent()->getByCourseId($courseId);

            $contentType =$this->courseModel->getContent()->getFileType();
            if( $contentType == 'markdown'){
                $content = "app/views/course/details.php";
            }else{
                $content = "app/views/course/details-video.php";
            }

            // $this->courseModel->showContent();
        //    echo($this->courseModel->showContent()); 
        //    Debug::pd($contentType,$this->courseModel);
            $this->render('course_details',
            ['course'=>$this->courseModel,
            'content'=>$content ]);
        }else{
            $this->_404();
        }
    }
    

}