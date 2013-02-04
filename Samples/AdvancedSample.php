<?php
// require the autoloader
require_once "../ClassLoaders/NamespaceClassLoader.php";

// change to the root
chdir('../');

// create new class loader
$autoLoader = new ClassLoaders\NamespaceClassLoader(array(getcwd()));

// register the class loader
spl_autoload_register(array($autoLoader, 'loadClass'));

// create a containe
$container = new \DependencyInjectionContainers\DependencyInjectionContainer();

// Setup bindings
$container->Bind('Samples\Models\IEngine')
    ->To("Samples\Models\SpecialEngine")
    ->WithConstructorArgument("startParameter", "SuperFast!")
    ->WithConstructorArgument("stopParameter", "slowly stopping!");

$container->Bind('Samples\Models\IDriver')
    ->To("Samples\Models\SpecialDriver")
    ->WithConstructorArgument("someArgument", "Drunken!");

$container->Bind('Samples\Models\ICar')
    ->To("Samples\Models\DefaultCar");

// Resolve car binding
/* @var $car Samples\Models\ICar */
$car = $container->ResolveClass("Samples\Models\ICar");

// Show values
$car->Engine()->Start(); // outputs: Starting special engine: SuperFast!!.
$car->Driver()->Drive(); // outputs: Driving the special car Drunken!!...
$car->Engine()->Stop(); // outputs: Stopping special engine: slowly stopping!!

$container->Bind('Samples\Models\IEngine') // overriding binding
    ->To("Samples\Models\DefaultEngine");

// Resolve car binding
/* @var $car2 Samples\Models\ICar */
$car2 = $container->ResolveClass("Samples\Models\ICar");

// Show values
$car2->Engine()->Start(); // outputs: Starting default engine!.
$car2->Driver()->Drive(); // outputs: Driving the special car Drunken!!...
$car2->Engine()->Stop(); // outputs: Stopping default engine!