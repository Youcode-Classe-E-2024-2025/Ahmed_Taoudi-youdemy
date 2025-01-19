<?php

class CategoryController extends BaseController
{
    private Category $categoryModel;

    public function __construct()
    {
        parent::__construct();
        $this->categoryModel = new Category();
    }

    public function create()
    {
        $this->requireRole(Role::ADMIN);
        if ($this->isPost()) {
            // Verify CSRF token
            $token = $_POST['csrf_token'] ?? '';
            if (!Security::verifyCSRFToken($token)) {
                $this->setFlashMessage('error', 'CSRF token validation failed. Possible CSRF attack.');
                Security::regenerateCSRFToken();
                $this->redirect('/admin/categories');
            }
            // Debug::dd($_POST['categories'] );
            $validator = new Validator();
            // $a='';
            // $validator->validateName($a) ;
            $validator->validateArrayOfString($_POST['categories'], 'tous les champs de catégorie');
            if ($validator->isValid()) {
                $categorys = [];
                foreach ($_POST['categories'] as $ctg) {
                    $categorys[] = new Category($ctg);
                }
                // Debug::pd($categorys);
                if ($this->categoryModel->create($categorys)) {

                    $this->setFlashMessage('message', 'categorys ajouté avec succès.');
                } else {

                    $this->setFlashMessage('error', ' ajoute de categorys a échoué. Veuillez réessayer .');
                }
            } else {
                $_SESSION['errors'] = $validator->getErrors();
            }
            $this->redirect('/admin/categories');
        } else {
            $this->_404();
        }
    }
}
