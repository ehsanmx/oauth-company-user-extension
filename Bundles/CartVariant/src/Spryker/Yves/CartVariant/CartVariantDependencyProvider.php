<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Yves\CartVariant;

use Spryker\Yves\CartVariant\Dependency\Client\CartVariantToAvailabilityClientBridge;
use Spryker\Yves\CartVariant\Dependency\Client\CartVariantToProductClientBridge;
use Spryker\Yves\Kernel\AbstractBundleDependencyProvider;
use Spryker\Yves\Kernel\Container;

class CartVariantDependencyProvider extends AbstractBundleDependencyProvider
{
    const CLIENT_AVAILABILITY = 'CLIENT_PRODUCT_OPTION';
    const CLIENT_PRODUCT = 'CLIENT_PRODUCT';

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    public function provideDependencies(Container $container)
    {
        $container = $this->addProductClient($container);

        $container = $this->addAvailabilityClient($container);

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addProductClient(Container $container)
    {
        $container[static::CLIENT_PRODUCT] = function (Container $container) {
            return new CartVariantToProductClientBridge($container->getLocator()->product()->client());
        };
        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addAvailabilityClient(Container $container)
    {
        $container[static::CLIENT_AVAILABILITY] = function (Container $container) {
            return new CartVariantToAvailabilityClientBridge($container->getLocator()->availability()->client());
        };
        return $container;
    }
}
