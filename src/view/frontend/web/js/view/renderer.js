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
        },

        init: function (position, background_color) {
            this.defaults.position = position;
            this.defaults.renderer = mageTemplate(this.defaults.template);
            this.defaults.background_color = background_color;
        },

        /**
         * @param object
         * @param labels
         * @param position
         * @param background_color
         */
        render: function (object, labels, position, background_color) {
            var that = this;

            _.each(labels, function (label) {
                object.attr('style', that.position).append(that.defaults.renderer({
                    label: label,
                    background_color: that.defaults.background_color
                })).bind(this);
            });
        }
    };
});
