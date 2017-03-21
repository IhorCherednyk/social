<?php

namespace app\modules\admin\controllers;

use app\controllers\AppController;

/**
 * Default controller for the `admin` module
 */
class AdminController extends AppController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
