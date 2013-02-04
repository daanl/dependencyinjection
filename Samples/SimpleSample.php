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
            ->To("Samples\Models\DefaultEngine");
$container->Bind('Samples\Models\IDriver')
            ->To("Samples\Models\DefaultDriver");
$container->Bind('Samples\Models\ICar')
            ->To("Samples\Models\DefaultCar");

// Resolve car binding
/* @var $car Samples\Models\ICar */
$car = $container->ResolveClass("Samples\Models\ICar");

// Show values
$car->Engine()->Start();
$car->Driver()->Drive();
$car->Engine()->Stop();
