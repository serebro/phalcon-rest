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
	public function getAction() {
		$order_id = $this->dispatcher->getParam('id');

		if (!$order_id) {
			return $this->response->error('not_valid');
		}

		if (!$order = Order::findOne($order_id)) {
			return $this->response->error('not_found');
		}

		$this->view->order = $order;
		$this->view->pick('order/item');
	}
}

```

### Json Response Views

/responses/orders/index.json.php
```php
<?php
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

/responses/orders/item.json.php
```php
<?php
return $this->partial('order/_item', ['order' => $order]);
```

/responses/orders/_item.json.php
```php
<?php
return [
	'id' => $order->id,
	'createdAt' => $order->created_at,
	'userId' => $order->user_id,
	'sum' => $order->sum,
];
```

