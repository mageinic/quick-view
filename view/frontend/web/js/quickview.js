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
    'jquery',
    'underscore',
    'mage/template',
    'Magento_Ui/js/modal/modal',
    'Magento_Customer/js/customer-data'
    ], function ($, _, mageTemplate, modal,customerData) {
        "use strict";
        $('.quickview-catalog_product-view').removeClass('page-layout-2columns-left');
        $('.quickview-catalog_product-view').removeClass('page-layout-2columns-right');
        $('.quickview-catalog_product-view').removeClass('page-layout-3columns');
        $('.quickview-catalog_product-view').addClass('page-layout-1column');
        var quickview = {
            getProductViewPopup: function (productUrl, productId) {
                if (!productUrl.length) {
                    return false;
                }
                var showMiniCart = parseInt(window.quickview.showMiniCart);
                window.quickview.showMiniCartFlag = false;
                $('body').trigger('processStart');
                var url = window.quickview.baseUrl + 'quickview/cart/updatecart';
                $(document).ready(
                    function () {
                        $('body').append('<div class="quickviewcontainer_'+ productId +'"></div>');
                        var modalContainer = $('.quickviewcontainer_'+ productId);
                        var frameHtml = $('<iframe>', { id: 'iFrame' + productId,src: productUrl + "?iframe=1"});
                        modalContainer.html(frameHtml);
                        var iframe_selector = "#iFrame" + productId;
                        var options = {
                            type: 'popup',
                            clickableOverlay: false,
                            responsive: true,
                            innerScroll: true,
                            modalClass: 'addquickview-popup',
                            title: '',
                            buttons: [{
                                text: $.mage.__('Close'),
                                class: 'close-modal',
                                click: function () {
                                    this.closeModal();
                                    $.ajax({
                                        url: url,
                                        method: "POST"
                                    });
                                    var sections = ['cart'];
                                    customerData.invalidate(sections);
                                    customerData.reload(sections, true);
                                }
                            }]
                        };
                        $(modalContainer).on(
                            'modalclosed', function () {
                                var sections = ['cart'];
                                customerData.invalidate(sections);
                                customerData.reload(sections, true);
                                modalContainer.empty();
                            }
                        );
                        var popup = modal(options, modalContainer);
                        $(iframe_selector).on('load', function () {
                                modalContainer.modal('openModal');
                                this.style.height = this.contentWindow.document.body.scrollHeight+1 + 'px';
                                this.style.border = '0';
                                this.style.width = '100%';
                                $('body').trigger('processStop');
                            }
                        );
                    }
                );
            }
        };
        window.quickview = quickview;
        return quickview;
    }
);
