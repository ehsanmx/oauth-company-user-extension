<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Search\Business\Model\Elasticsearch;

use RuntimeException;

class SnapshotHandler
{

    /**
     * @var \Elastica\Snapshot
     */
    protected $elasticaSnapshot;

    /**
     * @param \Elastica\Snapshot $elasticaSnapshot
     */
    public function __construct($elasticaSnapshot)
    {
        $this->elasticaSnapshot = $elasticaSnapshot;
    }

    /**
     * @param string $repositoryName
     * @param string $type
     * @param array $settings
     *
     * @return bool
     */
    public function registerSnapshotRepository($repositoryName, $type = 'fs', $settings = [])
    {
        return $this->elasticaSnapshot->registerRepository($repositoryName, $type, $settings)->isOk();
    }

    /**
     * @param string $repositoryName
     *
     * @return bool
     */
    public function existsSnapshotRepository($repositoryName)
    {
        try {
            $this->elasticaSnapshot->getRepository($repositoryName);

            return true;
        } catch (RuntimeException $exception) {
            return false;
        }
    }

    /**
     * @param string $repositoryName
     * @param string $snapshotName
     * @param array $options
     *
     * @return bool
     */
    public function createSnapshot($repositoryName, $snapshotName, $options = [])
    {
        return $this->elasticaSnapshot->createSnapshot($repositoryName, $snapshotName, $options, true)->isOk();
    }

    /**
     * @param string $repositoryName
     * @param string $snapshotName
     * @param array $options
     *
     * @return bool
     */
    public function createSnapshotAsync($repositoryName, $snapshotName, $options = [])
    {
        return $this->elasticaSnapshot->createSnapshot($repositoryName, $snapshotName, $options, false)->isOk();
    }

    /**
     * @param string $repositoryName
     * @param string $snapshotName
     *
     * @return bool
     */
    public function existsSnapshot($repositoryName, $snapshotName)
    {
        try {
            $this->elasticaSnapshot->getSnapshot($repositoryName, $snapshotName);

            return true;
        } catch (RuntimeException $exception) {
            return false;
        }
    }

    /**
     * @param string $repositoryName
     * @param string $snapshotName
     *
     * @return bool
     */
    public function deleteSnapshot($repositoryName, $snapshotName)
    {
        return $this->elasticaSnapshot->deleteSnapshot($repositoryName, $snapshotName)->isOk();
    }

}
