<?php

declare(strict_types=1);

namespace BPerevyazko\ProductLabel\Model;

trait LabelParamsProvider
{
    /**
     * @return array
     */
    public function getAdditional(): array
    {
        return [
            'position' => CssPositionInterface::CSS_POSITION_MAPPING[
            $this->config->getPdpPosition()
            ],
            'background_color' => $this->config->getBackgroundColor()
        ];
    }
}
