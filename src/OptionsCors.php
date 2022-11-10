<?php

namespace Libelulasoft\CommonRest;

use Yii;

use yii\filters\Cors;

class OptionsCors extends Cors
{

  /**
   * @var array Basic headers handled for the CORS requests.
   */
  public $cors = [
    'Origin' => ['*'],
    'Access-Control-Allow-Origin' => ['*'],
    'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
    'Access-Control-Request-Headers' => ['*'],
    'Access-Control-Allow-Credentials' => false,
    'Credentials' => false,
    'Access-Control-Max-Age' => 86400,
    'Access-Control-Expose-Headers' => ['X-Pagination-Current-Page'],
  ];

  public function beforeAction($action)
  {
    parent::beforeAction($action);
    $requestMethod = Yii::$app->getRequest()->getMethod();

    if (strtoupper($requestMethod) === 'OPTIONS') {
      Yii::$app->getResponse()->getHeaders()->set('Allow', 'POST GET PUT DELETE');
      Yii::$app->end();
    }

    return true;
  }
}
