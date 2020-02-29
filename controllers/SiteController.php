<?php

namespace controllers;
use core\Controller;
use core\View;
use models\Page;

/**
 * Class SiteController
 */
class SiteController extends Controller
{
    public function indexAction()
    {
        $model = new Page;
        $data  = $model->setDatabase($this->database)->getOne(1);

        return View::render('site/index', [
            'data' => $data
        ]);
    }

    public function testAction()
    {
        echo 'test page';
        print_r($_REQUEST);
    }
}