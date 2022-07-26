define([
    'jquery',
    'underscore',
    'BPerevyazko_ProductLabel/js/view/renderer'
], function ($, _, renderer) {
    'use strict';

    return function (widget) {
        $.widget('mage.SwatchRenderer', widget, {
            options: {
                mediaContainerClass: '.product.media',
                productLabelContainer: 'product-labels'
            },
            _init: function () {
                this._super();
                renderer.init(
                    this.options.jsonConfig.label_config.position,
                    this.options.jsonConfig.label_config.background_color
                );
            },

            _UpdatePrice: function () {
                this._super();
                var $widget = this,
                    labels = $widget.options.jsonConfig.label_config.labels,
                    allowedProduct = this._getAllowedProductWithMinPrice(this._CalcProducts());

                renderer._resetLabels();
                if (!_.isUndefined(labels[allowedProduct])) {
                    renderer.render(labels[allowedProduct]);
                }
            },

            _resetLabels: function (labels) {
                labels.remove();
            }
        });

        return $.mage.SwatchRenderer;
    }
});
