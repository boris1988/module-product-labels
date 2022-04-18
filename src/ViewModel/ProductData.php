<?php

/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

declare(strict_types=1);

namespace BPerevyazko\ProductLabel\ViewModel;

use BPerevyazko\ProductLabel\Model\CompositeLabelProvider;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class ProductData implements ArgumentInterface
{
    private CompositeLabelProvider $labelProvider;

    public function __construct(CompositeLabelProvider $labelProvider)
    {
        $this->labelProvider = $labelProvider;
    }
    public function getProductLabels(ProductInterface $product): ?string
    {
        return $this->labelProvider->get($product);
    }
}
