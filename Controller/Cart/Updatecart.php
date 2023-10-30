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

namespace MageINIC\QuickView\Controller\Cart;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;

/**
 * Update Cart Controller
 */
class Updatecart extends Action implements HttpPostActionInterface
{
    /**
     * @var Json
     */
    protected Json $jsonEncoder;

    /**
     * @var SerializerInterface
     */
    protected SerializerInterface $serializer;

    /**
     * Update Cart Constructor
     *
     * @param Context $context
     * @param Json $jsonEncoder
     * @param SerializerInterface $serializer
     */
    public function __construct(
        Context             $context,
        Json                $jsonEncoder,
        SerializerInterface $serializer
    ) {
        parent::__construct($context);
        $this->jsonEncoder = $jsonEncoder;
        $this->serializer = $serializer;
    }

    /**
     * Update Cart Controller
     *
     * @return void
     */
    public function execute(): void
    {
        if (!$this->getRequest()->isAjax()) {
            $this->_redirect('/');
            return;
        }
        $jsonData = $this->serializer->serialize(['result' => true]);
        $this->getResponse()->setHeader('Content-type', 'application/json');
        $this->getResponse()->setBody($jsonData);
    }
}
