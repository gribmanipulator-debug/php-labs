<?php

class Controller
{
    protected Request $request;
    protected PageView $view;

    public function __construct()
    {
        $this->request = new Request();
        $this->view = new PageView();
    }

    public function redirect(string $route): void
    {
        $baseUrl = defined('BASE_URL') ? BASE_URL : '';
        $normalizedRoute = ltrim($route, '/');

        header('Location: ' . $baseUrl . '/index.php?route=' . $normalizedRoute);
        exit;
    }
}
