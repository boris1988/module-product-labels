define([
    'uiClass',
    'jquery',
    'underscore',
    'BPerevyazko_ProductLabel/js/view/renderer'
], function (Component, $, _, renderer) {
    'use strict';

    return Component.extend({
        labels: [],

        /** @inheritdoc */
        initialize: function (config, element) {
            this.element = element;
            this._super(config);

            this.build();
        },

        build: function () {
            var that = this;

            _.each(that.labels, function (label, position) {
                if (label.labels.length == 0) {
                    return;
                }
                renderer.init(position);
                renderer.render(label.labels);
            });
        }
    });
});
