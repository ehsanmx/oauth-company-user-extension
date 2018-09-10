<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\RestRequestValidator\Processor\Validator\Constraint;

use Spryker\Glue\RestRequestValidator\Business\Exception\ClassDoesNotExist;
use Spryker\Glue\RestRequestValidator\RestRequestValidatorConfig;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraint;

class RestRequestValidatorConstraintResolver implements RestRequestValidatorConstraintResolverInterface
{
    protected const INSTANTIATE_CONSTRAINT_FROM_CONFIG_METHOD = 'instantiateConstraintFromConfig';

    /**
     * @var \Spryker\Glue\RestRequestValidator\RestRequestValidatorConfig
     */
    protected $config;

    /**
     * @param \Spryker\Glue\RestRequestValidator\RestRequestValidatorConfig $config
     */
    public function __construct(RestRequestValidatorConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @param array $validationConfig
     *
     * @return array
     */
    public function initializeConstraintCollection(array $validationConfig): array
    {
        $configResult = [];
        foreach ($validationConfig as $fieldName => $validators) {
            if ($validators !== null) {
                $configResult[$fieldName] = $this->mapFieldConstrains($validators);
            }
        }

        return $configResult;
    }

    /**
     * @param array $validators
     *
     * @return array
     */
    protected function mapFieldConstrains(array $validators): array
    {
        foreach ($validators as $key => $validator) {
            if (!is_array($validator)) {
                $validators[$key] = [$validator => null];
            }
        }

        return array_map(
            [$this, static::INSTANTIATE_CONSTRAINT_FROM_CONFIG_METHOD],
            $validators
        );
    }

    /**
     * @param array $classDeclaration
     *
     * @return \Symfony\Component\Validator\Constraint
     */
    protected function instantiateConstraintFromConfig(array $classDeclaration): Constraint
    {
        $shortClassName = key($classDeclaration);
        $parameters = reset($classDeclaration);

        $className = $this->resolveConstraintClassName($shortClassName);

        return new $className($parameters);
    }

    /**
     * @param string $className
     *
     * @throws \Spryker\Glue\RestRequestValidator\Business\Exception\ClassDoesNotExist
     *
     * @return string|null
     */
    protected function resolveConstraintClassName(string $className): ?string
    {
        foreach ($this->config->getAvailableConstraintNamespaces() as $constraintNamespace) {
            if (class_exists($constraintNamespace . $className)) {
                return $constraintNamespace . $className;
            }
        }

        throw new ClassDoesNotExist(
            sprintf(RestRequestValidatorConfig::EXCEPTION_MESSAGE_CLASS_NOT_FOUND, $className),
            Response::HTTP_NOT_FOUND
        );
    }
}
