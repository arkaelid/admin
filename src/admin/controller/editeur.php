<?php
namespace Controller;

class editeur extends Main
{
    public function editeur()
    {
        try {
            $editeurModel = new \Model\editeur();
            $editeurs = $editeurModel->getEditeurProfiles();
            
            $this->view->Display('editeur', [
                'editeurs' => $editeurs,
                'success' => $_GET['success'] ?? null,
                'error' => $_GET['error'] ?? null
            ]);
        } catch (\Exception $e) {
            error_log("Erreur dans editeur->editeur: " . $e->getMessage());
            $this->view->Display('editeur', [
                'editeurs' => [],
                'error' => 'Une erreur est survenue lors du chargement des éditeurs.'
            ]);
        }
    }

    public function edit_editeur($vars)
    {
        $userId = $vars["id"] ?? null;
        if (!$userId) {
            $this->redirect('/editeur');
        }

        $editeurModel = new \Model\editeur();
        $editeur = $editeurModel->getEditeurProfiles($userId)[0] ?? null;
        if (!$editeur) {
            $this->redirect('/editeur');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? 'update';
            
            if ($action === 'reset_image') {
                // Réinitialiser l'image de profil
                $data = ['chemin_img_editeur' => '/images/utilisateurs/user.png'];
                $editeurModel->updateEditeur($userId, $data);
                $this->redirect('/editeur/edit_editeur/' . $userId);
            } else {
                // Mise à jour normale
                $data = [
                    'nom_societe' => $_POST['pseudo'] ?? '',
                    'mail_editeur' => $_POST['mail'] ?? '',
                    'adresse_editeur' => $_POST['adresse'] ?? '',
                    'siret' => $_POST['siret'] ?? '',
                    'chemin_img_editeur' => $editeur['chemin_img_editeur'] // Garder l'image actuelle
                ];
                $editeurModel->updateEditeur($userId, $data);
                $this->redirect('/editeur');
            }
        }

        $this->view->title = 'Modifier l\'éditeur';
        $this->view->Display('edit_editeur', ['editeur' => $editeur]);
    }

    public function deleteEditeur($vars)
    {
        $editeurId = $vars["id"] ?? null;
        if (!$editeurId) {
            $this->redirect('/editeur?error=Éditeur non trouvé');
            return;
        }
    
        try {
            $editeurModel = new \Model\editeur();
            $editeurModel->deleteEditeur($editeurId);
            $this->redirect('/editeur?success=L\'éditeur a été supprimé avec succès');
        } catch (\Exception $e) {
            $this->redirect('/editeur?error=Erreur lors de la suppression : ' . $e->getMessage());
        }
    }
    
    public function addEditeur()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $editeurModel = new \Model\editeur();
            
            $data = [
                'nom_societe' => $_POST['nom_societe'] ?? '',
                'mail_editeur' => $_POST['mail'] ?? '',
                'adresse_editeur' => $_POST['adresse'] ?? '',
                'siret' => $_POST['siret'] ?? '',
                'chemin_img_editeur' => '/images/utilisateurs/user.png'
            ];
    
            try {
                $editeurModel->addEditeur($data);
                $this->redirect('/editeur?success=L\'éditeur a été ajouté avec succès');
            } catch (\Exception $e) {
                $this->view->Display('add_editeur', [
                    'error' => 'Erreur lors de l\'ajout de l\'éditeur : ' . $e->getMessage()
                ]);
                return;
            }
        }
    
        $this->view->title = 'Ajouter un éditeur';
        $this->view->Display('add_editeur');
    }
}
