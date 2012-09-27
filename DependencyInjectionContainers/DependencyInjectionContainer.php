<?php
namespace DependencyInjectionContainers
{
    use Exception;
    use DependencyResolvers\IDependencyResolver;

    /**
     * DI Container
     */
    class DependencyInjectionContainer implements IDependencyInjectionContainer
    {
        private $_boundInterfaces = array();
        private $_dependencyResolver;

        /**
         * Constructor
         */
        public function __construct(){}

        /**
         * Bind interface to Class
         * @param string $Interface
         * @return IInjectionInterface
        */
        public function Bind($Interface)
        {
            $this->_boundInterfaces[$Interface] = new InjectionInterface($this);

            return $this->_boundInterfaces[$Interface];
        }

        /**
         * Resolve class
         * @param string $Interface
         * @return object
         */
        public function ResolveClass($Interface)
        {
            $ResolvedInterface = $this->GetBoundInterface($Interface);

            return $ResolvedInterface->RetrieveInstance();
        }

        /**
         * Gets bounded interface
         * @param string $Interface
         * @return IInjectionInterface
         */
        private function GetBoundInterface($Interface)
        {
            if (!isset($this->_boundInterfaces[$Interface]))
            {
                throw new Exception("Interface: " . $Interface . " is not bound");
            }

            return $this->_boundInterfaces[$Interface];
        }

        /**
         * Clears all current bound mappings
         * @return void
         */
        public function Clear()
        {
            $this->_boundInterfaces = array();
        }

        /**
         * Constructs class depending on dependencies bounded on container
         * @param string $Class
         * @param array $AdditionalParameters
         * @return object
         */
        public function ConstructClass($Class, array $AdditionalParameters = array())
        {
            if (!is_string($Class) || strlen($Class) == 0)
            {
                throw new Exception("Class is required");
            }

            if (!class_exists($Class))
            {
                throw new Exception("Class: " . $Class . " doens't exists");
            }

            if (!method_exists($Class, '__construct'))
            {
                return new $Class;
            }

            $methodParameters = $this->_depencyResolver->ResolveMethodParameters($Class, '__construct');

            $Parameters = array();

            if (count($methodParameters) > 0)
            {
                foreach ($methodParameters AS $Parameter)
                {
                    if ($Parameter->getClass() && interface_exists($Parameter->getClass()->name))
                    {
                        $ParameterValue = $this->ResolveClass($Parameter->getClass()->name);
                    }
                    else
                    {
                        if ($Parameter->isDefaultValueAvailable())
                        {
                            $ParameterValue = $Parameter->getDefaultValue();
                        }
                        else if (isset($AdditionalParameters[$Parameter->getName()]))
                        {
                            $ParameterValue = $AdditionalParameters[$Parameter->getName()];
                        }
                        else
                        {
                            throw new Exception("Missing Parameter: " . $Parameter->getName());
                        }
                    }

                    $Parameters[$Parameter->getPosition()] = $ParameterValue;
                }
            }

            $ReflectionObject = new ReflectionClass($Class);
            return $ReflectionObject->newInstanceArgs($Parameters);
        }

        /**
         * @param IDependencyResolver $dependencyResoler
         */
        public function SetDependencyResolver(IDependencyResolver $dependencyResoler)
        {
            $this->_dependencyResolver = $dependencyResoler;
        }
    }
}
