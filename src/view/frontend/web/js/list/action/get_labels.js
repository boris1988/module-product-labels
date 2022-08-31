/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

define([
    'jquery',
    'mage/storage',
    'mage/translate'
], function ($, storage, $t) {
    'use strict';

    var callbacks = [],

        /**
         * @param {Array} productIds
         */
        action = function (productIds) {

            return storage.post(
                'productLabel/ajax/getLabels',
                JSON.stringify(productIds),
                true
            ).done(function (response) {
                if (response.errors) {
                    return;
                } else {
                    callbacks.forEach(function (callback) {
                        callback(response);
                    });
                }
            }).fail(function () {
                return;
            });
        };
    /**
     * @param {Function} callback
     */
    action.registerLoginCallback = function (callback) {
        callbacks.push(callback);
    };

    return action;
});
