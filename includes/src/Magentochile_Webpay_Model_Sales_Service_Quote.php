<?php
include_once('Mage/Sales/Model/Service/Quote.php');
/**
 * Magentochile_Webpay extension
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category   Payment
 * @package    Magentochile_Webpay
 * @copyright  Copyright (c) 2013 Magento Chile LLC
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * @category   Payment
 * @package    Magentochile_Webpay
 * @author     Boris Duran R. <bduran@magentochile.cl>
 */
/**
 * Quote submit service model
 */
class Magentochile_Webpay_Model_Sales_Service_Quote extends Mage_Sales_Model_Service_Quote
{

    /**
     * Inactivate quote
     *
     * @return Mage_Sales_Model_Service_Quote
     */
    protected function _inactivateQuote()
    {
        if ($this->_shouldInactivateQuote) {
            $this->_quote->setIsActive(true);/* was false*/
            //$this->_quote->setIsActive(false);/* was false*/
            //Mage::getSingleton('checkout/cart')->truncate();
            //Mage::getSingleton('checkout/session')->clear();
        }
        return $this;
    }
}