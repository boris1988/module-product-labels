<?php

/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

declare(strict_types=1);

namespace BPerevyazko\ProductLabel\Controller\Ajax;

use BPerevyazko\ProductLabel\Model\CompositeLabelProvider;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Serialize\Serializer\Json as JsonSerializer;

class GetLabels implements HttpPostActionInterface
{
    /**
     * @var JsonFactory
     */
    private JsonFactory $resultJsonFactory;

    private RequestInterface $request;

    private JsonSerializer $serializer;

    private CompositeLabelProvider $labelProvider;

    private ProductRepositoryInterface $productRepository;

    /**
     * Constructor.
     *
     * @param JsonFactory $resultJsonFactory
     */
    public function __construct(
        RequestInterface $request,
        JsonSerializer $serializer,
        ProductRepositoryInterface $productRepository,
        CompositeLabelProvider $labelProvider,
        JsonFactory $resultJsonFactory
    ) {
        $this->resultJsonFactory = $resultJsonFactory;
        $this->serializer        = $serializer;
        $this->request           = $request;
        $this->productRepository = $productRepository;
        $this->labelProvider     = $labelProvider;
    }

    /**
     * @return Json
     */
    public function execute(): Json
    {
        $response   = [
            'errors' => false
        ];
        $resultJson = $this->resultJsonFactory->create();

        $productIds = $this->serializer->unserialize($this->request->getContent());
        if (empty($productIds)) {
            return $resultJson->setData($response);
        }

        try {
            $labels = [];
            foreach ($productIds as $productId) {
                $product       = $this->productRepository->getById($productId);
                $productLabels = $this->labelProvider->get($product);
                if (!empty($productLabels)) {
                    $labels[$productId] = $productLabels;
                }
            }

            $response['labels'] = $labels;
        } catch (NoSuchEntityException $e) {
            return $resultJson->setData($response);
        }

        return $resultJson->setData($response);
    }
}
