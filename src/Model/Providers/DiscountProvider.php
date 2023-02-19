<?php

declare(strict_types=1);

namespace BPerevyazko\ProductLabel\Model\Providers;

use BPerevyazko\ProductLabel\Model\CssPositionInterface;
use Magento\Catalog\Api\Data\ProductInterface;

class DiscountProvider extends AbstractProvider
{
    /**
     * @param ProductInterface $product
     *
     * @return array
     */
    public function get(ProductInterface $product): array
    {
        if ($this->config->isDiscountLabelEnabled() === false) {
            return [];
        }
        $specialPrice = (float)$product->getData('special_price');
        if ($specialPrice === 0.0) {
            return [];
        }

        $price      = (float)$product->getData('price');
        if ($price === $specialPrice || $specialPrice > $price) {
            return [];
        }
        $percentage = ($specialPrice * 100) / $price;
        $discount   = (string)(100 - round($percentage));
        $mask       = $this->config->getDiscountMask();
        $labels[]   = [
            'label' => str_replace('{D}', $discount, $mask),
            'background_color' => $this->config->getDiscountBackgroundColor()
        ];

        return $labels;
    }

    /**
     * @return string
     */
    public function getPosition(): string
    {
          return CssPositionInterface::CSS_POSITION_MAPPING[
                $this->config->getDiscountLabelPosition()
            ];
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->config->isDiscountLabelEnabled();
    }
}
