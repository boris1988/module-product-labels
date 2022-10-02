<?php

declare(strict_types=1);

namespace BPerevyazko\ProductLabel\Model\Providers;

use BPerevyazko\ProductLabel\Api\LabelProviderInterface;
use BPerevyazko\ProductLabel\Model\ConfigInterface;
use Magento\Catalog\Api\Data\ProductInterface;

abstract class AbstractProvider implements LabelProviderInterface
{
    /**
     * @var ConfigInterface
     */
    protected ConfigInterface $config;

    /**
     * @var string
     */
    private string $type;

    /**
     * Constructor.
     *
     * @param ConfigInterface $config
     * @param string          $type
     */
    public function __construct(
        ConfigInterface $config,
        string $type
    ) {
        $this->config = $config;
        $this->type   = $type;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getPosition(): string
    {
        return '';
    }

    /**
     * @param ProductInterface $product
     *
     * @return array
     */
    public function get(ProductInterface $product): array
    {
        return [];
    }
}
