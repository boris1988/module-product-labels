<?php

declare(strict_types=1);

namespace BPerevyazko\ProductLabel\Block\Adminhtml\Form\Field;

use Magento\Catalog\Model\ResourceModel\Product\Attribute\Collection;
use Magento\Framework\View\Element\Context;
use Magento\Framework\View\Element\Html\Select;

class AttributeRenderer extends Select
{
    /**
     * @var string[]
     */
    private $ninAttributeCodes = [
        'sku',
        'description',
        'short_description',
        'meta_title',
        'meta_keyword',
        'meta_description',
        'image',
        'small_image',
        'thumbnail',
        'media_gallery',
        'gallery',
        'visibility',
        'custom_design',
        'custom_design_from',
        'custom_design_to',
        'page_layout',
        'category_ids',
        'image_label',
        'small_image_label',
        'thumbnail_label',
        'created_at',
        'updated_at',
        'custom_layout',
        'url_key',
        'url_path',
        'lifetime',
        'email_template',
        'allow_message',
        'swatch_image',
    ];

    /**
     * @var Collection
     */
    private Collection $collection;

    /**
     * Constructor.
     *
     * @param Collection $collection
     * @param Context    $context
     * @param array      $data
     */
    public function __construct(
        Collection $collection,
        Context $context,
        array $data = []
    ) {
        $this->collection = $collection;
        parent::__construct($context, $data);
    }

    /**
     * @return string
     */
    public function _toHtml(): string
    {
        if (!$this->getOptions()) {
            $this->collection
                ->addFieldToFilter('used_in_product_listing', ['eq' => 1])
                ->addFieldToFilter('backend_type', ['in' => ['varchar', 'text', 'static', 'int']])
                ->addFieldToFilter('attribute_code', ['nin' => $this->ninAttributeCodes])
                ->addFieldToFilter('is_visible', ['eq' => 1]);

            $this->addOption('', '');
            foreach ($this->collection->getItems() as $attribute) {
                $this->addOption(
                    $attribute->getAttributeCode(),
                    $attribute->getDefaultFrontendLabel()
                );
            }
        }

        return parent::_toHtml();
    }

    /**
     * Sets name for input element.
     *
     * @param string $value
     *
     * @return AttributeRenderer
     */
    public function setInputName(string $value): AttributeRenderer
    {
        return $this->setData('name', $value);
    }
}
