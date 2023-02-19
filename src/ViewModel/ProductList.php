<?php

declare(strict_types=1);

namespace BPerevyazko\ProductLabel\ViewModel;

use BPerevyazko\ProductLabel\Model\ConfigInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\Serialize\Serializer\Json as JsonSerializer;

class ProductList implements ArgumentInterface
{
    /**
     * @var JsonSerializer
     */
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
        $data = array_merge(['selector' => '.product-item-info'], []);

        return $this->json->serialize($data);
    }
}
