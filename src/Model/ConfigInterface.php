<?php

declare(strict_types=1);

namespace BPerevyazko\ProductLabel\Model;

interface ConfigInterface
{
    public function isDiscountLabelEnabled(): ?bool;
}
