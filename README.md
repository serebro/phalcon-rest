Phalcon Rest
---

### Configuration

View Engine
```php
'jsonEngine' => [
	'className' => '\PhalconRest\Mvc\View\Engine\Json',
	'calls' => [
		['method' => 'setJsonEncodeOptions', 'arguments' => [
			['type' => 'parameter', 'value' => JSON_UNESCAPED_UNICODE | JSON_BIGINT_AS_STRING | JSON_PRETTY_PRINT],
		]],
	],
],
```

Rest View
```php
'view'   => [
	'className' => '\PhalconRest\Mvc\RestView',
	'calls' => [
		['method' => 'setViewsDir', 'arguments' => [
			['type' => 'parameter', 'value' => APP_PATH . '/responses/'],
		]],
		['method' => 'registerEngines', 'arguments' => [
			['type' => 'parameter', 'value' => [
				'.json.php' => 'jsonEngine',
			]],
		]],
	],
],
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

