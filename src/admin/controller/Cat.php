<?php
namespace Controller;

class Cat extends Main {
    public function category() {
        $categoryModel = new \Model\Category();
        $categories = $categoryModel->getAllCategories();
        
        $this->view->Display('category', [
            'categories' => $categories,
            'success' => $_GET['success'] ?? null,
            'error' => $_GET['error'] ?? null
        ]);
    }

    public function addCategory() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $libelle = $_POST['libelle'];
                $categoryModel = new \Model\Category();
                $categoryModel->addCategory($libelle);
                header('Location: /category?success=La catégorie a été ajoutée avec succès');
                exit;
            } catch (\Exception $e) {
                header('Location: /category?error=' . urlencode($e->getMessage()));
                exit;
            }
        }
        $this->view->Display('add_category');
    }

    public function editCategory($id) {
        $categoryModel = new \Model\Category();
        
        // Debug pour voir le format de l'ID reçu
        error_log('ID reçu : ' . print_r($id, true));
        
        // Si $id est un tableau, prendre la valeur 'id'
        $categoryId = is_array($id) ? (int)$id['id'] : (int)$id;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $libelle = $_POST['libelle'];
                $categoryModel->updateCategory($categoryId, $libelle);
                header('Location: /category?success=La catégorie a été modifiée avec succès');
                exit;
            } catch (\Exception $e) {
                header('Location: /category?error=' . urlencode($e->getMessage()));
                exit;
            }
        }
        
        $category = $categoryModel->getCategoryById($categoryId);
        if (!$category) {
            header('Location: /category?error=Catégorie non trouvée');
            exit;
        }
        
        $this->view->Display('edit_category', ['category' => $category]);
    }
    
    public function deleteCategory($id) {
        try {
            // Si $id est un tableau, prendre la première valeur
            $categoryId = is_array($id) ? (int)$id['id'] : (int)$id;
            
            if ($categoryId <= 0) {
                throw new \Exception('ID de catégorie invalide');
            }
            
            $categoryModel = new \Model\Category();
            $categoryModel->deleteCategory($categoryId);
            
            header('Location: /category?success=La catégorie a été supprimée avec succès');
            exit;
        } catch (\Exception $e) {
            header('Location: /category?error=' . urlencode($e->getMessage()));
            exit;
        }
    }
}