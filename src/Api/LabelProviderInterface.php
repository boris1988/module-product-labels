<?php

declare(strict_types=1);

namespace BPerevyazko\ProductLabel\Api;

use Magento\Catalog\Api\Data\ProductInterface;

interface LabelProviderInterface
{
    /**
     * @param ProductInterface $product
     *
     * @return array
     */
    public function get(ProductInterface $product): array;

}
