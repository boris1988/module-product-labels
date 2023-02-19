<?php

declare(strict_types=1);

namespace BPerevyazko\ProductLabel\ViewModel;

use BPerevyazko\ProductLabel\Model\CompositeLabelProvider;
use BPerevyazko\ProductLabel\Model\ConfigInterface;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\Serialize\Serializer\Serialize;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class ProductData implements ArgumentInterface
{
    /**
     * @var CompositeLabelProvider
     */
    private CompositeLabelProvider $labelProvider;

    /**
     * @var Json
     */
    private Json $json;

    /**
     * @var ConfigInterface
     */
    private ConfigInterface $config;

    /**
     * Constructor.
     *
     * @param CompositeLabelProvider $labelProvider
     * @param ConfigInterface        $config
     * @param Json                   $json
     */
    public function __construct(
        CompositeLabelProvider $labelProvider,
        ConfigInterface $config,
        Json $json
    ) {
        $this->labelProvider = $labelProvider;
        $this->config        = $config;
        $this->json          = $json;
    }

    /**
     * @param ProductInterface $product
     *
     * @return string
     */
    public function getProductLabels(ProductInterface $product): string
    {
        $data = [];
        try {
            $data['labels'] = $this->labelProvider->get($product);
            $data           = array_merge($data, []);

            return $this->json->serialize($data);
        } catch (\InvalidArgumentException $exception) {
            return $this->json->serialize([]);
        }
    }
}
