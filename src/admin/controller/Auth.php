<?php
namespace Controller;


class Auth extends Main
{
    
    public function login()
    {
        error_log("Méthode login appelée");
        
        if ($this->isUserLoggedIn()) {
            error_log("Redirection vers /index (utilisateur déjà connecté)");
            header('Location: /index');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $login = $_POST['login'] ?? '';
            $password = $_POST['password'] ?? '';

            $userModel = new \Model\Auth();
            $user = $userModel->getUserByUsername($login);

            if ($user && $userModel->verifyMySQLPassword($password, $user['password'])) {
                $_SESSION['login'] = $user['login'];
                $_SESSION['user_id'] = $user['login'];
                header('Location: /index');
                exit;
            } else {
                $this->view->error = "Nom d'utilisateur ou mot de passe incorrect.";
            }
        }

        error_log("Affichage du formulaire de connexion");
        $this->view->title = 'Connexion';
        $this->view->Display('login');
    }

    private function verifyMySQLPassword($password, $hashedPassword)
    {
        // Vérification spécifique pour les mots de passe hachés avec MySQL PASSWORD()
        $userModel = new \Model\Auth();
        return $userModel->verifyMySQLPassword($password, $hashedPassword);
    }

    


    public function logout()
    {
        session_destroy();
        header('Location: /');
        exit;
    }
}
