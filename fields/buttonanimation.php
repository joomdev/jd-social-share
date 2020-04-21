<?php
/**
 * @package		JD Social Share
 * @version		1.5
 * @author		JoomDev
 * @copyright	Copyright (C) 2008 - 2020 Joomdev.com. All rights reserved
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_PLATFORM') or die;

class JFormFieldButtonanimation extends JFormField
{
    protected $type = 'buttonanimation';
    protected function getInput()
	{
		$value    	= ($this->value != '') ? $this->value : 1;
		$selected	= ($this->value != '') ? $this->value : 1;
		$selected1 	= ($selected == 1) ? 'jd_social_selected' : '';
		$selected2 	= ($selected == 2) ? 'jd_social_selected' : '';
		$selected3 	= ($selected == 3) ? 'jd_social_selected' : '';
		$selected4 	= ($selected == 4) ? 'jd_social_selected' : '';
		$dco = JFactory::getDocument();
		$dco->addStyleSheet(JURI::root().'plugins/content/jdsocialshare/assets/animation/buttonanimation.css');
		$dco->addScript(JURI::root().'plugins/content/jdsocialshare/assets/js/buttonanimation.js');
		$shape = '<div class="jd_social_row jd_social_selection buttonanimation">
					<div class="jd_social_animation jd_social_animation_type_ jd_social_icon '.$selected1.' button_square_content hover_1" data-type="1">
					  <ul>
						<li class="facebook"><a href="javascript:void(0);"><span>Facebook</span></a></li>
						<li class="twitter"><a href="javascript:void(0);" > <span>Twitter</span></a></li>
						<li class="linkedin"><a href="javascript:void(0);"><span>Linkedin</span></a></li>
						<li class="pinterest"><a href="javascript:void(0);"><span>Pinterest</span></a></li>
					  </ul>
					</div>
					<div class="jd_social_animation jd_social_animation_type_ jd_social_icon '.$selected2.' button_square_content hover_2" data-type="2">
					  <ul>
						<li class="facebook"><a href="javascript:void(0);"><span>Facebook</span></a></li>
						<li class="twitter"><a href="javascript:void(0);"><span>Twitter</span></a></li>
						<li class="linkedin"><a href="javascript:void(0);"><span>Linkedin</span></a></li>
						<li class="pinterest"><a href="javascript:void(0);"><span>Pinterest</span></a></li>
					  </ul>
					</div>
					<div class="jd_social_animation jd_social_animation_type_ jd_social_icon '.$selected3.' button_square_content hover_3" data-type="3">
					  <ul>
						<li class="facebook "><a href="javascript:void(0);" class="hvr-icon-float-away"><span>Facebook</span></a></li>
						<li class="twitter "><a href="javascript:void(0);" class="hvr-icon-float-away"><span>Twitter</span></a></li>
						<li class="linkedin "><a href="javascript:void(0);" class="hvr-icon-float-away"><span>Linkedin</span></a></li>
						<li class="pinterest"><a href="javascript:void(0);" class="hvr-icon-float-away"><span>Pinterest</span></a></li>
					  </ul>
					</div>
					<div class="jd_social_animation jd_social_animation_type_ jd_social_icon '.$selected4.' button_square_content hover_4" data-type="4">
					  <ul>
						<li class="facebook 13px"><a href="javascript:void(0);"><span>Facebook</span></a></li>
						<li class="twitter 13px"><a href="javascript:void(0);"><span>Twitter</span></a></li>
						<li class="linkedin 13px"><a href="javascript:void(0);"><span>Linkedin</a></span></li>
						<li class="pinterest 13px"><a href="javascript:void(0);"><span>Pinterest</a></span></li>
					  </ul>
					</div>
					<input name="'.$this->name.'"  class="'.$this->class.'" id="'.$this->id.'" value="'.$value.'" type="hidden" />
				</div>';
		return $shape;
	}
}