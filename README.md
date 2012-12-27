# SimpleContainer
[![Build Status](https://travis-ci.org/stanlemon/simple-container.png?branch=master)](https://travis-ci.org/stanlemon/simple-container)

SimpleContainer is a basic service container, it can store key => value objects and lazily load them using Closures.  It also includes a newInstance() method which allows you to inject dependencies through constructors and setters providing for very basic dependency injection.

## Example usages

### Basic loading of services and retrieving of them

	// Create the SimpleContainer
	$container = new SimpleContainer();
	// Set a service
	$container->set('foo', function(){
		return new Foo();
	});
	// Get the service
	$foo = $container->get('foo');
	// Create a new class with services populaed
	$bar = $container->newInstance('bar');
	$bar->getFoo();

