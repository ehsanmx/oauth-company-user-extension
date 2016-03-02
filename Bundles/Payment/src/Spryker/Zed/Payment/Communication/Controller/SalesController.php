<?php

namespace Spryker\Zed\Payment\Communication\Controller;

use Spryker\Zed\Application\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class SalesController extends AbstractController
{
    public function listAction(Request $request)
    {
        return [
            'logs' => [
                [
                    'logType' => 'type',
                    'TransactionId' => uniqid(),
                    'Request' => 'request',
                    'Status' => 'active',
                    'CreatedAt' => new \DateTime('now'),
                ]
            ]
        ];
    }
}
