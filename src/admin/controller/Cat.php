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
        try {
            // Vérification et conversion sécurisée de l'ID
            if (is_array($id)) {
                if (empty($id)) {
                    throw new \Exception('ID de catégorie invalide');
                }
                $categoryId = (int) reset($id); // Prend le premier élément du tableau de façon sécurisée
            } else {
                $categoryId = (int) $id;
            }
    
            if ($categoryId <= 0) {
                throw new \Exception('ID de catégorie invalide');
            }
            
            error_log("Tentative de suppression de la catégorie ID: " . $categoryId);
            
            $categoryModel = new \Model\Category();
            $result = $categoryModel->deleteCategory($categoryId);
            
            error_log("Tentative de suppression terminée pour la catégorie " . $categoryId);
            
            header('Location: /category');
            exit();
        } catch (\Exception $e) {
            error_log("Erreur lors de la suppression: " . $e->getMessage());
            header('Location: /category?error=' . urlencode('La catégorie ne peut pas être supprimée: ' . $e->getMessage()));
            exit();
        }
    }

}