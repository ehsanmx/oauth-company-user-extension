<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ShoppingListProductOption\Business;

use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\ProductOptionCollectionTransfer;
use Generated\Shared\Transfer\ShoppingListItemTransfer;

interface ShoppingListProductOptionFacadeInterface
{
    /**
     * Specification:
     * - Removes existing shopping list product options from persistence.
     * - Creates new shopping list product options in persistence.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ShoppingListItemTransfer $shoppingListItemTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListItemTransfer
     */
    public function saveShoppingListItemProductOptions(ShoppingListItemTransfer $shoppingListItemTransfer): ShoppingListItemTransfer;

    /**
     * Specification:
     * - Removes existing shopping list product options from persistence.
     *
     * @api
     *
     * @param int $idShoppingListItem
     *
     * @return void
     */
    public function removeShoppingListItemProductOptions(int $idShoppingListItem): void;

    /**
     * Specification:
     * - Finds shopping list product options for shopping list item.
     *
     * @api
     *
     * @param int $idShoppingListItem
     *
     * @return \Generated\Shared\Transfer\ProductOptionCollectionTransfer
     */
    public function getShoppingListItemProductOptionsByIdShoppingListItem(int $idShoppingListItem): ProductOptionCollectionTransfer;

    /**
     * Specification:
     * - Populates product options in shopping list item from persistence.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ShoppingListItemTransfer $shoppingListItemTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListItemTransfer
     */
    public function expandShoppingListItemWithProductOptions(ShoppingListItemTransfer $shoppingListItemTransfer): ShoppingListItemTransfer;

    /**
     * Specification:
     * - Maps ItemTransfer product options to ShoppingListItemTransfer product options.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     * @param \Generated\Shared\Transfer\ShoppingListItemTransfer $shoppingListItemTransfer
     *
     * @return \Generated\Shared\Transfer\ShoppingListItemTransfer
     */
    public function mapCartItemProductOptionsToShoppingListItemProductOptions(ItemTransfer $itemTransfer, ShoppingListItemTransfer $shoppingListItemTransfer): ShoppingListItemTransfer;
}
