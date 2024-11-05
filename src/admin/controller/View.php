<?php
namespace Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class View
{
    private $twig;
    private $data = [];

    public function __construct()
    {
        $loader = new FilesystemLoader(DIR_VIEW);
        $this->twig = new Environment($loader);
    }

    public function Display($template, $additionalData = [])
    {
        $data = array_merge($this->data, $additionalData, [
            'session' => $_SESSION ?? [], // Utilisation de l'opérateur de fusion null
            'title' => $this->data['title'] ?? 'Game Horizon'
        ]);
        echo $this->twig->render($template . '.twig', $data);
    }

    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    public function __get($name)
    {
        return $this->data[$name] ?? null;
    }
}
