<?php

declare(strict_types=1);

namespace BPerevyazko\ProductLabel\Model;

interface CssPositionInterface
{
    public const CSS_POSITION_MAPPING = [
        'top_left' => "top:0; left:0;",
        'top_right' => "top:0; right:0;",
        'bottom_left' => "bottom:0; left:0;",
        'bottom_right' => "bottom:0; right:0;",
    ];
}
