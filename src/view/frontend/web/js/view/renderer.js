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
                '            <span><%= label %></span>\n' +
                '        </div>\n' +
                '    </div>',
            renderer: null,
            position: '',
            mediaContainerClass: '.product.media',
        },

        init: function (position) {
            this.defaults.position = position;
            this.defaults.renderer = mageTemplate(this.defaults.template);
        },

        /**
         * Render Labels
         *
         * @param {Boolean} [forceStop]
         */
        render: function (object, labels, position) {
            var that = this;

            _.each(labels, function (label) {
                object.attr('style', that.position).append(that.defaults.renderer({
                    'label': label
                })).bind(this);
            });
        }
    };
});
