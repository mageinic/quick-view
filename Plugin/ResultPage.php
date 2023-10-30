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

use Magento\Framework\App\Request\Http;
use Magento\Framework\View\Result\Page;

/**
 * Plugin for Catalog Product List
 */
class ResultPage
{
    /**
     * @var Http
     */
    private Http $request;

    /**
     * ResultPage constructor
     *
     * @param Http $request
     */
    public function __construct(
        Http $request
    ) {
        $this->request = $request;
    }

    /**
     * Before Add Page Layout Plugin
     *
     * @param Page $subject
     * @param array $parameters
     * @param string|null $defaultHandle
     * @return array
     */
    public function beforeAddPageLayoutHandles(
        Page  $subject,
        array $parameters = [],
        string $defaultHandle = null
    ): array {
        if ($this->request->getFullActionName() == 'quickview_catalog_product_view') {
            return [$parameters, 'catalog_product_view'];
        } else {
            return [$parameters, $defaultHandle];
        }
    }
}
