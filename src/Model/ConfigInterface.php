<?php

/**
 * Copyright MediaCT. All rights reserved.
 * https://www.mediact.nl
 */

declare(strict_types=1);

namespace BPerevyazko\ProductLabel\Model;

interface ConfigInterface
{
    public function isDiscountLabelEnabled(): ?bool;
}
