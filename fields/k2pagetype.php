<?php
/**
 * @package	JD Social Share
 * @version	1.0
 * @author	joomdev.com
 * @copyright	Copyright (C) 2008 - 2018 Joomdev.com. All rights reserved
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_PLATFORM') or die;
class JFormFieldK2pagetype extends JFormField
{
    protected $type = 'k2pagetype'; 

    protected function getInput()
	{	
		$value = $this->value;
		
		if(!is_array($value))
			$value = array();
		
		 return '<select id="'.$this->id.'" name="'.$this->name.'[]" class="'.$this->class.'" multiple="multiple">
			<option value="category" '.((in_array("category",$value)) ? "selected='selected'" : "").'>'.JText::_("JDSOCIALSHARE_CATEGORIES").'</option>
			<option value="item" '.((in_array("item",$value)) ? "selected='selected'" : "").'>'.JText::_("JDSOCIALSHARE_ITEM").'</option>
			<option value="user" '.((in_array("user",$value)) ? "selected='selected'" : "").'>'.JText::_("JDSOCIALSHARE_USER_PAGE_BLOG").'</option> 
		</select>'; 
	} 
}

/* 
<option value="tag" '.((in_array("tag",$value)) ? "selected='selected'" : "").'>'.JText::_("JDSOCIALSHARE_TAG").'</option>
There is no event in tag view page.
 */