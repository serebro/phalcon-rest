Phalcon Rest
---
[![Phalconist](http://phalconist.com/serebro/phalcon-rest/default.svg)](http://phalconist.com/serebro/phalcon-rest)

### Configuration

View Engine
```php
 
new \PhalconRest\ServiceProvider($di);

$di->set('view', function() use($di) {
    /** @var \PhalconRest\Mvc\RestView $restView */
    $restView = $di->get('restView');
    $restView->setBasePath('/app/responses/');
    return $restView;
});
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

namespace Controllers;

class OrdersController extends \PhalconRest\Mvc\ControllerBase {
	public function indexAction() {
		$this->view->total = Order::count();
		$this->view->orders = Order::find();
	}

	public function getAction() {
		$order_id = $this->dispatcher->getParam('id');
		$this->view->order = Order::findFirst($order_id);
		$this->view->pick('orders/item');
	}
}

```

### Response Views

```php
<?php

/* /app/responses/orders/index.php */

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

/* /app/responses/orders/item.php */

return function ($params) {

	return $this->partial('order/_item', ['order' => $order]);
	
};
```

```php
<?php
/* /app/responses/orders/_item.php */

return function ($params) {

	return [
		'id' => $order->id,
		'createdAt' => $order->created_at,
		'userId' => $order->user_id,
		'sum' => $order->sum,
	];
	
};
```
