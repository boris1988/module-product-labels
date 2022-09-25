<?php

/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

declare(strict_types=1);

namespace BPerevyazko\ProductLabel\Model\Providers;

use BPerevyazko\ProductLabel\Api\LabelProviderInterface;
use BPerevyazko\ProductLabel\Model\ConfigInterface;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Eav\Model\Entity\Attribute\AbstractAttribute;

class AttributeProvider implements LabelProviderInterface
{
    private $attributes;

    /**
     * @var ConfigInterface
     */
    private ConfigInterface $config;

    private \Magento\Catalog\Model\ResourceModel\ProductFactory $productResourceFactory;

    /**
     * Constructor.
     *
     * @param ConfigInterface $config
     */
    public function __construct(
        ConfigInterface $config,
        \Magento\Catalog\Model\ResourceModel\ProductFactory $productResourceFactory
    ) {
        $this->config                 = $config;
        $this->productResourceFactory = $productResourceFactory;
    }

    /**
     * @param ProductInterface $product
     *
     * @return array
     */
    public function get(ProductInterface $product): array
    {
        if ($this->config->isAttributeLabelEnabled() === false) {
            return [];
        }

        $labels         = [];
        $attributeCodes = $this->config->getAttributeCodes();
        foreach ($attributeCodes as $attributeCode) {
            $attribute = $this->getAttribute($attributeCode['attribute_code']);
            if ($attribute === false) {
                continue;
            }

            if ($attribute->usesSource()) {
                $value = $attribute->getSource()->getOptionText($product->getData($attributeCode['attribute_code']));
            } else {
                $value = $product->getData($attributeCode['attribute_code']);
            }

            if ($value === null || $value === false) {
                continue;
            }

            $labels[] = $value;
        }

        return $labels;
    }

    /**
     * @param string $attributeCode
     *
     * @return null|AbstractAttribute
     */
    private function getAttribute(string $attributeCode): ?AbstractAttribute
    {
        $productResource = $this->productResourceFactory->create();
        if (isset($this->attributes[$attributeCode])) {
            return $this->attributes[$attributeCode];
        }

        $this->attributes[$attributeCode] = $productResource->getAttribute($attributeCode);

        return $this->attributes[$attributeCode];
    }
}
