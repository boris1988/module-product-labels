<?php

declare(strict_types=1);

namespace BPerevyazko\ProductLabel\Model\Providers;

use BPerevyazko\ProductLabel\Model\CssPositionInterface;
use BPerevyazko\ProductLabel\Model\ConfigInterface;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\SpecialPriceInterface;

class DiscountProvider extends AbstractProvider
{

    private $specialPrice;

    private $resolver;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\TimezoneInterface
     */
    private $timezone;

    /**
     * @param ConfigInterface                                      $config
     * @param \Magento\Framework\Locale\ResolverInterface          $resolver
     * @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone
     * @param string                                               $type
     */
    public function __construct(
        ConfigInterface                                      $config,
        \Magento\Framework\Locale\ResolverInterface          $resolver,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezone,
        string                                               $type
    ) {
        $this->resolver = $resolver;
        $this->timezone = $timezone;
        parent::__construct($config, $type);
    }

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

        $price = (float)$product->getData('price');
        if ($price === $specialPrice || $specialPrice > $price) {
            return [];
        }

        $currentDate = $this->timezone->date();
        if ($product->getSpecialFromDate()
            && $this->timezone->date($product->getSpecialFromDate()) > $currentDate
        ) {
            return [];
        }

        if ($product->getSpecialToDate()
            && $this->timezone->date($product->getSpecialToDate()) < $currentDate
        ) {
            return [];
        }

        $percentage = ($specialPrice * 100) / $price;
        $discount = (string)(100 - round($percentage));
        $mask = $this->config->getDiscountMask();
        $labels[] = [
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
        return CssPositionInterface::CSS_POSITION_MAPPING[$this->config->getDiscountLabelPosition()];
    }
}
