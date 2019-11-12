<?php
/**
 * @package		JD Social Share
 * @version		1.4
 * @author		JoomDev
 * @copyright	Copyright (C) 2008 - 2019 Joomdev.com. All rights reserved
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_PLATFORM') or die;
class JFormFieldEbpagetype extends JFormField
{
   protected $type = 'ebpagetype';
   protected function getInput()
	{
		$value = $this->value;
		if(!is_array($value))
		$value = array();
		return '<select id="'.$this->id.'" name="'.$this->name.'[]" class="'.$this->class.'" multiple="multiple">
		<option value="entry" '.((in_array("entry",$value)) ? "selected='selected'" : "").'>'.JText::_("JDSOCIALSHARE_POST_SINGLE_POST").'</option> 			
		</select>'; 
	}
}