<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CustomersRestApi\Business;

use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \Spryker\Zed\CustomersRestApi\Business\CustomersRestApiBusinessFactory getFactory()
 * @method \Spryker\Zed\CustomersRestApi\Persistence\CustomersRestApiEntityManagerInterface getEntityManager()
 */
class CustomersRestApiFacade extends AbstractFacade implements CustomersRestApiFacadeInterface
{
    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @return void
     */
    public function updateCustomerAddressUuid(): void
    {
        $this->getFactory()->createCustomersAddressesUuidUpdater()->updateAddressesUuid();
    }
}
