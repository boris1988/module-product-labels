<?php

declare(strict_types=1);

namespace BPerevyazko\ProductLabel\Plugin\ConfigurableProduct\Block\Product\View\Type;

use BPerevyazko\ProductLabel\Model\CompositeLabelProvider;
use BPerevyazko\ProductLabel\Model\ConfigInterface;
use BPerevyazko\ProductLabel\Model\CssPositionInterface;
use Magento\ConfigurableProduct\Block\Product\View\Type\Configurable;
use Magento\Framework\Serialize\Serializer\Json;

class ConfigurablePlugin
{
    private ConfigInterface $config;

    private Json $json;

    private CompositeLabelProvider $labelProvider;

    public function __construct(
        ConfigInterface $config,
        Json $json,
        CompositeLabelProvider $labelProvider
    ) {
        $this->config        = $config;
        $this->json          = $json;
        $this->labelProvider = $labelProvider;
    }

    public function afterGetJsonConfig(Configurable $subject, string $result): string
    {
        if ($this->config->isDiscountLabelEnabled() === false) {
            return $result;
        }

        $result = $this->json->unserialize($result);
        $data   = [];
        foreach ($subject->getAllowProducts() as $product) {
            $labels = $this->labelProvider->get($product);
            if (!empty($labels)) {
                $data['labels'][$product->getId()] = $labels;
            }
        }

        $data['position']       = CssPositionInterface::CSS_POSITION_MAPPING[
            $this->config->getPdpPosition()
        ];
        $result['label_config'] = $data;

        return $this->json->serialize($result);
    }
}
