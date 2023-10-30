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

use Magento\Framework\Event\ObserverInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Event\Observer;
use Magento\Framework\App\Request\Http;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Observer for Layout Load Before Event.
 */
class UpdateLayoutHandle implements ObserverInterface
{
    /**
     * @var Http
     */
    private Http $request;

    /**
     * @var StoreManagerInterface
     */
    private StoreManagerInterface $storeManager;

    /**
     * @var ProductRepositoryInterface
     */
    private ProductRepositoryInterface $productRepository;

    /**
     * UpdateLayoutHandle constructor.
     *
     * @param Http $request
     * @param StoreManagerInterface $storeManager
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(
        Http                       $request,
        StoreManagerInterface      $storeManager,
        ProductRepositoryInterface $productRepository
    ) {
        $this->request = $request;
        $this->storeManager = $storeManager;
        $this->productRepository = $productRepository;
    }

    /**
     * Update Layout Handler Class
     *
     * @param Observer $observer
     * @return $this|false
     * @throws NoSuchEntityException
     */
    public function execute(Observer $observer)
    {
        $layout = $observer->getData('layout');
        $fullActionName = $this->request->getFullActionName();
        $storeId = $this->storeManager->getStore()->getId();
        if ($fullActionName == 'quickview_catalog_product_view') {
            $pId= $this->request->getParam('id');
            if (isset($pId)) {
                try {
                    $product = $this->productRepository->getById($pId, false, $storeId);
                } catch (NoSuchEntityException $e) {
                    return false;
                }
                $productType = $product->getTypeId();
                $layout->getUpdate()->addHandle('quickview_catalog_product_view_type_' . $productType);
            }
        }
        return $this;
    }
}
