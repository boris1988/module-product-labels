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

    /**
     * @var ConfigInterface
     */
    private ConfigInterface $config;

    /**
     * @var Json
     */
    private Json $json;

    /**
     * @var CompositeLabelProvider
     */
    private CompositeLabelProvider $labelProvider;

    /**
     * @var ProductLinkManagementInterface
     */
    private ProductLinkManagementInterface $linkManagement;

    /**
     * @var ProductRepositoryInterface
     */
    private ProductRepositoryInterface $productRepository;

    /**
     * Constructor
     *
     * @param ConfigInterface                $config
     * @param Json                           $json
     * @param ProductLinkManagementInterface $linkManagement
     * @param ProductRepositoryInterface     $productRepository
     * @param CompositeLabelProvider         $labelProvider
     */
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

    /**
     * @param Bundle $subject
     * @param string $result
     *
     * @return bool|string
     */
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

            $options['label_config'] = $data;

            return $this->json->serialize($options);
        } catch (NoSuchEntityException | InputException $e) {
            return $result;
        }
    }
}
