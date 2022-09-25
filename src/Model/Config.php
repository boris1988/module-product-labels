<?php

declare(strict_types=1);

namespace BPerevyazko\ProductLabel\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Store\Model\ScopeInterface;

class Config implements ConfigInterface
{
    private const XML_PATH_PRODUCT_LABEL_GENERAL_DISCOUNT_ENABLED   = "product_label/general/discount_enabled";
    private const XML_PATH_PRODUCT_LABEL_GENERAL_DISCOUNT_MASK      = "product_label/general/discount_mask";
    private const XML_PATH_PRODUCT_LABEL_GENERAL_POSITION           = "product_label/general/position";
    private const XML_PATH_PRODUCT_LABEL_GENERAL_BACKGROUND_COLOR   = "product_label/general/background_color";
    private const XML_PATH_PRODUCT_LABEL_ATTRIBUTE_ENABLED          = "product_label/product_attributes_label/enabled";
    private const XML_PATH_PRODUCT_LABEL_ATTRIBUTE_POSITION         = "product_label/product_attributes_label/position";
    private const XML_PATH_PRODUCT_LABEL_ATTRIBUTE_BACKGROUND_COLOR = "product_label/product_attributes_label/background_color";
    private const XML_PATH_PRODUCT_LABEL_ATTRIBUTE_ATTRIBUTE_CODES  = "product_label/product_attributes_label/product_attributes";

    /**
     * @var ScopeConfigInterface
     */
    private $config;

    private Json $serialize;

    /**
     * Constructor.
     *
     * @param ScopeConfigInterface $config
     */
    public function __construct(
        ScopeConfigInterface $config,
        Json $serialize
    ) {
        $this->config    = $config;
        $this->serialize = $serialize;
    }

    /**
     * @return bool|null
     */
    public function isDiscountLabelEnabled(): ?bool
    {
        return $this->config->isSetFlag(
            self::XML_PATH_PRODUCT_LABEL_GENERAL_DISCOUNT_ENABLED,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return string|null
     */
    public function getDiscountMask(): ?string
    {
        return $this->config->getValue(
            self::XML_PATH_PRODUCT_LABEL_GENERAL_DISCOUNT_MASK,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return string|null
     */
    public function getDiscountLabelPosition(): ?string
    {
        return $this->config->getValue(
            self::XML_PATH_PRODUCT_LABEL_GENERAL_POSITION,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return string|null
     */
    public function getDiscountBackgroundColor(): ?string
    {
        return $this->config->getValue(
            self::XML_PATH_PRODUCT_LABEL_GENERAL_BACKGROUND_COLOR,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return bool|null
     */
    public function isAttributeLabelEnabled(): ?bool
    {
        return $this->config->isSetFlag(
            self::XML_PATH_PRODUCT_LABEL_ATTRIBUTE_ENABLED,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return string|null
     */
    public function getAttributeLabelPosition(): ?string
    {
        return $this->config->getValue(
            self::XML_PATH_PRODUCT_LABEL_ATTRIBUTE_POSITION,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return string|null
     */
    public function getAttributeBackgroundColor(): ?string
    {
        return $this->config->getValue(
            self::XML_PATH_PRODUCT_LABEL_ATTRIBUTE_BACKGROUND_COLOR,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return array|null
     */
    public function getAttributeCodes(): ?array
    {
        $attributes = $this->config->getValue(
            self::XML_PATH_PRODUCT_LABEL_ATTRIBUTE_ATTRIBUTE_CODES,
            ScopeInterface::SCOPE_STORE
        );
        if ($attributes === null) {
            return null;
        }

        return $this->serialize->unserialize($attributes);
    }
}
