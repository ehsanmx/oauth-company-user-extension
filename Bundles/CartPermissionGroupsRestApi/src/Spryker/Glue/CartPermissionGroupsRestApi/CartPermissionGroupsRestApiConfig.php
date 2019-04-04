<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Glue\CartPermissionGroupsRestApi;

use Spryker\Glue\Kernel\AbstractBundleConfig;

class CartPermissionGroupsRestApiConfig extends AbstractBundleConfig
{
    public const RESOURCE_CART_PERMISSION_GROUPS = 'cart-permission-groups';

    public const CONTROLLER_CART_PERMISSION_GROUPS = 'cart-permission-groups-resource';

    public const ACTION_CART_PERMISSION_GROUPS_GET = 'get';

    public const RESPONSE_CODE_CART_PERMISSION_GROUP_NOT_FOUND = '2501';
    public const RESPONSE_CODE_CART_PERMISSION_GROUP_INVALID_IDENTIFIER = '2501';
    public const RESPONSE_CODE_CART_PERMISSION_GROUP_UNEXPECTED_ERROR = '2503';

    public const RESPONSE_DETAIL_CART_PERMISSION_GROUP_NOT_FOUND = 'Cart permission group not found.';
    public const RESPONSE_DETAIL_CART_PERMISSION_GROUP_INVALID_IDENTIFIER = 'Invalid cart permission group id.';
    public const RESPONSE_DETAIL_CART_PERMISSION_GROUP_UNEXPECTED_ERROR = 'Unexpected error.';
}
