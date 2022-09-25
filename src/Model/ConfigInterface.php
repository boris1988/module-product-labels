<?php

declare(strict_types=1);

namespace BPerevyazko\ProductLabel\Model;

interface ConfigInterface
{
    /**
     * @return bool|null
     */
    public function isDiscountLabelEnabled(): ?bool;

    /**
     * @return string|null
     */
    public function getDiscountMask(): ?string;

    /**
     * @return string|null
     */
    public function getDiscountLabelPosition(): ?string;

    /**
     * @return string|null
     */
    public function getDiscountBackgroundColor(): ?string;

    /**
     * @return bool|null
     */
    public function isAttributeLabelEnabled(): ?bool;

    /**
     * @return string|null
     */
    public function getAttributeLabelPosition(): ?string;

    /**
     * @return string|null
     */
    public function getAttributeBackgroundColor(): ?string;

    /**
     * @return array|null
     */
    public function getAttributeCodes(): ?array;
}
