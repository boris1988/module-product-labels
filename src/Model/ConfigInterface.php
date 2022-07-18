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
    public function getPdpPosition(): ?string;
}
