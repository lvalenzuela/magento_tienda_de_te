<?php
/**
 * @category    MT
 * @package     MT_Widget
 * @copyright   Copyright (C) 2008-2014 MagentoThemes.net. All Rights Reserved.
 * @license     GNU General Public License version 2 or later
 * @author      MagentoThemes.net
 * @email       support@magentothemes.net
 */

class MT_Widget_Model_Widget_Source_Background{
    public function toOptionArray(){
        return array(
            array('value' => '', 'label' => 'No'),
            array('value' => 'parallax', 'label' => 'Parallax'),
            array('value' => 'kenburns', 'label' => 'Ken Burns')
        );
    }
}
