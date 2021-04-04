<?php

namespace taguz91\CommonRest;

use taguz91\CommonHelpers\RequestHelpers;
use taguz91\ErrorHandler\exceptions\DataInvalidException;
use Yii;
use yii\base\Model as BaseModel;

class Model extends BaseModel
{

  /**
   * @return array $attributes - Nombre de los atributos de la clase
   */
  public function getKeysAttributes()
  {
    return array_keys($this->attributes);
  }

  public function rules()
  {
    return [
      [
        $this->getKeysAttributes(),
        'safe',
      ],
    ];
  }

  public function rulesRequired(array $notRequired = [])
  {
    return [
      // Todos seguros
      [
        $this->getKeysAttributes(),
        'safe',
      ],
      // Agregamos que todos son requreidos 
      [
        array_diff($this->getKeysAttributes(), $notRequired),
        'required',
      ],
    ];
  }

  /**
   * Load the data from post request
   */
  public function post(string $node = '')
  {
    $data = RequestHelpers::getPostData();
    $this->load($data, $node);
  }

  /**
   * @return static
   */
  public function postValidOrEnd(string $node = '')
  {
    $this->post($node);
    if (!$this->validate()) {
      throw new DataInvalidException(Yii::t('app', 'Invalid post data.'), $this);
    }
    return $this;
  }

  /**
   * @return static
   */
  public function loadValidOrEnd(
    array $data,
    string $errorMessage = '',
    string $node = ''
  ) {
    $this->load($data, $node);
    if (!$this->validate()) {
      throw new DataInvalidException($errorMessage, $this);
    }
    return $this;
  }
}
