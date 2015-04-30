Phalcon Rest
---
[![Phalconist](http://phalconist.com/serebro/phalcon-rest/default.svg)](http://phalconist.com/serebro/phalcon-rest)

### Configuration

Services (config/services.php)
```php
$di = new \Phalcon\DI\FactoryDefault();

new \PhalconRest\ServiceProvider($di);
```

Router (config/routes.php)
```php
$router = new \Phalcon\Mvc\Router(false);
$router->removeExtraSlashes(true);
$router->setDefaultNamespace('Controllers');

$rest = new \PhalconRest\Mvc\Router\RestGroup();
$rest->setNamespace('Controllers\Api')
    ->setPrefix('api/')
    ->setIdFilter('[0-9]+')
    ->initDefault();

$router->mount($rest);

return $router;
```

### Controller

ExampleController.php
```php
<?php

namespace Controllers\Api;

class OrdersController extends \PhalconRest\Mvc\ControllerBase {

	public function initialize() {
		$this->rest->setViewsDir('api/');
	}
	
	public function indexAction() {
		$this->view->total = Order::count();
		$this->view->orders = Order::find();
	}

	public function getAction() {
		$order_id = $this->dispatcher->getParam('id');
		$order = Order::findFirst($order_id);
		if (!$order) {
			throw new \PhalconRest\Exception\NotFound();
		}
		
		$this->rest->order = $order;
		$this->rest->pick('orders/_item');
	}
}

```

### Response

```php
<?php
/* app/rest/orders/index.php */

return function ($params) {

	$items = [];
	foreach ($params['orders'] as $order) {
		$items[] = $this->partial('orders/_item', ['order' => $order]);
	}
	
	return [
		'results' => $items
	];

};
```

```php
<?php
/* app/rest/orders/_item.php */

return function ($params) {

	return [
		'id' => $order->id,
		'createdAt' => $order->created_at,
		'userId' => $order->user_id,
		'sum' => $order->sum,
	];
	
};
```
