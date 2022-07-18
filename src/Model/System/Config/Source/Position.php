<?php

declare(strict_types=1);

namespace BPerevyazko\ProductLabel\Model\System\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Position implements OptionSourceInterface
{
    /**
     * @return array[]
     */
    public function toOptionArray(): array
    {
        return [
            ['label' => __('Top Left'), 'value' => 'top_left'],
            ['label' => __('Top Right'), 'value' => 'top_right'],
            ['label' => __('Bottom Left'), 'value' => 'bottom_left'],
            ['label' => __('Bottom Right'), 'value' => 'bottom_right']
        ];
    }
}
