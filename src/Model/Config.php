<?php

declare(strict_types=1);

namespace BPerevyazko\ProductLabel\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config implements ConfigInterface
{
    private const XML_PATH_CATALOG_PRODUCT_LABEL_DISCOUNT_ENABLED = "catalog/product_label/discount_enabled";
    private const XML_PATH_CATALOG_PRODUCT_LABEL_DISCOUNT_MASK    = "catalog/product_label/discount_mask";
    private const XML_PATH_CATALOG_PRODUCT_LABEL_PDP_POSITION     = "catalog/product_label/pdp_position";

    /**
     * @var ScopeConfigInterface
     */
    private $config;

    /**
     * Constructor.
     *
     * @param ScopeConfigInterface $config
     */
    public function __construct(ScopeConfigInterface $config)
    {
        $this->config = $config;
    }

    /**
     * @return bool|null
     */
    public function isDiscountLabelEnabled(): ?bool
    {
        return $this->config->isSetFlag(
            self::XML_PATH_CATALOG_PRODUCT_LABEL_DISCOUNT_ENABLED,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return string|null
     */
    public function getDiscountMask(): ?string
    {
        return $this->config->getValue(
            self::XML_PATH_CATALOG_PRODUCT_LABEL_DISCOUNT_MASK,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return string|null
     */
    public function getPdpPosition(): ?string
    {
        return $this->config->getValue(
            self::XML_PATH_CATALOG_PRODUCT_LABEL_PDP_POSITION,
            ScopeInterface::SCOPE_STORE
        );
    }
}
