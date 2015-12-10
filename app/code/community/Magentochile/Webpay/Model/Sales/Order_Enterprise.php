<?php
include_once('Mage/Sales/Model/Order.php');
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
class Magentochile_Webpay_Model_Sales_Order extends Mage_Sales_Model_Order {




public function setState($state, $status = false, $comment = '', $isCustomerNotified = null)
    {
        return $this->_setState($state, $status, $comment, $isCustomerNotified, false);/* was true*/
    }


    protected function _beforeSave() {
        parent::_beforeSave();        
 
        // Free all coupons/giftcards and rules applied to this order
        // when state is changed to CLOSED
        if ($this->getState() == self::STATE_CANCELED ) {
            $this->removeDiscount();
        }
 
        return $this;
    }
 
    /**
     * Removes all discount-counters on order
     * Discount will still be visible on order, 
     * but discounts and codes can be used several times
     */
    protected function removeDiscount() {
        // lookup rule ids
        $ruleIds = explode(',', $this->getAppliedRuleIds());
        $ruleIds = array_unique($ruleIds);
 
        $ruleCustomer = null;
        $customerId = $this->getCustomerId();
 
        // ********** Free up the applied rules
        // use each rule (and apply to customer, if applicable)
        foreach ($ruleIds as $ruleId) {
            if (!$ruleId) {
                continue;
            }
            $rule = Mage::getModel('salesrule/rule');
            $rule->load($ruleId);
            if ($rule->getId() && $rule->getTimesUsed() > 0) {
                $rule->setTimesUsed($rule->getTimesUsed() - 1);
                $rule->save();
 
                if ($customerId) {
                    $ruleCustomer = Mage::getModel('salesrule/rule_customer');
                    $ruleCustomer->loadByCustomerRule($customerId, $ruleId);
 
                    if ($ruleCustomer->getId() && $ruleCustomer->getTimesUsed() > 0) {
                        $ruleCustomer->setTimesUsed($ruleCustomer->getTimesUsed() - 1);
                        $ruleCustomer->save();
                    }
 
                }
            }
        }
 
        // ********** Free up the coupons
        $coupon = Mage::getModel('salesrule/coupon');
        /** @var Mage_SalesRule_Model_Coupon */
        $coupon->load($this->getCouponCode(), 'code');
        if ($coupon->getId() && $coupon->getTimesUsed() > 0) {
            $coupon->setTimesUsed($coupon->getTimesUsed() - 1);
            $coupon->save();
            if ($customerId) {
                $couponUsage = Mage::getResourceModel('salesrule/coupon_usage');
                $couponUsage->updateCustomerCouponTimesUsed($customerId, $coupon->getId());
            }
        }
 
 
        // ********** Free the giftcard
        // @todo fire this as en event to trigger observer as this is already supported there.
        // See : Enterprise_GiftCardAccount_Model_Observer::revertGiftCardAccountBalance
        $cards = Mage::helper('enterprise_giftcardaccount')->getCards( $this );
        if (is_array($cards)) {
            foreach ($cards as $card) {
                if (isset($card['authorized'])) {
                    $giftCard = Mage::getModel('enterprise_giftcardaccount/giftcardaccount')->load( $card['i'] );
 
                    if ($giftCard) {
                        $giftCard->revert($card['authorized'])
                            ->unsOrder()
                            ->save();
                    }
                }
            }
        }
    }
 
}