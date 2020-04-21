<?php
/**
 * @package		JD Social Share
 * @version		1.5
 * @author		JoomDev
 * @copyright	Copyright (C) 2008 - 2020 Joomdev.com. All rights reserved
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('JPATH_PLATFORM') or die;

class JFormFieldBottonshape extends JFormField
{
   protected $type = 'bottonshape';
	protected function getInput()
	{
		$value		= ($this->value != '') ? $this->value : "square";
		$selected	= ($this->value != '') ? $this->value : "square";
		$rectangle_selected = ($selected == 'square') ? 'jd_social_selected' : '';
		$radius_selected 	= ($selected == 'radius') ? 'jd_social_selected' : '';
		$circle_selected 	= ($selected == 'circle') ? 'jd_social_selected' : '';
		$dco = JFactory::getDocument();
		$dco->addScript(JURI::root().'plugins/content/jdsocialshare/assets/js/bottonshape.js');
		$shape = '<div class="jd_social_row jd_social_selection bottonshape">
		<div class="jd_social_shape jd_social_icon jd_social_single_selectable '.$rectangle_selected.'" data-type="square">
			<div class="jd_social_shape_tile jd_social_icon jd_social_shape_rectangle"></div>
		</div>
		<div class="jd_social_shape jd_social_icon jd_social_single_selectable '.$radius_selected.'" data-type="radius">
			<div class="jd_social_shape_tile jd_social_icon jd_social_shape_rounded"></div>
		</div>
		<div class="jd_social_shape jd_social_icon jd_social_single_selectable '.$circle_selected.'" data-type="circle">
			<div class="jd_social_shape_tile jd_social_icon jd_social_shape_circle"></div>
		</div>
		<input name="'.$this->name.'" class="'.$this->class.'" id="'.$this->id.'" value="'.$value.'" type="hidden" />
		</div>';
		return $shape;
	}
}