<?php

namespace DependencyResolvers
{
    use ReflectionParameter;
    use ReflectionMethod;
    use Exception;

    /**
     * Dependency resolver
     */
    class DependencyResolver implements IDependencyResolver
    {
        private $_docBlockCache = array();

        /**
         * Resolves method
         * @param string $className
         * @param string $methodName
         * @return ReflectionParameter[]
         */
        public function ResolveMethodParameters($className, $methodName)
        {
            return $this->ResolveMethod($className, $methodName)->getParameters();
        }

        /**
         * @param string $className
         * @param string $methodName
         * @return ReflectionMethod
         * @throws Exception
         */
        public function ResolveMethod($className, $methodName)
        {
            // ensure class exists
            if (!class_exists($className))
            {
                throw new Exception("Class doesn't exists");
            }

            // ensure method exists
            if (!method_exists($className, $methodName))
            {
                throw new Exception("Method doesn't exits");
            }

            return new ReflectionMethod($className, $methodName);
        }

        /**
         * @param string $className
         * @param string $methodName
         * @param string $parameterName
         * @return string|null type
         */
        public function ResolveMethodParameterTypeFromDocComment($className, $methodName, $parameterName)
        {
            if (isset($this->_docBlockCache[$className][$methodName][$parameterName]))
            {
                return $this->_docBlockCache[$className][$methodName][$parameterName];
            }

            $this->UpdateMethodDocCommentCache($className, $methodName);

            if (isset($this->_docBlockCache[$className][$methodName][$parameterName]))
            {
                return $this->_docBlockCache[$className][$methodName][$parameterName];
            }
            else
            {
                return null;
            }
        }

        /**
         * @param string $className
         * @param string $methodName
         */
        private function UpdateMethodDocCommentCache($className, $methodName)
        {
            $reflectionMethod = $this->ResolveMethod($className, $methodName);

            $docComment = $reflectionMethod->getDocComment();

            if (!$docComment)
            {
                return;
            }

            $tags = array();

            // First remove doc block line starters
            $docComment = preg_replace('#[ \t]*(?:\/\*\*|\*\/|\*)?[ ]{0,1}(.*)?#', '$1', $docComment);
            $docComment = ltrim($docComment, "\r\n");

            // Next parse out the tags and descriptions
            $parsedDocComment = $docComment;
            $lineNumber = $firstBlandLineEncountered = 0;
            while (($newlinePos = strpos($parsedDocComment, "\n")) !== false)
            {
                $lineNumber++;
                $line = substr($parsedDocComment, 0, $newlinePos);

                $matches = array();

                if ((strpos($line, '@') === 0) && (preg_match('#^(@\w+.*?)(\n)(?:@|\r?\n|$)#s', $parsedDocComment, $matches))) {
                    $tags[] = trim($matches[1]);
                }

                $parsedDocComment = substr($parsedDocComment, $newlinePos + 1);
            }

            foreach ($tags as $tag)
            {
                if (preg_match_all('/^@(\w+)\s+([\w|\\\]+)(?:\s+(\$\S+))?(?:\s+(.*))?/s', $tag, $matches))
                {
                    $parameterName = str_replace('$', '', $matches[3][0]);
                    $parameterType = $matches[2][0];

                    if (!isset($this->_docBlockCache[$className]))
                    {
                        $this->_docBlockCache[$className] = array();
                    }

                    if (!isset($this->_docBlockCache[$className][$methodName]))
                    {
                        $this->_docBlockCache[$className][$methodName] = array();
                    }

                    $this->_docBlockCache[$className][$methodName][$parameterName] = $parameterType;
                }
            }
        }
    }
}


