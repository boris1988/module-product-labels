<?php

/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

declare(strict_types=1);

namespace BPerevyazko\ProductLabel\Model\Providers;

use BPerevyazko\ProductLabel\Api\LabelProviderInterface;
use Magento\Catalog\Api\Data\ProductInterface;

class DiscountProvider implements LabelProviderInterface
{

    public function get(ProductInterface $product): array
    {
        $specialPrice = (float)$product->getData('special_price');
        if ($product->isSalable() === false || $specialPrice === 0) {
            return [];
        }

        $price      = (float)$product->getData('price');
        $percentage = ($specialPrice * 100) / $price;
        $discount   = (int)(100 - $percentage);

        return ["$discount %"];
    }
}
