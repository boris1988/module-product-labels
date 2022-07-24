<?php

declare(strict_types=1);

namespace BPerevyazko\ProductLabel\Model\Providers;

use BPerevyazko\ProductLabel\Api\LabelProviderInterface;
use BPerevyazko\ProductLabel\Model\ConfigInterface;
use Magento\Catalog\Api\Data\ProductInterface;

class DiscountProvider implements LabelProviderInterface
{
    /**
     * @var ConfigInterface
     */
    private ConfigInterface $config;

    /**
     * Constructor.
     *
     * @param ConfigInterface $config
     */
    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
    }

    /**
     * @param ProductInterface $product
     *
     * @return array
     */
    public function get(ProductInterface $product): array
    {
        $specialPrice = (float)$product->getData('special_price');
        if ($specialPrice === 0.0) {
            return [];
        }

        $price      = (float)$product->getData('price');
        $percentage = ($specialPrice * 100) / $price;
        $discount   = (string)(100 - round($percentage));
        $mask       = $this->config->getDiscountMask();

        return [str_replace('{D}', $discount, $mask)];
    }
}
