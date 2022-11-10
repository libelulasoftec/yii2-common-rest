<?php

namespace Libelulasoft\CommonRest;

use Libelulasoft\CommonRest\traits\ControllerBehavior;
use Yii;
use yii\web\Controller as WebController;
use yii\web\Response;

class Controller extends WebController
{

  const APPLICATION_JSON = 'application/json';

  use ControllerBehavior;

  /**
   * @inheritdoc
   */
  public function beforeAction($action)
  {
    Yii::$app->response->format = Response::FORMAT_JSON;
    Yii::$app->response->headers->add('Content-Type', self::APPLICATION_JSON);
    $this->enableCsrfValidation = false;
    return parent::beforeAction($action);
  }

  /**
   * @inheritdoc
   */
  public function afterAction($action, $result)
  {
    $result = parent::afterAction($action, $result);
    if (is_null($result)) {
      Yii::$app->response->content = '';
    }

    // Si no es un strign no validamos nada
    if (!is_string($result)) {
      return $result;
    }

    if (($data = json_decode($result)) !== false) {
      if (is_object($data)) {
        return $data;
      }
    }

    // Si es un PDF lo mostramos ya no seteamos a json
    if (Yii::$app->response->headers->get('Content-Type') === 'application/pdf') {
      return $result;
    }

    Yii::$app->response->format = Response::FORMAT_HTML;
    Yii::$app->response->headers->remove('Content-Type', self::APPLICATION_JSON);
    return $result;
  }

  /**
   * @inheritdoc
   */
  public function render($view, $params = [])
  {
    Yii::$app->response->format = Response::FORMAT_HTML;
    Yii::$app->response->headers->remove('Content-Type', self::APPLICATION_JSON);
    return parent::render($view, $params);
  }
}
