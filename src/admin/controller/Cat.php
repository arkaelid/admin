<?php
namespace Controller;

class Cat extends Main {
    public function category() {
        $categoryModel = new \Model\Category();
        $categories = $categoryModel->getAllCategories();
        $this->view->Display('category', [
            'categories' => $categories
        ]);
    }

    public function addCategory() {
        if ($_POST) {
            $libelle = $_POST['libelle'];
            $categoryModel = new \Model\Category();
            $categoryModel->addCategory($libelle);
            header('Location: /category'); // Rediriger après ajout
        }
        $this->view->Display('add_category'); // Afficher le formulaire d'ajout
    }

    public function editCategory($id) {
        $categoryModel = new \Model\Category();
        if ($_POST) {
            $libelle = $_POST['libelle'];
            
            // Assure-toi que $id est bien une valeur simple
            $categoryModel->updateCategory((int) $id, $libelle); // Conversion explicite en entier
            
            header('Location: /category'); // Rediriger après modification
        } else {
            $category = $categoryModel->getCategoryById((int) $id); // Conversion explicite en entier
            $this->view->Display('edit_category', ['category' => $category]);
        }
    }

    public function deleteCategory($id) {
        $categoryModel = new \Model\Category();
        $categoryModel->deleteCategory((int) $id);
        
    }
    
}