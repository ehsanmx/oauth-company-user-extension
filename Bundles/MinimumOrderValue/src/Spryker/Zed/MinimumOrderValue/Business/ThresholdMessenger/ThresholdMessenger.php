<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\MinimumOrderValue\Business\ThresholdMessenger;

use Generated\Shared\Transfer\CurrencyTransfer;
use Generated\Shared\Transfer\MessageTransfer;
use Generated\Shared\Transfer\MinimumOrderValueThresholdTransfer;
use Generated\Shared\Transfer\MoneyTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Shared\MinimumOrderValue\MinimumOrderValueConfig;
use Spryker\Zed\MinimumOrderValue\Business\QuoteExpander\QuoteExpanderInterface;
use Spryker\Zed\MinimumOrderValue\Dependency\Facade\MinimumOrderValueToMessengerFacadeInterface;
use Spryker\Zed\MinimumOrderValue\Dependency\Facade\MinimumOrderValueToMoneyFacadeInterface;

class ThresholdMessenger implements ThresholdMessengerInterface
{
    protected const THRESHOLD_GLOSSARY_PARAMETER = '{{threshold}}';

    /**
     * @var \Spryker\Zed\MinimumOrderValue\Dependency\Facade\MinimumOrderValueToMessengerFacadeInterface
     */
    protected $messengerFacade;

    /**
     * @var \Spryker\Zed\MinimumOrderValue\Dependency\Facade\MinimumOrderValueToMoneyFacadeInterface
     */
    protected $moneyFacade;

    /**
     * @var \Spryker\Zed\MinimumOrderValue\Business\QuoteExpander\QuoteExpanderInterface
     */
    protected $quoteExpander;

    /**
     * @param \Spryker\Zed\MinimumOrderValue\Dependency\Facade\MinimumOrderValueToMessengerFacadeInterface $messengerFacade
     * @param \Spryker\Zed\MinimumOrderValue\Dependency\Facade\MinimumOrderValueToMoneyFacadeInterface $moneyFacade
     * @param \Spryker\Zed\MinimumOrderValue\Business\QuoteExpander\QuoteExpanderInterface $quoteExpander
     */
    public function __construct(
        MinimumOrderValueToMessengerFacadeInterface $messengerFacade,
        MinimumOrderValueToMoneyFacadeInterface $moneyFacade,
        QuoteExpanderInterface $quoteExpander
    ) {
        $this->messengerFacade = $messengerFacade;
        $this->moneyFacade = $moneyFacade;
        $this->quoteExpander = $quoteExpander;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function addMinimumOrderValueThresholdCartInfoMessages(
        QuoteTransfer $quoteTransfer
    ): QuoteTransfer {
        $quoteTransfer = $this->quoteExpander->addMinimumOrderValueThresholdsToQuote($quoteTransfer);

        $thresholdMessages = $this->getMessagesForThresholds($quoteTransfer);
        foreach ($thresholdMessages as $thresholdMessage) {
            $this->messengerFacade->addInfoMessage($thresholdMessage);
        }

        return $quoteTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\MessageTransfer[]
     */
    protected function getMessagesForThresholds(QuoteTransfer $quoteTransfer): array
    {
        $minimumOrderValueThresholdTransfers = $this->filterMinimumOrderValuesByThresholdGroup(
            $quoteTransfer->getMinimumOrderValueThresholdCollection()->getArrayCopy(),
            MinimumOrderValueConfig::GROUP_SOFT
        );

        $thresholdMessages = [];
        foreach ($minimumOrderValueThresholdTransfers as $minimumOrderValueThresholdTransfer) {
            $thresholdMessages[$minimumOrderValueThresholdTransfer->getMessageGlossaryKey()] =
                $this->createMessageTransfer($minimumOrderValueThresholdTransfer, $quoteTransfer->getCurrency());
        }

        return $thresholdMessages;
    }

    /**
     * @param \Generated\Shared\Transfer\MinimumOrderValueThresholdTransfer $minimumOrderValueThresholdTransfer
     * @param \Generated\Shared\Transfer\CurrencyTransfer $currencyTransfer
     *
     * @return \Generated\Shared\Transfer\MessageTransfer
     */
    protected function createMessageTransfer(
        MinimumOrderValueThresholdTransfer $minimumOrderValueThresholdTransfer,
        CurrencyTransfer $currencyTransfer
    ): MessageTransfer {
        return (new MessageTransfer())
            ->setValue($minimumOrderValueThresholdTransfer->getThresholdNotMetMessageGlossaryKey())
            ->setParameters([
                static::THRESHOLD_GLOSSARY_PARAMETER => $this->moneyFacade->formatWithSymbol(
                    $this->createMoneyTransfer($minimumOrderValueThresholdTransfer, $currencyTransfer)
                ),
            ]);
    }

    /**
     * @param \Generated\Shared\Transfer\MinimumOrderValueThresholdTransfer $minimumOrderValueThresholdTransfer
     * @param \Generated\Shared\Transfer\CurrencyTransfer $currencyTransfer
     *
     * @return \Generated\Shared\Transfer\MoneyTransfer
     */
    protected function createMoneyTransfer(
        MinimumOrderValueThresholdTransfer $minimumOrderValueThresholdTransfer,
        CurrencyTransfer $currencyTransfer
    ): MoneyTransfer {
        return (new MoneyTransfer())
            ->setAmount(
                (string)$minimumOrderValueThresholdTransfer->getThreshold()
            )->setCurrency($currencyTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\MinimumOrderValueThresholdTransfer[] $minimumOrderValueThresholdTransfers
     * @param string $thresholdGroup
     *
     * @return \Generated\Shared\Transfer\MinimumOrderValueThresholdTransfer[]
     */
    protected function filterMinimumOrderValuesByThresholdGroup(array $minimumOrderValueThresholdTransfers, string $thresholdGroup): array
    {
        return array_filter($minimumOrderValueThresholdTransfers, function (MinimumOrderValueThresholdTransfer $minimumOrderValueThresholdTransfers) use ($thresholdGroup) {
            return $minimumOrderValueThresholdTransfers->getMinimumOrderValueType()->getThresholdGroup() === $thresholdGroup;
        });
    }
}
