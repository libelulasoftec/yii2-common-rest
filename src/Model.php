<?php

namespace Libelulasoft\CommonRest;

use taguz91\CommonHelpers\RequestHelpers;
use taguz91\CommonRest\exceptions\InvalidClassException;
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

  /**
   * Create a model
   */
  public static function instanceModel(array $data)
  {
    $model = new static();
    $model->load($data, '');
    return $model;
  }

  /**
   * Create a model recursive
   */
  public static function instanceRecursive(
    array $data,
    array $recursive
  ) {
    foreach ($recursive as $attribute => $class) {

      if (is_array($class)) {
        list($classPath, $recursiveChild) = $class;

        $recursiveModel = new $classPath();
        if (!$recursiveModel instanceof Model) {
          throw new InvalidClassException("The class '{$classPath}' isn't recursive.");
        }

        $data[$attribute] = $recursiveModel::instanceRecursive(
          $data[$attribute],
          $recursiveChild
        );
      } elseif (is_string($class)) {
        $recursiveModel = new $class();
        if (!$recursiveModel instanceof Model) {
          throw new InvalidClassException("The class '{$class}' isn't recursive.");
        }

        $data[$attribute] = $recursiveModel::instanceModel($data[$attribute]);
      }
    }

    return self::instanceModel($data);
  }
}
