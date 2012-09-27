<?php

namespace DependencyInjectionContainers
{
    use DependencyResolvers\IDependencyResolver;

    /**
     * Dependency injection container
     */
    interface IDependencyInjectionContainer
    {
        /**
         * Gets instance of class
         * @param string $Interface
         * @return object of class
         */
        public function ResolveClass($Interface);

        /**
         * @param IDependencyResolver $dependencyResoler
         */
        public function SetDependencyResolver(IDependencyResolver $dependencyResoler);

        /**
         * Constructs class depending on dependencies bounded on container
         * @param string $Class
         * @param array $AdditionalParameters
         * @return object
         */
        public function ConstructClass($Class, array $AdditionalParameters = array());

        /**
         * Setup interface to bind to an Class
         * @param string $Interface
         * @return IInjectionInterface
         */
        public function Bind($Interface);

        /**
         * Clears all current bound mappings
         * @return void
         */
        public function Clear();
    }
}

