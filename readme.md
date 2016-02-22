
# Ensphere Container

Maps classes to certain areas to inject processes and views.

## Getting started

```cli
composer require ensphere/container:1.*
```

add the service provider

```cli
Ensphere\Container\Providers\ServiceProvider::class
```

### Define a binding area

```php
$container = $app['ensphere.container'];
$container->register( 'dashboard-top-bar' )
```

### Supply functionality

create a content stub.

```php
use Ensphere\Container\Content;
use Illuminate\Http\Request;

class Stub extends Content {

	/**
	 * the view to be rendered in said area
	 * @var string
	 */
	protected $view = 'views.view';

	/**
	 * Validates pass instance of Validator back to the container to validate this section.
	 * @param  Request $request - Illuminate\Http\Request
	 * @return Instance of Illuminate\Contracts\Validation\Validator
	 */
	public function validate( Request $request  )
	{

	}

	/**
	 * called once all validation has passed from other areas.
	 * @param  Request $request - Illuminate\Http\Request
	 * @return NULL
	 */
	public function process( Request $request )
	{

	}

}
```

### Bind the stub to the area

```php
$container->bind( 'dashboard-top-bar', [
	Namespace\To\Your\Stub::class
]);
```

### Render the views
```php
$topBar = $container->render( 'dashboard-top-bar' );
```




### The MIT License (MIT)

Copyright (c) 2016 ensphere

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
