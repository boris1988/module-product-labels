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
    private const CSS_POSITION_MAPPING = [
        'top_left' => "top:0; left:0;",
        'top_right' => "top:0; right:0;",
        'bottom_left' => "bottom:0; left:0;",
        'bottom_right' => "bottom:0; right:0;",
    ];

    private CompositeLabelProvider $labelProvider;

    private Json $json;

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
            $data['labels']   = $this->labelProvider->get($product);
            $data['position'] = self::CSS_POSITION_MAPPING[$this->config->getPdpPosition()];

            return $this->json->serialize($data);
        } catch (\InvalidArgumentException $exception) {
            return $this->json->serialize([]);
        }
    }
}
