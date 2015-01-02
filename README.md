Phalcon Rest
---

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
			['type' => 'parameter', 'value' => APP_PATH . '/responses/V1/'],
		]],
		['method' => 'registerEngines', 'arguments' => [
			['type' => 'parameter', 'value' => [
				'.json.php' => 'jsonEngine',
			]],
		]],
	],
],
```