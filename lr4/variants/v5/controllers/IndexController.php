<?php

class IndexController extends PageController
{
    public function action_main(): void
    {
        $this->render('index/main', [], 'Головна');
    }

    public function action_catalog(): void
    {
        $this->render('index/catalog', [], 'Каталог автомобілів');
    }
}
