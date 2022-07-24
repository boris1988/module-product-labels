define([
    'jquery',
    'underscore',
    'mage/template',
    'BPerevyazko_ProductLabel/js/view/renderer'
], function ($, _, mageTemplate, renderer) {
    'use strict';

    return function (widget) {
        $.widget('mage.productSummary', widget, {
            template: '\n<div><%- data._quantity_ %> x <%- data._produceLabel_ %>'
                    + '<% if (typeof(data._labels_) != "boolean") { %>'
                    + '<div class="product-labels"><%= data._labels_ %></div>'
                    + '<% } %></div>',
            label_template: '<div class="promotion-label">\n' +
                '            <span style="background-color: <%= data.background_color %>"><%= data.label %></span>\n' +
                '        </div>\n',

            /**
             * @param {String} key
             * @param {String} optionIndex
             * @private
             */
            _renderOptionRow: function (key, optionIndex) {
                var template,
                    that = this,
                    _labels_ = "";

                if (!_.isUndefined(this.cache.currentElement.label_config.labels[optionIndex])) {
                    _.each(this.cache.currentElement.label_config.labels[optionIndex], function (label) {
                        _labels_ = mageTemplate($.trim(that.label_template), {
                            data: {
                                label: label,
                                background_color: that.cache.currentElement.label_config.background_color
                            }
                        });
                    });
                }

                if (_labels_ == "") {
                    _labels_ = false;
                } else {
                    _labels_ = '<div class="product-promotion">'+_labels_+'</div>';
                }

                template = mageTemplate($.trim(this.template), {
                    data: {
                        _quantity_: this.cache.currentElement.options[this.cache.currentKey].selections[optionIndex].qty,
                        _produceLabel_: this.cache.currentElement.options[this.cache.currentKey].selections[optionIndex].name,
                        _labels_: _labels_
                    }
                });
                this.cache.summaryContainer
                    .find(this.options.optionSelector)
                    .append(template);
            }
        });

        return $.mage.productSummary;
    }
});
