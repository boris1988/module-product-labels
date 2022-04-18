/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

define([
    'uiComponent',
    'jquery',
    'mage/mage'
], function (Component, $) {
    'use strict';

    var sidebarInitialized = false;


    return Component.extend({
        /** @inheritdoc */
        initialize: function (config, element) {
            this._super();
            this.element = element;
        }
    });
});
