<?php

namespace controllers;
use core\Controller;
use core\View;
use models\Page;

/**
 * Class PageController
 */
class PageController extends Controller
{
	public function homeAction(){
		return View::render('site/home', []);		
	}
    public function indexAction()
    {
        $model = new Page;
        $data  = $model->setDatabase($this->database)->getAll();

        return View::render('site/index', [
            'data' => $data
        ]);
    }
}