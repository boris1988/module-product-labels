<?php

declare(strict_types=1);

namespace BPerevyazko\ProductLabel\Block\Adminhtml\Form\Field\Product;

use BPerevyazko\ProductLabel\Block\Adminhtml\Form\Field\AttributeRenderer;
use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\LocalizedException;

class Attributes extends AbstractFieldArray
{
    private const NAME = "attribute_code";

    /**
     * @return void
     */
    protected function _prepareToRender()
    {
        $this->addColumn(
            'attribute_code',
            [
                'label' => __('Attribute'),
                'renderer' => $this->getAttributesRenderer()
            ]
        );

        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add');

        parent::_prepareToRender();
    }

    /**
     * @return AttributeRenderer
     *
     * @throws LocalizedException
     */
    private function getAttributesRenderer()
    {
        if (!isset($this->attributeRender)) {
            /**
             * @var AttributeRenderer $renderer
             */
            $renderer = $this->getLayout()->createBlock(
                AttributeRenderer::class,
                self::NAME,
                ['data' => ['is_render_to_js_template' => true]]
            );

            $this->attributeRender = $renderer;
        }

        return $this->attributeRender;
    }

    /**
     * @param DataObject $row
     *
     * @return void
     * @throws LocalizedException
     */
    protected function _prepareArrayRow(DataObject $row): void
    {
        $options = [];

        $attributeCode = $row->getData(self::NAME);
        if ($attributeCode !== null) {
            $options[
                'option_' . $this->getAttributesRenderer()->calcOptionHash($attributeCode)
            ] = 'selected="selected"';
        }

        $row->setData('option_extra_attrs', $options);
    }
}
