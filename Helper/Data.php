<?php
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

namespace MageINIC\QuickView\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Helper Class Data For Quick View
 */
class Data extends AbstractHelper
{
    /**#@+
     * Constants For Module Config Value Path.
     */
    public const QUICK_VIEW_MODULE_ENABLED = 'quick_view/general/enable';
    public const QUICK_VIEW_ADDITIONAL_INFO = 'quick_view/general/additional_information';
    public const QUICK_VIEW_SHOW_RELATED_PRODUCT_BLOCK = 'quick_view/general/show_related_product_block';
    public const QUICK_VIEW_SHOW_UPSELL_PRODUCT_BLOCK = 'quick_view/general/show_upsell_product_block';
    public const QUICK_VIEW_TEXT = 'quick_view/general/quick_view_link_text';
    public const QUICK_VIEW_CLOSE_POPUP_TIME = 'quick_view/general/time_to_close_popup';
    public const QUICK_VIEW_SHOW_CHECKOUT_BUTTON = 'quick_view/general/show_checkout_button';
    /**#@-*/

    /**
     * @var StoreManagerInterface
     */
    private StoreManagerInterface $storeManager;

    /**
     * @var int
     */
    private int $storeId;

    /**
     * Data constructor
     *
     * @param Context $context
     * @param ScopeConfigInterface $scopeConfig
     * @param StoreManagerInterface $storeManager
     * @throws NoSuchEntityException
     */
    public function __construct(
        Context               $context,
        ScopeConfigInterface  $scopeConfig,
        StoreManagerInterface $storeManager
    ) {
        parent::__construct($context);
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
        $this->storeId = $this->storeManager->getStore()->getId();
    }

    /**
     * Get Module Enable
     *
     * @return bool
     */
    public function getQuickViewEnabled(): bool
    {
        return (bool)$this->scopeConfig->getValue(
            self::QUICK_VIEW_MODULE_ENABLED,
            ScopeInterface::SCOPE_STORE,
            $this->storeId
        );
    }

    /**
     * Get Additional Information Enable
     *
     * @return bool
     */
    public function getAdditionalInfoEnabled(): bool
    {
        return $this->scopeConfig->getValue(
            self::QUICK_VIEW_ADDITIONAL_INFO,
            ScopeInterface::SCOPE_STORE,
            $this->storeId
        );
    }

    /**
     * Enable On Related Product
     *
     * @return bool
     */
    public function getShowRelatedProduct(): bool
    {
        return $this->scopeConfig->getValue(
            self::QUICK_VIEW_SHOW_RELATED_PRODUCT_BLOCK,
            ScopeInterface::SCOPE_STORE,
            $this->storeId
        );
    }

    /**
     * Enable On Upsell Product
     *
     * @return bool
     */
    public function getShowUpsellProduct(): bool
    {
        return $this->scopeConfig->getValue(
            self::QUICK_VIEW_SHOW_UPSELL_PRODUCT_BLOCK,
            ScopeInterface::SCOPE_STORE,
            $this->storeId
        );
    }

    /**
     * Quick View Button Text
     *
     * @return string
     */
    public function getQuickViewButtonText(): string
    {
        return $this->scopeConfig->getValue(
            self::QUICK_VIEW_TEXT,
            ScopeInterface::SCOPE_STORE,
            $this->storeId
        );
    }

    /**
     * Quick View Show Checkout Buttons
     *
     * @return bool
     */
    public function getQuickViewShowCheckoutButtons(): bool
    {
        return $this->scopeConfig->getValue(
            self::QUICK_VIEW_SHOW_CHECKOUT_BUTTON,
            ScopeInterface::SCOPE_STORE,
            $this->storeId
        );
    }

    /**
     * Quick View Time To Close Pop Up
     *
     * @return string|null
     */
    public function getQuickViewTimeClosePopUp(): string|null
    {
        return $this->scopeConfig->getValue(
            self::QUICK_VIEW_CLOSE_POPUP_TIME,
            ScopeInterface::SCOPE_STORE,
            $this->storeId
        );
    }

    /**
     * Quick View Controller Url
     *
     * @return string
     * @throws NoSuchEntityException
     */
    public function getQuickViewUrl(): string
    {
        return $this->storeManager->getStore()->getBaseUrl()
            . 'quickview/catalog_product/view/id/';
    }
}
