<?php
/**
 * @category    MT
 * @package     MT_Widget
 * @copyright   Copyright (C) 2008-2014 MagentoThemes.net. All Rights Reserved.
 * @license     GNU General Public License version 2 or later
 * @author      MagentoThemes.net
 * @email       support@magentothemes.net
 */

class MT_Widget_Model_Widget_Source_Parallax_Type{
    public function toOptionArray(){
        $types[] = array('value' => 'image', 'label' => Mage::helper('mtwidget')->__('Image'));
        $types[] = array('value' => 'video', 'label' => Mage::helper('mtwidget')->__('Video Service'));
        $types[] = array('value' => 'file', 'label' => Mage::helper('mtwidget')->__('Video File'));

        return $types;
    }
}
