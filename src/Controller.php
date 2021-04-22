<?php

namespace taguz91\CommonRest;

use taguz91\CommonRest\traits\ControllerBehavior;
use Yii;
use yii\web\Controller as WebController;
use yii\web\Response;

class Controller extends WebController
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

  /**
   * @inheritdoc
   */
  public function afterAction($action, $result)
  {
    $result = parent::afterAction($action, $result);
    if (is_null($result)) Yii::$app->response->content = '';

    // Si no es un strign no validamos nada 
    if (!is_string($result)) return $result;

    if (($data = json_decode($result)) !== false) {
      if (is_object($data)) return $data;
    }

    // Si es un PDF lo mostramos ya no seteamos a json
    if (Yii::$app->response->headers->get('Content-Type') === 'application/pdf') {
      return $result;
    }

    Yii::$app->response->format = Response::FORMAT_HTML;
    Yii::$app->response->headers->remove('Content-Type', 'application/json');
    return $result;
  }

  /**
   * @inheritdoc
   */
  public function render($view, $params = [])
  {
    Yii::$app->response->format = Response::FORMAT_HTML;
    Yii::$app->response->headers->remove('Content-Type', 'application/json');
    return parent::render($view, $params);
  }
}
