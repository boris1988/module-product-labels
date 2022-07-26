define([
    'jquery',
    'underscore',
    'BPerevyazko_ProductLabel/js/view/renderer'
], function ($, _, renderer) {
    'use strict';

    return function (widget) {
        $.widget('mage.configurable', widget, {
            options: {
                mediaContainerClass: '.product.media',
                productLabelContainer: 'product-labels'
            },
            _create: function () {
                this._super();
                renderer.init(
                    this.options.spConfig.label_config.position,
                    this.options.spConfig.label_config.background_color
                );
            },

            _reloadPrice: function () {
                this._super();
                var $widget = this,
                    labels = $widget.options.spConfig.label_config.labels;

                renderer._resetLabels();
                if (!_.isUndefined(labels[$widget.simpleProduct])) {
                    renderer.render(labels[$widget.simpleProduct]);
                }
            },

            _resetLabels: function (labels) {
                labels.remove();
            }
        });

        return $.mage.configurable;
    }
});
