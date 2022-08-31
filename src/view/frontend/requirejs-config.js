var config = {
    map: {
        '*': {
            'productLabel': 'BPerevyazko_ProductLabel/js/view/product_label',
            'listProductLabel': 'BPerevyazko_ProductLabel/js/list/product_label',
        }
    },
    config: {
        mixins: {
            'Magento_Swatches/js/swatch-renderer': {
                'BPerevyazko_ProductLabel/js/view/configurable/swatch-renderer-mixin': true
            },
            'Magento_ConfigurableProduct/js/configurable': {
                'BPerevyazko_ProductLabel/js/view/configurable/configurable-mixin': true
            },
            'Magento_Bundle/js/product-summary': {
                'BPerevyazko_ProductLabel/js/view/bundle/product-summary-mixin': true
            }
        }
    }
};
