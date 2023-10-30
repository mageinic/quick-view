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

namespace MageINIC\QuickView\Observer;

use Magento\Framework\App\Request\Http;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use MageINIC\QuickView\Helper\Data;

/**
 * Observer For Layout Remove Blocks After Event.
 */
class RemoveBlock implements ObserverInterface
{
    /**
     * @var Data
     */
    private Data $helper;

    /**
     * @var Http
     */
    private Http $request;

    /**
     * RemoveBlock constructor.
     *
     * @param Http $request
     * @param Data $helper
     */
    public function __construct(
        Http $request,
        Data $helper
    ) {
        $this->helper = $helper;
        $this->request = $request;
    }

    /**
     * Remove Block Execute Function
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer): void
    {
        $layout = $observer->getLayout();
        $block = $layout->getBlock('catalog.product.related');
        $fullActionName = $this->request->getFullActionName();
        if ($fullActionName == 'quickview_catalog_product_view') {
            $displayRelatedProduct = $this->helper->getShowRelatedProduct();
            $displayUpsellProduct = $this->helper->getShowUpsellProduct();
            if ($block && !$displayRelatedProduct) {
                $layout->unsetElement('catalog.product.related');
            }
            if ($block && !$displayUpsellProduct) {
                $layout->unsetElement('product.info.upsell');
            }
        }
    }
}
