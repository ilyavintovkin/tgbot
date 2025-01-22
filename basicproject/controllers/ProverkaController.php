<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

class SiteController extends Controller
{
    public function actionWork()
    {
        var_dump('rabotaet');
        die();
        return $this->render('work');
    }
}