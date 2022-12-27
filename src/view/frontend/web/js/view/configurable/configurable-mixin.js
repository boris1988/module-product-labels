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
            },

            _reloadPrice: function () {
                this._super();
                var $widget = this,
                    labels = $widget.options.spConfig.label_config.labels;

                if (!_.isUndefined(labels[$widget.simpleProduct])) {
                    _.each(labels[$widget.simpleProduct], function (label, position) {
                        renderer.init(position);
                        renderer.render(label.labels);
                    });
                }
            }
        });

        return $.mage.configurable;
    }
});
