Common rest
===========
Common rest utilities


Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
composer require --prefer-dist libelulasoft/yii2-common-rest
```

or add

```
"libelulasoft/yii2-common-rest": "^1.0.0"
```

to the require section of your `composer.json` file.


Migration
-----

Si se quiere migrar de la version `taguz91/yii2-common-rest` a la nueva version `libelulasoft/yii2-common-rest` se debe seguir los siguientes pasos: 

1. Seguir la guia de migracion para [yii2-common-helpers](https://github.com/libelulasoftec/yii2-common-helpers).

2. Seguir la guia de migracion para [yii2-error-handler](https://github.com/libelulasoftec/yii2-error-handler).

3. Eliminar la version actual

```
composer remove taguz91/yii2-common-rest
```

4. Instalar la nueva version 

```
composer require libelulasoft/yii2-common-rest
```

5. Se debe cambiar el namespace `taguz91\CommonRest` a `Libelulasoft\CommonRest` en todo el proyecto.

6. Probamos que todo funcione de forma correcta.


Usage
-----

Once the extension is installed, simply use it in your code by: