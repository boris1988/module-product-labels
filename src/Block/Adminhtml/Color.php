<?php

declare(strict_types=1);

namespace BPerevyazko\ProductLabel\Block\Adminhtml;

use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\View\Helper\SecureHtmlRenderer;

class Color extends Field
{
    /**
     * @param Context                 $context
     * @param array                   $data
     * @param SecureHtmlRenderer|null $secureRenderer
     */
    public function __construct(
        Context $context,
        array $data = [],
        ?SecureHtmlRenderer $secureRenderer = null
    ) {
        parent::__construct($context, $data);
    }
    /**
     * @param AbstractElement $element
     *
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element): string
    {
        $html  = $element->getElementHtml();
        $value = $element->getData('value');

        $html .= '<script type="text/javascript">
                require(["jquery","jquery/colorpicker/js/colorpicker"], function ($) {
                    $(document).ready(function () {
                        var $el = $("#' . $element->getHtmlId() . '");
                        $el.css("backgroundColor", "' . $value . '");

                        $el.ColorPicker({
                            color: "' . $value . '",
                            onChange: function (hsb, hex, rgb) {
                                $el.css("backgroundColor", "#" + hex).val("#" + hex);
                            }
                        });
                    });
                });
                </script>';

        return $html;
    }
}
