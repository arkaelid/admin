<?php
namespace Controller;

class Main
{
    protected $view;

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $this->view = new View();

        // Vérifier si l'utilisateur est connecté, sauf pour la page de login
        if (!$this->isLoginPage() && !$this->isUserLoggedIn()) {
            header('Location: /login');
            exit;
        }

        $this->view->session = $_SESSION;
    }

    protected function isLoginPage()
    {
        return ($_SERVER['REQUEST_URI'] === '/login' || $_SERVER['REQUEST_URI'] === '/');
    }

    protected function isUserLoggedIn()
    {
        return isset($_SESSION['login']);
    }

    protected function redirect($url)
    {
        header("Location: $url");
        exit;
    }
}
