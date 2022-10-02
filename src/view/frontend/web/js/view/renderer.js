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

        /**
         *
         * @param {String} position
         * @param {Array} additionalData
         */
        init: function (position ,additionalData = []) {
            var that = this;

            this.defaults.position = position;
            this.defaults.renderer = mageTemplate(this.defaults.template);
            if (additionalData.length) {
                _.each(additionalData, function (property, key) {
                    that.defaults[key] = property;
                });
            }
        },

        /**
         * @param object
         * @param labels
         */
        render: function (labels, selector = null) {
            var that = this,
                labelContainerSelector = null;

            if (selector) {
                this.defaults.mediaContainerClass = selector;
            }
            labelContainerSelector = this.defaults.mediaContainerClass+'>.' + this.defaults.productLabelContainer;

            var obj = $('<div class="' + this.defaults.productLabelContainer + '"></div>')
                .attr('style', that.defaults.position)
                .prependTo(this.defaults.mediaContainerClass)

            _.each(labels, function (label) {
                obj.append(that.defaults.renderer({
                    label: label.label,
                    background_color: label.background_color
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
