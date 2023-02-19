<?php

declare(strict_types=1);

namespace BPerevyazko\ProductLabel\Plugin\ConfigurableProduct\Block\Product\View\Type;

use BPerevyazko\ProductLabel\Model\CompositeLabelProvider;
use Magento\ConfigurableProduct\Block\Product\View\Type\Configurable;
use Magento\Framework\Serialize\Serializer\Json;

class ConfigurablePlugin
{
    /**
     * @var Json
     */
    private Json $json;

    /**
     * @var CompositeLabelProvider
     */
    private CompositeLabelProvider $labelProvider;

    /**
     * Constructor.
     *
     * @param Json                   $json
     * @param CompositeLabelProvider $labelProvider
     */
    public function __construct(
        Json $json,
        CompositeLabelProvider $labelProvider
    ) {
        $this->json          = $json;
        $this->labelProvider = $labelProvider;
    }

    /**
     * @param Configurable $subject
     * @param string       $result
     *
     * @return string
     */
    public function afterGetJsonConfig(Configurable $subject, string $result): string
    {
        $result = $this->json->unserialize($result);
        $data   = [];
        foreach ($subject->getAllowProducts() as $product) {
            $labels = $this->labelProvider->get($product);
            if (!empty($labels)) {
                $data['labels'][$product->getId()] = $labels;
            }
        }

        $result['label_config'] = $data;

        return $this->json->serialize($result);
    }
}
