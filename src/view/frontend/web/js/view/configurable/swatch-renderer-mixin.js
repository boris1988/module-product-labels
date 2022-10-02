define([
    'jquery',
    'underscore',
    'BPerevyazko_ProductLabel/js/view/renderer'
], function ($, _, renderer) {
    'use strict';

    return function (widget) {
        $.widget('mage.SwatchRenderer', widget, {
            options: {
                pdpBodyClass: 'catalog-product-view'
            },
            _init: function () {
                this._super();
            },

            _UpdatePrice: function () {
                this._super();
                var $widget = this,
                    labels = this.options.jsonConfig.label_config.labels,
                    selector = '.product.media',
                    allowedProduct = this._getAllowedProductWithMinPrice(this._CalcProducts());

                if (!$('body').hasClass(this.options.pdpBodyClass)) {
                    selector = '.product-image-container-' + this.options.jsonConfig.productId;
                }
                renderer._resetLabels();
                if (!_.isUndefined(labels[allowedProduct])) {
                    _.each(labels[allowedProduct], function (label, position) {
                        renderer.init(position);
                        renderer.render(label.labels, selector);
                    });
                }
            },

            _resetLabels: function (labels) {
                labels.remove();
            }
        });

        return $.mage.SwatchRenderer;
    }
});
