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

namespace MageINIC\QuickView\Block;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;
use MageINIC\QuickView\Helper\Data;
use Magento\Framework\Serialize\SerializerInterface;

/**
 * Quick View Init Config Block
 */
class InitConfig extends Template
{
    /**
     * @var Data
     */
    private Data $helper;

    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    /**
     * @var array
     */
    protected array $data;

    /**
     * @param Template\Context $context
     * @param Data $helper
     * @param SerializerInterface $serializer
     * @param array $data
     */
    public function __construct(
        Template\Context    $context,
        Data                $helper,
        SerializerInterface $serializer,
        array               $data = []
    ) {
        parent::__construct($context, $data);
        $this->helper = $helper;
        $this->serializer = $serializer;
    }

    /**
     * Get Configuration
     *
     * @return string
     * @throws NoSuchEntityException
     */
    public function getConfig(): string
    {
        $settings = [
            'baseUrl'             => $this->_storeManager->getStore()->getBaseUrl(),
            'timeToClosePopup'    => $this->helper->getQuickViewTimeClosePopUp(),
            'showCheckoutButtons' => $this->helper->getQuickViewshowCheckoutButtons()
        ];
        return $this->serializer->serialize($settings);
    }
}
