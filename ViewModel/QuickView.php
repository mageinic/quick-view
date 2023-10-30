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

namespace MageINIC\QuickView\ViewModel;

use Magento\Catalog\Helper\Output;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use MageINIC\QuickView\Helper\Data;

/**
 * ViewModel For Provide Helper Object To Template File
 */
class QuickView implements ArgumentInterface
{
    /**
     * @var Output
     */
    private Output $outputHelper;

    /**
     * @var Data
     */
    private Data $quickViewHelper;

    /**
     * QuickView constructor
     *
     * @param Output $outputHelper
     * @param Data $quickViewHelper
     */
    public function __construct(
        Output $outputHelper,
        Data   $quickViewHelper
    ) {
        $this->outputHelper = $outputHelper;
        $this->quickViewHelper = $quickViewHelper;
    }

    /**
     * Get Output Helper
     *
     * @return Output
     */
    public function getOutputHelper(): Output
    {
        return $this->outputHelper;
    }

    /**
     * Get Quick View Helper
     *
     * @return Data
     */
    public function getQuickViewHelper(): Data
    {
        return $this->quickViewHelper;
    }
}
