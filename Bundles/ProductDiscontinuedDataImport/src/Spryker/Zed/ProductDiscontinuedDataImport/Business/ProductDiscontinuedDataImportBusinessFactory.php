<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductDiscontinuedDataImport\Business;

use Spryker\Zed\DataImport\Business\DataImportBusinessFactory;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface;
use Spryker\Zed\ProductDiscontinuedDataImport\Business\Model\ProductDiscontinuedWriterStep;
use Spryker\Zed\ProductDiscontinuedDataImport\Business\Model\Step\AddLocalesStep;
use Spryker\Zed\ProductDiscontinuedDataImport\Business\Model\Step\ConcreteSkuToIdProductStep;
use Spryker\Zed\ProductDiscontinuedDataImport\Business\Model\Step\NoteExtractorStep;

/**
 * @method \Spryker\Zed\ProductDiscontinuedDataImport\ProductDiscontinuedDataImportConfig getConfig()
 */
class ProductDiscontinuedDataImportBusinessFactory extends DataImportBusinessFactory
{
    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataImporterInterface|\Spryker\Zed\DataImport\Business\Model\DataImporterBeforeImportAwareInterface|\Spryker\Zed\DataImport\Business\Model\DataImporterAfterImportAwareInterface|\Spryker\Zed\DataImport\Business\Model\DataSet\DataSetStepBrokerAwareInterface
     */
    public function createProductDiscontinuedDataImport()
    {
        $dataImporter = $this->getCsvDataImporterFromConfig(
            $this->getConfig()->getProductDiscontinuedDataImporterConfiguration()
        );

        $dataSetStepBroker = $this->createTransactionAwareDataSetStepBroker()
            ->addStep($this->createAddLocalesStep())
            ->addStep($this->createNoteExtractorStep())
            ->addStep($this->createConcreteSkuToIdProductStep())
            ->addStep(new ProductDiscontinuedWriterStep());

        $dataImporter->addDataSetStepBroker($dataSetStepBroker);

        return $dataImporter;
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface
     */
    public function createAddLocalesStep(): DataImportStepInterface
    {
        return new AddLocalesStep($this->getStore());
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface
     */
    public function createNoteExtractorStep(): DataImportStepInterface
    {
        return new NoteExtractorStep();
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface
     */
    public function createConcreteSkuToIdProductStep(): DataImportStepInterface
    {
        return new ConcreteSkuToIdProductStep();
    }
}
