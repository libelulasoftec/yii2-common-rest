<?php

namespace taguz91\CommonRest\traits;

use yii\filters\AccessControl;
use yii\filters\auth\CompositeAuth;
use yii\filters\RateLimiter;
use yii\filters\VerbFilter;

trait ControllerBehavior
{

  /**
   * {@inheritdoc}
   */
  public function behaviors()
  {
    $behavior = [
      'verbFilter' => [
        'class' => VerbFilter::class,
        'actions' => $this->verbs(),
      ],
      'authenticator' => [
        'class' => CompositeAuth::class,
      ],
      'rateLimiter' => [
        'class' => RateLimiter::class,
      ],
      'corsFilter' => [
        'class' => OptionsCors::class,
      ],
    ];

    $rules = $this->rules();
    if (!empty($rules)) {
      $behavior['access'] = [
        'class' => AccessControl::class,
        'rules' => $this->rules(),
      ];
    }
    return $behavior;
  }

  /**
   * {@inheritdoc}
   */
  protected function verbs()
  {
    return [];
  }

  protected function rules()
  {
    return [];
  }
}
