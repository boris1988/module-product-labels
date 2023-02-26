<?php

declare(strict_types=1);

namespace BPerevyazko\ProductLabel\Model\Providers;

use BPerevyazko\ProductLabel\Model\ConfigInterface;
use BPerevyazko\ProductLabel\Model\CssPositionInterface;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Model\ResourceModel\ProductFactory;
use Magento\Eav\Model\Entity\Attribute\AbstractAttribute;
use Magento\Framework\Exception\LocalizedException;

class AttributeProvider extends AbstractProvider
{
    /**
     * @var array
     */
    private $attributes;

    /**
     * @var ProductFactory
     */
    private ProductFactory $productResourceFactory;

    /**
     * Constructor
     *
     * @param ConfigInterface $config
     * @param ProductFactory  $productResourceFactory
     * @param string          $type
     */
    public function __construct(
        ConfigInterface $config,
        ProductFactory $productResourceFactory,
        string $type
    ) {
        $this->productResourceFactory = $productResourceFactory;
        parent::__construct($config, $type);
    }

    /**
     * @param ProductInterface $product
     *
     * @return array
     * @throws LocalizedException
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

            $labels[] = [
                'label' => $value,
                'background_color' => $this->config->getAttributeBackgroundColor()
            ];
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

    /**
     * @return string
     */
    public function getPosition(): string
    {
        return CssPositionInterface::CSS_POSITION_MAPPING[
                $this->config->getAttributeLabelPosition()
            ];
    }
}
