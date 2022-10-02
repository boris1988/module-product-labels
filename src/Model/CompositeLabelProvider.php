<?php

declare(strict_types=1);

namespace BPerevyazko\ProductLabel\Model;

use BPerevyazko\ProductLabel\Api\LabelProviderInterface;
use BPerevyazko\ProductLabel\Model\Providers\AbstractProvider;
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
        /** @var AbstractProvider $labelProvider */
        foreach ($this->labelProviders as $labelProvider) {
            $position                    = $labelProvider->getPosition();
            $labels[$position]           = $labels[$position] ?? [];
            $labels[$position]['labels'] = $labels[$position]['labels'] ?? [];
            $labels[$position]['labels'] = array_merge_recursive(
                $labels[$position]['labels'],
                $labelProvider->get($product)
            );
        }

        return $labels;
    }
}
