<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

class ProverkaController extends Controller
{
    public function actionWork()
    {
        Yii::info("Сообщение успешно отправлено:");
        return $this->render('work');
    }
}
?>