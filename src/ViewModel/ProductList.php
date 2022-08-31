<?php

/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

declare(strict_types=1);

namespace BPerevyazko\ProductLabel\ViewModel;

use BPerevyazko\ProductLabel\Model\ConfigInterface;
use BPerevyazko\ProductLabel\Model\LabelParamsProvider;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\Serialize\Serializer\Json as JsonSerializer;

class ProductList implements ArgumentInterface
{
    use LabelParamsProvider;

    private JsonSerializer $json;

    /**
     * Constructor.
     *
     * @param JsonSerializer $json
     */
    public function __construct(JsonSerializer $json, ConfigInterface $config)
    {
        $this->json   = $json;
        $this->config = $config;
    }

    /**
     * @return string
     */
    public function getConfig(): string
    {
        $data = array_merge(['selector' => '.product-item-info'], $this->getAdditional());

        return $this->json->serialize($data);
    }
}
