<?php
/**
 * @package		JD Social Share
 * @version		1.5
 * @author		JoomDev
 * @copyright	Copyright (C) 2008 - 2020 Joomdev.com. All rights reserved
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_PLATFORM') or die;
class JFormFieldPagetype extends JFormField
{
   protected $type = 'pagetype';
   protected function getInput()
	{
		$value = $this->value;
		if(!is_array($value))
			$value = array();
		 return '<select id="'.$this->id.'" name="'.$this->name.'[]" class="'.$this->class.'" multiple="multiple">
			<option value="archive" '.((in_array("archive",$value)) ? "selected='selected'" : "").'>'.JText::_("JDSOCIALSHARE_ARCHIVED_ARTICLES").'</option>
			<option value="article" '.((in_array("article",$value)) ? "selected='selected'" : "").'>'.JText::_("JDSOCIALSHARE_SINGLE_ARTICLE").'</option>
			<option value="categoryblog" '.((in_array("categoryblog",$value)) ? "selected='selected'" : "").'>'.JText::_("JDSOCIALSHARE_CATEGORY_BLOG").'</option>
			<option value="category" '.((in_array("category",$value)) ? "selected='selected'" : "").'>'.JText::_("JDSOCIALSHARE_CATEGORY_LIST").'</option>
			<option value="featured" '.((in_array("featured",$value)) ? "selected='selected'" : "").'>'.JText::_("JDSOCIALSHARE_FEATURED_ARTICLE").'</option>
		</select>';
	}
}