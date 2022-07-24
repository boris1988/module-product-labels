<?php

declare(strict_types=1);

namespace BPerevyazko\ProductLabel\Plugin\Bundle\Block\Catalog\Product\View\Type;

use BPerevyazko\ProductLabel\Model\LabelParamsProvider;
use BPerevyazko\ProductLabel\Model\CompositeLabelProvider;
use BPerevyazko\ProductLabel\Model\ConfigInterface;
use BPerevyazko\ProductLabel\Model\CssPositionInterface;
use Magento\Bundle\Api\ProductLinkManagementInterface;
use Magento\Bundle\Block\Catalog\Product\View\Type\Bundle;
use Magento\Bundle\Model\Link;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Serialize\Serializer\Json;

class BundlePlugin
{
    use LabelParamsProvider;

    private ConfigInterface $config;

    private Json $json;

    private CompositeLabelProvider $labelProvider;

    private ProductLinkManagementInterface $linkManagement;

    private ProductRepositoryInterface $productRepository;


    public function __construct(
        ConfigInterface $config,
        Json $json,
        ProductLinkManagementInterface $linkManagement,
        ProductRepositoryInterface $productRepository,
        CompositeLabelProvider $labelProvider
    ) {
        $this->config            = $config;
        $this->json              = $json;
        $this->linkManagement    = $linkManagement;
        $this->productRepository = $productRepository;
        $this->labelProvider     = $labelProvider;
    }
    public function afterGetJsonConfig(Bundle $subject, string $result)
    {
        if ($this->config->isDiscountLabelEnabled() === false) {
            return $result;
        }

        $bundleProduct = $subject->getProduct();
        $options       = $this->json->unserialize($result);
        $data          = [];
        try {
            $children = $this->linkManagement->getChildren($bundleProduct->getSku());
            /** @var Link $child */
            foreach ($children as $child) {
                $product = $this->productRepository->get($child->getSku());
                $labels  = $this->labelProvider->get($product);
                if (!empty($labels)) {
                    $data['labels'][$child->getId()] = $labels;
                }
            }

            $options['label_config'] = array_merge($data, $this->getAdditional());

            return $this->json->serialize($options);
        } catch (NoSuchEntityException | InputException $e) {
            return $result;
        }
    }
}
