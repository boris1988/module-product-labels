var config = {
    map: {
        '*': {
            'productLabel': 'BPerevyazko_ProductLabel/js/view/product_label',
        }
    },
    config: {
        mixins: {
            'Magento_Swatches/js/swatch-renderer': {
                'BPerevyazko_ProductLabel/js/view/swatch-renderer-mixin': true
            },
            'Magento_Bundle/js/product-summary': {
                'BPerevyazko_ProductLabel/js/view/bundle/product-summary-mixin': true
            }
        }
    }
};
