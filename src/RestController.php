<?php

namespace taguz91\CommonRest;

use taguz91\CommonRest\traits\ControllerBehavior;
use Yii;
use yii\rest\Controller as BaseController;
use yii\web\Response;

class RestController extends BaseController
{

  use ControllerBehavior;

  /**
   * @inheritdoc
   */
  public function beforeAction($action)
  {
    date_default_timezone_set("America/Guayaquil");
    Yii::$app->response->format = Response::FORMAT_JSON;
    Yii::$app->response->headers->add('Content-Type', 'application/json');
    $this->enableCsrfValidation = false;
    return parent::beforeAction($action);
  }
}
