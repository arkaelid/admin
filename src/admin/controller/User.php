<?php
namespace Controller;

class User extends Main
{
    public function index()
{
    $this->manageUsers();
    $userModel = new \Model\User();
    $users = $userModel->getUserProfiles(); // Récupérer tous les utilisateurs
    $bannedUsers = $userModel->getBannedUsers(); // Récupérer les utilisateurs bannis

    // Filtrer les utilisateurs bannis de la liste des utilisateurs
    $activeUsers = array_filter($users, function($user) use ($bannedUsers) {
        foreach ($bannedUsers as $banned) {
            if ($banned['id_utilisateur'] === $user['id_utilisateur']) {
                return false; // Exclure l'utilisateur s'il est banni
            }
        }
        return true; // Inclure l'utilisateur s'il n'est pas banni
    });

    $this->view->title = 'Gestion des utilisateurs';
    $this->view->Display('user', ['users' => $activeUsers, 'bannedUsers' => $bannedUsers]);
}

    public function edit_user($vars)
    {
        $userId = $vars["id"] ?? null;
        if (!$userId) {
            $this->redirect('/user');
        }

        $userModel = new \Model\User();
        $user = $userModel->getUserProfiles($userId)[0] ?? null;
        if (!$user) {
            $this->redirect('/user');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? 'update';
            
            if ($action === 'reset_image') {
                // Réinitialiser l'image de profil
                $data = ['chemin_img_user' => '/images/utilisateurs/user.png'];
                $userModel->updateUser($userId, $data);
                $this->redirect('/user/edit/' . $userId);
            } else {
                // Mise à jour normale
                $data = [
                    'pseudo' => $_POST['pseudo'] ?? '',
                    'mail' => $_POST['mail'] ?? '',
                    'chemin_img_user' => $user['chemin_img_user'] // Garder l'image actuelle
                ];
                $userModel->updateUser($userId, $data);
                $this->redirect('/user');
            }
        }

        $this->view->title = 'Modifier l\'utilisateur';
        $this->view->Display('edit_user', ['user' => $user]);
    }

    public function ban_user($vars)
    {
        $userId = $vars["id"] ?? null;
        if (!$userId) {
            $this->redirect('/user');
        }

        $userModel = new \Model\User();
        $user = $userModel->getUserById($userId);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'date_debut' => $_POST['date_debut'],
                'date_fin' => $_POST['date_fin'] ?? null,
                'ban_perma' => isset($_POST['ban_perma']),
                'raison' => $_POST['raison']
            ];

            // Si le ban est permanent, on s'assure que date_fin est null
            if ($data['ban_perma']) {
                $data['date_fin'] = null;
            }

            $userModel->banUser($userId, $data);
            $this->redirect('/user');
        }

        $this->view->title = 'Bannir l\'utilisateur';
        $this->view->Display('ban_user', ['user' => $user]);
    }

    // Ajoutez cette méthode pour débannir un utilisateur
    public function unban($vars)
    {
        $userId = $vars["id"] ?? null;
        if (!$userId) {
            $this->redirect('/user');
        }

        $userModel = new \Model\User();
        $userModel->unbanUser($userId);
        $this->redirect('/user');
    }
    public function manageUsers()
{
    $userModel = new \Model\User();
    
    // Vérifiez et débannissez les utilisateurs dont la période de ban est expirée
    $userModel->unbanExpiredUsers();

    // Récupérer les utilisateurs et les bannis après le débannissement
    $users = $userModel->getUserProfiles();
    $bannedUsers = $userModel->getBannedUsers();
    
}
}
