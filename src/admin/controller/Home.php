<?php
namespace Controller;

class Home extends Main
{
    function index($vars=[])
    {
        error_log("Méthode index du contrôleur Home appelée");
        $this->view->title = 'Accueil';
        $this->view->Display('index');
    }
    public function accueil()
    {
        $userModel = new \Model\User();
        
        // Récupérer directement le nombre total d'utilisateurs
        $totalUsers = $userModel->getTotalUsersCount();
        
        // Récupérer directement le nombre d'utilisateurs bannis
        $bannedUsers = $userModel->getBannedUsersCount();

        $this->view->title = 'Tableau de bord administrateur';
        $this->view->Display('index', [
            'total_users' => $totalUsers,
            'banned_users' => $bannedUsers
        ]);
    }
}
