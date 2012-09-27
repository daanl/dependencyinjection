<?php

namespace DependencyInjectionContainers
{
    /**
     * Injection interface
     */
    class InjectionInterface implements IInjectionInterface
    {
        private $_boundClass;
        private $_storedInstance;
        private $_diContainer;

        /**
         * @param IDependencyInjectionContainer $DependencyInjectionContainer
         */
        public function __construct($DependencyInjectionContainer)
        {
            $this->_diContainer = $DependencyInjectionContainer;
        }

        /**
         * Binds interface to class
         * @param string $ClassName
         * @return IInjectionClass
         */
        public function To($ClassName)
        {
            $this->_boundClass = new InjectionClass($ClassName);

            return $this->_boundClass;
        }

        /**
         * Retrieves instance for bounded class
         * @return object of class
         */
        public function RetrieveInstance()
        {
            $BoundedClass = $this->GetBoundClass();
            $Class = null;

            if ($BoundedClass->IsSingleton())
            {
                if ($this->GetStoredClass() == null)
                {
                    $this->_storedInstance = $this->_diContainer->ConstructClass($BoundedClass->GetClassName(), $BoundedClass->GetConstructorAgruments());
                }

                $Class = $this->GetStoredClass();
            }
            else
            {
                $Class = $this->_diContainer->ConstructClass($BoundedClass->GetClassName(), $BoundedClass->GetConstructorAgruments());
            }

            return $Class;
        }

        /**
         * @return IInjectionClass
         */
        private function GetBoundClass()
        {
            return $this->_boundClass;
        }

        /**
         * @return object stored instance
         */
        private function GetStoredClass()
        {
            return $this->_storedInstance;
        }
    }
}

