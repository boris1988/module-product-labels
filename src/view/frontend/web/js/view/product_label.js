define([
    'uiClass',
    'jquery',
    'underscore',
    'mage/template'
], function (Component, $, _, mageTemplate) {
    'use strict';

    return Component.extend({
        defaults: {
            template: '<div class="product-promotion">\n' +
                '        <div class="promotion-label">\n' +
                '            <span><%= label %></span>\n' +
                '        </div>\n' +
                '    </div>',
            visible: true,
        },
        renderer: null,
        labels: [],

        /** @inheritdoc */
        initialize: function (config, element) {

            this.element = element;
            this._super(config);
            this.renderer = mageTemplate(this.template),

            this.build();
        },

        build: function () {
            var that = this;

            _.each(that.labels, function (label) {
                $(that.element).attr('style', that.position).append(that.renderer({
                    'label': label
                })).bind(this);
            });
        }
    });
});
