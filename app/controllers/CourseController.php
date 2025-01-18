<?php


class CourseController extends BaseController
{

    private Category $categoryModel;
    private Tag $tagModel;
    private Course $courseModel;
    private File $fileModel;

    public function __construct()
    {
        parent::__construct();
        $this->categoryModel = new Category();
        $this->tagModel = new Tag();
        $this->courseModel = new Course();
        $this->fileModel = new File();
    }

    public function create()
    {
        if (!$this->isLoggedIn()) {
            $this->redirect('/login');
        }

        if ($this->isPost()) {
            // Debug::dd($_POST, $_FILES, $this->user['id']);
            // Validate inputs
            $validator = new Validator();
            $validator->validateName($_POST['name']);
            $validator->validateString($_POST['description'], 'Description');
            $validator->validateString($_POST['category_id'], 'Categorie');
            $validator->validateString($_FILES['image']['name'], 'Image');
            $tags = [];
            if (isset($_POST['tags']) && is_array($_POST['tags'])) {
                $tags = $_POST['tags'];
            }

            if ($validator->isValid()) {
                // 
                $this->courseModel->setName(Security::XSS($_POST['name']));
                $this->courseModel->setDescription(Security::XSS($_POST['description']));
                $this->courseModel->setCategory(Security::XSS($_POST['category_id']));
                $this->courseModel->setOwner($this->user['id']);
                $this->courseModel->setTags($tags);
                $courseid = $this->courseModel->create();
                if ($courseid) {
                    // Attempt to upload the image
                    if ($this->fileModel->upload($courseid, $_FILES['image'])) {

                        $this->setFlashMessage('message', 'Course ajouté avec succès.');
                        $this->redirect('/teacher/courses');
                    } else {

                        $this->setFlashMessage('error', 'Le cours a été ajouté, mais l\'image n\'a pas pu être téléchargée.');
                        $this->redirect('/teacher/courses');
                    }
                } else {
                    // Error:
                    $this->setFlashMessage('error', 'L\'ajout du cours a échoué. Veuillez réessayer.');
                    $this->redirect('/teacher/course/add');
                }
            } else {
                // Validation failed
                $_SESSION['errors'] = $validator->getErrors();
                $_SESSION['old'] = [
                    'name' => $_POST['name'],
                    'description' => $_POST['description'],
                ];
                $this->redirect('/teacher/course/add');
            }
            if (!empty($_FILES['image']['name'])) {

                if ($this->fileModel->upload(1, $_FILES['image'])) {
                } else {
                    $this->setFlashMessage('error', 'Registration failed. Please try again.');
                    $this->redirect('/register');
                }
            }
            $content = "app/views/admin/courses.php";
            $courses = $this->courseModel->getCourses();
            $this->render('admin', ['content' => $content, 'courses' => $courses]);
        } else {
            $this->_404();
        }
    }
}
