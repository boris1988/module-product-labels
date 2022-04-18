<?php

/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

declare(strict_types=1);

namespace BPerevyazko\ProductLabel\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config implements ConfigInterface
{
    private const XML_PATH_CATALOG_PRODUCTLABEL_DISCOUNT = "catalog/productLabel/discount";

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
            self::XML_PATH_CATALOG_PRODUCTLABEL_DISCOUNT,
            ScopeInterface::SCOPE_STORE
        );
    }
}
