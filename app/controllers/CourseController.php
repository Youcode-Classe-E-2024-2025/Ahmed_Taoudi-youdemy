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
        $this->requireRole(Role::TEACHER);

        if ($this->isPost()) {
            // Debug::dd($_POST, $_FILES, $this->user['id']);
            // Validate inputs
            $validator = new Validator();
            $validator->validateName($_POST['name']);
            $validator->validateString($_POST['description'], 'Description');
            $validator->validateString($_POST['category_id'], 'Categorie');
            // $validator->validateString($_FILES['image']['name'], 'Image');
            $tags = [];
            if (isset($_POST['tags']) && is_array($_POST['tags'])) {
                $tags = $_POST['tags'];
            }
            // if (!empty($_FILES['photo']['name'])) {
            //     Debug::dd($_POST, 999, $_FILES, $this->user['id']);
            // } else {
            //     Debug::dd($_POST, 777, $_FILES, $this->user['id']);
            // }
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
                    if (!empty($_FILES['photo']['name'])) {
                        if ($this->fileModel->upload($courseid, $_FILES['photo'])) {
                            $this->setFlashMessage('message', 'Course ajouté avec succès.');
                        } else {
                            $this->setFlashMessage('error', 'Le cours a été ajouté, mais l\'image n\'a pas pu être téléchargée.');
                        }
                    }
                    
                    if ($_POST['content_type'] === 'document' && !empty($_POST['document'])) {
                        if ($this->fileModel->upload($courseid, ['name'=>'markdownd','document' => $_POST['document']] , true)) {
                            $this->setFlashMessage('message', 'Course ajouté avec succès, avec le fichier Markdown.');
                        } else {
                            $this->setFlashMessage('error', 'Le cours a été ajouté, mais le fichier Markdown n\'a pas pu être créé.');
                        }
                    }
                    // Handle video upload (if the video is not empty)
                    elseif (!empty($_FILES['video']['name'])) {
                        if ($this->fileModel->upload($courseid, $_FILES['video'])) {
                            $this->setFlashMessage('message', 'Course ajouté avec succès, avec la vidéo.');
                        } else {
                            $this->setFlashMessage('error', 'Le cours a été ajouté, mais la vidéo n\'a pas pu être téléchargée.');
                        }
                    } 
                } else {
                    // Error:
                    $this->setFlashMessage('error', 'L\'ajout du cours a échoué. Veuillez réessayer.');
                    $this->redirect('/teacher/course/add');
                }
                $this->redirect('/teacher/courses');
            } else {
                // Validation failed
                $_SESSION['errors'] = $validator->getErrors();
                $_SESSION['old'] = [
                    'name' => $_POST['name'],
                    'description' => $_POST['description'],
                ];
                $this->redirect('/teacher/course/add');
            }
        } else {
            $this->_404();
        }
    }
    public function enroll()
    {

        $this->requireRole(Role::STUDENT);

        if ($this->isPost()) {
            $courseId = isset($_POST['course_id']) ? (int) $_POST['course_id'] : 0;

            if ($courseId <= 0) {
                return $this->_404();
            }
            $course = $this->courseModel->findById($courseId);
            if (!$course) {
                return  $this->_404();
            }
            $this->courseModel->setId($courseId);
            // check
            if ($this->courseModel->isUserEnrolled($this->user['id'])) {
                $this->setFlashMessage('error', ' deja enroll. ');
                $this->redirect('/student/my-courses');
            }
            // enroll
            if ($this->courseModel->enrollUser($this->user['id'], $courseId)) {
                $this->setFlashMessage('message', 'enroll avec succès.');
            } else {
                $this->setFlashMessage('error', 'enroll  a échoué.');
            }
            $this->redirect('/student/my-courses');
        } else {
            $this->_404();
        }
    }
}
