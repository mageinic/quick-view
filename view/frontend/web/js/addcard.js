/**
 * MageINIC
 * Copyright (C) 2023 MageINIC <support@mageinic.com>
 *
 * NOTICE OF LICENSE
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see https://opensource.org/licenses/gpl-3.0.html.
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category MageINIC
 * @package MageINIC_QuickView
 * @copyright Copyright (c) 2023 MageINIC (https://www.mageinic.com/)
 * @license https://opensource.org/licenses/gpl-3.0.html GNU General Public License,version 3 (GPL-3.0)
 * @author MageINIC <support@mageinic.com>
 */

define([
    "jquery",
    "Magento_Ui/js/modal/modal",
    "mage/translate"
], function ($, modal) {
    function validURL(str) {
        var pattern = new RegExp('^(https?:\\/\\/)?' + // protocol
            '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|' + // domain name
            '((\\d{1,3}\\.){3}\\d{1,3}))' + // OR ip (v4) address
            '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*' + // port and path
            '(\\?[;&a-z\\d%_.~+=-]*)?' + // query string
            '(\\#[-a-z\\d_]*)?$', 'i'); // fragment locator
        return !!pattern.test(str);
    }
    return function (configData) {
        $("a").click(function (event) {
            var hrefurl = $(this).attr('href');
            if (validURL(hrefurl)) {
                $(this).attr('href', "#")
                var url = window.location.href;
                var productId = jQuery("input[name='product']").val();
                var modalContainer = $('.quickviewcontainer_' + productId);
                $('.close-modal', window.parent.document.body).trigger('click');
                window.parent.location.replace(hrefurl);
            }
        });

        $(document).on('ajaxComplete', function (e, xhr, config) {
            var bodyElement = window.parent.document.body;
            var timeToClosePopup = window.quickview.timeToClosePopup;
            var showCheckoutButtons = window.quickview.showCheckoutButtons;
            var responseMessage = false;
            if (config.type.match(/GET/i) && _.isObject(xhr.responseJSON) && xhr.responseJSON != '') {
                var response = xhr.responseJSON;
                if (_.isObject(response.messages)) {
                    var responseMessageLength = response.messages.messages.length;
                    var message = response.messages.messages[0];
                    if (responseMessageLength) {
                        responseMessage = message.text;
                    }
                }

                if (_.isObject(response.cart) && _.isObject(response.messages)) {
                    var messageLength = response.messages.messages.length;
                    var cartMessage = response.messages.messages[0];
                    if (messageLength) {
                        responseMessage = cartMessage.text;
                    }
                }

                if (responseMessage) {
                    window.parent.quickview.showMiniCartFlag = true;
                }

                if (timeToClosePopup && responseMessage) {
                    setTimeout(function () {
                        $('.close-modal', bodyElement).trigger('click');
                    }, timeToClosePopup * 1000);
                }

                if (_.isObject(response.cart)) {
                    if (showCheckoutButtons && responseMessage) {
                        var checkoutContentBox = $('<div class="continue-shopping-checkout">' + responseMessage + '</div>');
                        checkoutContentBox.modal({
                            title: '', clickableOverlay: false, autoOpen: true, buttons: [{
                                text: $.mage.__('Continue Shopping'), 'class': 'action primary', attr: {
                                    'data-action': 'confirm'
                                }, click: function () {
                                    this.closeModal();
                                    $('.close-modal', bodyElement).trigger('click');
                                }
                            }, {
                                text: $.mage.__('Checkout'), 'class': 'action primary', attr: {
                                    'data-action': 'cancel'
                                }, click: function () {
                                    parent.window.location = configData.checkouturl;
                                }
                            }]
                        });
                    } else {
                        var checkoutContentBox = $('<div class="continue-shopping-checkout">' + responseMessage + '</div>');
                        checkoutContentBox.modal({
                            title: '', clickableOverlay: false, autoOpen: true, buttons: [{
                                text: $.mage.__('Continue Shopping'), 'class': 'action primary', attr: {
                                    'data-action': 'confirm'
                                }, click: function () {
                                    this.closeModal();
                                    $('.close-modal', bodyElement).trigger('click');
                                }
                            }]
                        });
                    }
                }
            }
        });
    };
});
