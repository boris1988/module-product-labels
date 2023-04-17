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
     * @var ConfigInterface
     */
    private ConfigInterface $config;

    /**
     * @param JsonSerializer $json
     * @param ConfigInterface $config
     */
    public function __construct(JsonSerializer $json, ConfigInterface $config)
    {
        $this->json   = $json;
        $this->config = $config;
    }

    /**
     * Get config
     *
     * @return string
     */
    public function getConfig(): string
    {
        $data = array_merge(['selector' => '.product-item-info'], []);

        return $this->json->serialize($data);
    }
}
