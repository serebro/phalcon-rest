Phalcon Rest
---

### Configuration

View Engine
```php
$di->set('jsonEngine', function() {
	$engine = new \PhalconRest\Mvc\View\Engine\Json();
	$engine
		->setJsonEncodeOptions(JSON_UNESCAPED_UNICODE | JSON_BIGINT_AS_STRING | JSON_PRETTY_PRINT)
		->setJsonpContentType('application/jsonp')
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
	$restView->registerEngines(['.json.php' => 'jsonEngine']);
	return $restView; 
});
```

### Controller

ExampleController.php
```php
class OrdersController extends Controller {
	public function indexAction() {
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
/* /responses/orders/index.json.php */
$items = [];
foreach ($orders as $order) {
	$items[] = $this->partial('orders/_item', ['order' => $order]);
}

return [
	'meta' => (object)[
		'number' => count($orders),
		'total' => count($orders),
	],
	'results' => $items
];
```

```php
<?php
/* /responses/orders/item.json.php */
return $this->partial('order/_item', ['order' => $order]);
```

```php
<?php
/* /responses/orders/_item.json.php */
return [
	'id' => $order->id,
	'createdAt' => $order->created_at,
	'userId' => $order->user_id,
	'sum' => $order->sum,
];
```
