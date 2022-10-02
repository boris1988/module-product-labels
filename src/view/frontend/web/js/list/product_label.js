define([
    'uiClass',
    'jquery',
    'underscore',
    'BPerevyazko_ProductLabel/js/list/action/get_labels',
    'BPerevyazko_ProductLabel/js/view/renderer',
    'domReady!'
], function (Component, $, _, get_labels, renderer) {
    'use strict';

    return Component.extend({
        defaults: {
            labels: [],
            selector: ''
        },
        products: [],

        /** @inheritdoc */
        initialize: function (config) {
            this._super(config);

            this.init();
            this.getLabels();
        },

        init: function () {
            var that = this;

            renderer.init(
                this.position,
                this.background_color
            );

            _.each($(that.selector), function (elm) {
                var priceElm = $(elm).find('div[data-role="priceBox"]');
                if (priceElm.length && priceElm.data('product-id')) {
                    that.products.push(priceElm.data('product-id'));
                }
            });
        },

        getLabels: function () {
            get_labels.registerLoginCallback(this.render);
            this.labels = get_labels(this.products);
        },

        render: function (response) {
            _.each(response.labels, function (labels, productId) {
                var selector = '.product-image-container-' + productId,
                elm = $(selector);
                if (!elm.length) {
                    return false;
                }
                _.each(labels, function (label, position) {
                    renderer.init(position);
                    renderer.render(label.labels, selector);
                });
            });
        }
    });
});
