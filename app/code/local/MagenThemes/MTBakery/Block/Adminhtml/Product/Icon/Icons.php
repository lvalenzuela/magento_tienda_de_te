<?php
/**
 *
 * ------------------------------------------------------------------------------
 * @category     MT
 * @package      MT_Themes
 * ------------------------------------------------------------------------------
 * @copyright    Copyright (C) 2008-2013 MagentoThemes.net. All Rights Reserved.
 * @license      GNU General Public License version 2 or later;
 * @author       MagentoThemes.net
 * @email        support@magentothemes.net
 * ------------------------------------------------------------------------------
 *
 */
?>
<?php
class MagenThemes_MTBakery_Block_Adminhtml_Product_Icon_Icons extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element){ 
       	$html = parent::_getElementHtml($element);
		$directry = Mage::getBaseDir('media').DS.'wysiwyg'.DS.'magenthemes'.DS.'mtbakery'.DS.'product'.DS.'icons';
		$urlparth = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);
		$images = array();
		if (is_dir($directry)) {
			if ($dh = opendir($directry)) { 
				while (($file = readdir($dh)) !== false) {
					if(is_file($directry.DS.$file)){
						$filetype = substr($file, -3, 3);
						switch ($filetype)
						{ 
							case 'jpg':
							case 'png':
							case 'gif':  
								$images[] = $file; 
								break; 
						}
					} 
				} 
			}
		}
        $html .='<link href="'.$urlparth.'skin/adminhtml/mtbakery/css/style.css'.'" type="text/css" rel="stylesheet">';
		$html .='<div class="listpattern '.$element->getHtmlId().'_icon">';
			$html .='<span class="item">
						<span class="ptnone">None</span>
						<input type="radio" name="'.$element->getHtmlId().'_icon" value="none" style="margin: 8px; 0 4px 0" class="valpt"/>
					 </span>';
			if($images){
				foreach ($images as $img){
			$html .='<span class="item">
						<img src="'.$urlparth.'media/wysiwyg/magenthemes/mtbakery/product/icons/'.$img.'" />
						<input type="radio" name="'.$element->getHtmlId().'_icon" value="'.$img.'" class="valpt"/>
					 </span>';
				}
			}
		$html .='</div>';
		$html .= ' 
				<script type="text/javascript">
					jQuery(window).load(function(){
						jQuery(".'.$element->getHtmlId().'_icon input[type=radio]").click(function(){
							jQuery("#'.$element->getHtmlId().'").val(jQuery(this).val())
						}); 
						icon'.$element->getHtmlId().'Active();
					});
					function icon'.$element->getHtmlId().'Active(){
						var icon =jQuery("#'.$element->getHtmlId().'").val();
						jQuery(".'.$element->getHtmlId().'_icon input[type=radio]").each(function(i,rad){
							if(rad.value==icon){  
								jQuery(rad).attr("checked", true);
							}   
						});
					}
				</script> 
			';
        return $html;
    }
}
?>