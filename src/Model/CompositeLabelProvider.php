<?php

/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

declare(strict_types=1);

namespace BPerevyazko\ProductLabel\Model;

use BPerevyazko\ProductLabel\Api\LabelProviderInterface;
use Magento\Catalog\Api\Data\ProductInterface;

class CompositeLabelProvider implements LabelProviderInterface
{
    /**
     * @var LabelProviderInterface[]
     */
    private array $labelProviders;

    /**
     * Constructor.
     *
     * @param LabelProviderInterface[] $labelProviders
     */
    public function __construct(array $labelProviders)
    {
        $this->labelProviders = $labelProviders;
    }

    /**
     * @param ProductInterface $product
     *
     * @return array
     */
    public function get(ProductInterface $product): array
    {
        $labels = [];
        /** @var LabelProviderInterface $labelProvider */
        foreach ($this->labelProviders as $labelProvider) {
            $labels = array_merge_recursive($labels, $labelProvider->get($product));
        }

        return $labels;
    }
}
