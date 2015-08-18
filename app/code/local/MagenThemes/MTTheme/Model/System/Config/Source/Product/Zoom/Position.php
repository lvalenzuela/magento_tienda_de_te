<?php
/**
 * @category    MT
 * @package     MT_Attribute
 * @copyright   Copyright (C) 2008-2013 MagentoThemes.net. All Rights Reserved.
 * @license     GNU General Public License version 2 or later
 * @author      MagentoThemes.net
 * @email       support@magentothemes.net
 */
class MagenThemes_MTTheme_Model_System_Config_Source_Product_Zoom_Position
{
    public function toOptionArray(){
        return array(
            array('value' => 'right', 'label' => Mage::helper('adminhtml')->__('Right')),
            array('value' => 'left', 'label' => Mage::helper('adminhtml')->__('Left')),
            array('value' => 'top', 'label' => Mage::helper('adminhtml')->__('Top')),
            array('value' => 'bottom', 'label' => Mage::helper('adminhtml')->__('Bottom')),
            array('value' => 'inside', 'label' => Mage::helper('adminhtml')->__('Inside'))
        );
    }
}