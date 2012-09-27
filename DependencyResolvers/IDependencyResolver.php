<?php

namespace DependencyResolvers
{
    use ReflectionParameter;
    use ReflectionMethod;

    /**
     * Depedency resolver
     */
    interface IDependencyResolver
    {
        /**
         * Resolves method parameters
         * @param string $className
         * @param string $methodName
         * @return ReflectionParameter[]
         */
        public function ResolveMethodParameters($className, $methodName);

        /**
         * @abstract
         * @param string $className
         * @param string $methodName
         * @return ReflectionMethod
         */
        public function ResolveMethod($className, $methodName);

        /**
         * @param string $className
         * @param string $methodName
         * @param string $parameterName
         */
        public function ResolveMethodParameterTypeFromDocComment($className, $methodName, $parameterName);
    }
}

