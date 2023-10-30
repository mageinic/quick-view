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

namespace MageINIC\QuickView\Plugin;

use Closure;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Block\Product\ListProduct;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\UrlInterface;
use MageINIC\QuickView\Helper\Data;

/**
 * Plugin for Catalog List Product
 */
class BlockProductList
{
    /**
     * @var UrlInterface
     */
    protected UrlInterface $urlInterface;

    /**
     * @var Data
     */
    private Data $helper;

    /**
     * BlockProductList constructor.
     * @param UrlInterface $urlInterface
     * @param Data $helper
     */
    public function __construct(
        UrlInterface $urlInterface,
        Data         $helper
    ) {
        $this->urlInterface = $urlInterface;
        $this->helper = $helper;
    }

    /**
     * Around Plugin Of Product Detail
     *
     * @param ListProduct $subject
     * @param Closure $proceed
     * @param Product $product
     * @return mixed|string
     * @throws NoSuchEntityException
     */
    public function aroundGetProductDetailsHtml(
        ListProduct $subject,
        Closure $proceed,
        Product $product
    ): string {
        $result = $proceed($product);
        $isEnabled = $this->helper->getQuickViewEnabled();
        $buttonText = $this->helper->getQuickViewButtonText();
        $style = '';
        if ($isEnabled) {
            $productId = $product->getId();
            $productUrl = $this->helper->getQuickViewUrl() . $productId;
            return $result . '<a ' . $style . ' class="addquickview" data-qvpid="' . $productId . '"
                       data-qvurl=' . $productUrl . ' href="javascript:void(0);"><span>' . __($buttonText) . '</span>
                       </a>';
        }
        return $result;
    }
}
