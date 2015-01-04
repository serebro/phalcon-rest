Phalcon Rest
---

### Configuration

View Engine
```php
$di->set('jsonEngine', function() {
	$engine = new \PhalconRest\Mvc\View\Engine\Json();
	$engine
		->setJsonEncodeOptions(JSON_UNESCAPED_UNICODE | JSON_BIGINT_AS_STRING | JSON_PRETTY_PRINT)
		->setJsonpContentType('application/javascript')
		->setJsonContentType('application/json')
		->setCallbackParamName('json_callback')
		
	return $engine; 
});
```

Rest View
```php
$di->set('view', function(){
	$restView = new \PhalconRest\Mvc\RestView();
	$restView->setViewsDir(APP_PATH . '/responses/');
	$restView->registerEngines(['.php' => 'jsonEngine']);
	return $restView; 
});
```

Router
```php
$di->set('router', function () {
	$router = include APP_PATH . '/config/routes.php';

	$rest = new \PhalconRest\Mvc\Router\Rest();
	$rest
		->setNamespace('\Controllers\Api')
		->setPrefix('/api')
		->setIdFilter('[0-9]+')
		->init()
		->mountTo($router);

	return $router;
});
```

### Controller

ExampleController.php
```php
class OrdersController extends \Phalcon\Mvc\Controller {
	public function indexAction() {
		$this->view->total = Order::count();
		$this->view->orders = Order::findAll();
	}

	public function getAction() {
		$order_id = $this->dispatcher->getParam('id');
		$this->view->order = Order::findOne($order_id);
		$this->view->pick('orders/item');
	}
}

```

### Json Response Views

```php
<?php
/* /responses/orders/index.php */
$items = [];
foreach ($orders as $order) {
	$items[] = $this->partial('orders/_item', ['order' => $order]);
}

return [
	'meta' => (object)[
		'number' => count($items),
		'total' => $total,
	],
	'results' => $items
];
```

```php
<?php
/* /responses/orders/item.php */
return $this->partial('order/_item', ['order' => $order]);
```

```php
<?php
/* /responses/orders/_item.php */
return [
	'id' => $order->id,
	'createdAt' => $order->created_at,
	'userId' => $order->user_id,
	'sum' => $order->sum,
];
```
