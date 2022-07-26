define([
    'jquery',
    'underscore',
    'mage/template'
], function ($, _, mageTemplate) {
    'use strict';

    return {
        defaults: {
            template: '<div class="product-promotion">\n' +
                '        <div class="promotion-label">\n' +
                '            <span style="background-color: <%= background_color %>"><%= label %></span>\n' +
                '        </div>\n' +
                '    </div>',
            renderer: null,
            position: '',
            background_color: '',
            mediaContainerClass: '.product.media',
            productLabelContainer: 'product-labels'
        },

        init: function (position, background_color) {
            this.defaults.position = position;
            this.defaults.renderer = mageTemplate(this.defaults.template);
            this.defaults.background_color = background_color;
        },

        /**
         * @param object
         * @param labels
         */
        render: function (labels) {
            var that = this,
            labelContainerSelector = this.defaults.mediaContainerClass+'>.' + this.defaults.productLabelContainer;

            $(this.defaults.mediaContainerClass)
                .prepend("<div class='" + this.defaults.productLabelContainer + "'></div>");

            _.each(labels, function (label) {
                $(labelContainerSelector).attr('style', that.position).append(that.defaults.renderer({
                    label: label,
                    background_color: that.defaults.background_color
                })).bind(this);
            });
        },

        /**
         * @private
         */
        _resetLabels: function () {
            $(this.defaults.mediaContainerClass+'>.' + this.defaults.productLabelContainer).remove();
        }
    };
});
