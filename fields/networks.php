<?php
/**
 * @package		JD Social Share
 * @version		1.5
 * @author		JoomDev
 * @copyright	Copyright (C) 2008 - 2020 Joomdev.com. All rights reserved
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_PLATFORM') or die;
JHtml::_('bootstrap.modal');

class JFormFieldNetworks extends JFormField
{
	 protected $type = 'networks'; 

	 protected function getInput()
	{
		$value = $this->value;
		$doc = JFactory::getDocument();
		$doc->addStyleSheet(JURI::root().'plugins/content/jdsocialshare/assets/jd_admin.css');
		$doc->addScript(JURI::root().'plugins/content/jdsocialshare/assets/js/jquery-ui.js');
		$doc->addScript(JURI::root().'plugins/content/jdsocialshare/assets/js/admin.js');
		$doc->addStyleSheet(JURI::root().'media/jui/css/icomoon.css');
		$shape  = '';
		$shape .= '<div class="jd_social select_networkpop"><a class="button" data-area="sharing">'.JText::_("JDSOCIALSHARE_UPDATE_SOCIAL_NETWORKS").'</a></div>';
		$shape .= '<div class="jd_social_networks jd_social_row jd_social_sortable follow_networks_networks_sorting" id="sortable_follow_networks_networks_sorting"></div>';
		$shape .= '<div class="jd_social_networks jd_social_row jd_social_sortable sharing_networks_networks_sorting ui-sortable" id="sortable_sharing_networks_networks_sorting">';
		$networks = json_decode($value);
		if(!empty($networks) && is_array($networks)){
			foreach($networks as $k=>$network){
				$shape .= '<div class="jd_social_network jd_social_icon ui-sortable-handle tosave" data-name="'.$network->network.'" data-area="sharing_networks_networks_sorting"><i class="icon-move large-icon"></i><span class="jd_social_'.$network->network.'"><a href="javascript:void(0);" class="jd_social_deletenetwork"></a></span><input class="input_label" placeholder="'.$network->label.'" value="'.$network->label.'" name="jd_social[sharing_networks_networks_sorting][label]['.$k.']" type="text"></div>';
			}
		}
		$shape .= '</div>';
		$shape .= "<input name='".$this->name."' class='".$this->class."' id='".$this->id."' value='".$value."' type='hidden' />";
		$shape .= $this->getModal();
		return $shape;
	}
	
	protected function getModal() {
		$selectNetworks = $this->getSelectedNetworks($this->value);
		$modalbox = '';
		$modalbox .= '<div class="jd_social_networks_modal sharing" id="networks_container">
				<div class="jd_social_inner_container">
					<div class="jd_social_modal_header">
						<h3>'.JText::_("JDSOCIALSHARE_ADD_SOCIAL_NETWORKS_TO_ADD").'</h3>
						<span class="jd_social_close" data-dismiss="modal"></span>
					</div>
					<div class="social_icons_container sharing_networks_networks_sorting">';
					$networks = $this->getNetworks();
					foreach($networks as $nework){
						$name = $nework['name'];
						$label = $nework['label'];
						$placeholder = $nework['placeholder'];
						$username = $nework['username'];
						$class = (in_array($name,$selectNetworks)) ? ' jd_social_selectednetwork' : ' jd_social_nonselectednetwork';
						$modalbox .= '<div class="jd_social_network jd_social_icon" data-name="'.$name.'" data-label="'.$label.'" data-placeholder="'.$placeholder.'" data-username="'.$username.'">
								<span class="jd_social_'.$name.$class.'">
									<a href="javascript:void(0);">
										<span class="jd_social_networkname">'.$label.'</span>
									</a>
								</span>
							</div>';
					}
		$modalbox .= '</div>
					<div class="jd_social_modal_footer">
						<a href="javascript:void(0);" class="jd_social_apply" data-area="sharing_networks_networks_sorting">'.JText::_("JDSOCIALSHARE_UPDATE").'</a>
					</div>
				</div>
			</div>';
		echo $modalbox;
	}
	protected function getNetworks(){
		return		 array(
						'facebook'=>array(
								'name'=>'facebook',
								'label'=>'Facebook',
								'placeholder'=>'username',
								'username'=>'false',
								'api_support'=>'true',
							),
						'twitter'=>array(
								'name'=>'twitter',
								'label'=>'Twitter',
								'placeholder'=>'username',
								'username'=>'false',
								'api_support'=>'true',
							),
						'buffer'=>array(
								'name'=>'buffer',
								'label'=>'Buffer',
								'placeholder'=>'username',
								'username'=>'false',
								'api_support'=>'true',
							),
						'digg'=>array(
								'name'=>'digg',
								'label'=>'Digg',
								'placeholder'=>'username',
								'username'=>'false',
								'api_support'=>'true',
							),
						'evernote'=>array(
								'name'=>'evernote',
								'label'=>'Evernote',
								'placeholder'=>'username',
								'username'=>'false',
								'api_support'=>'true',
							),
						'pinterest'=>array(
								'name'=>'pinterest',
								'label'=>'Pinterest',
								'placeholder'=>'username',
								'username'=>'false',
								'api_support'=>'true',
							),
						'friendfeed'=>array(
								'name'=>'friendfeed',
								'label'=>'FriendFeed',
								'placeholder'=>'username',
								'username'=>'false',
								'api_support'=>'true',
							),
						'hackernews'=>array(
								'name'=>'hackernews',
								'label'=>'Hacker News',
								'placeholder'=>'username',
								'username'=>'false',
								'api_support'=>'true',
							),
						'livejournal'=>array(
								'name'=>'livejournal',
								'label'=>'LiveJournal',
								'placeholder'=>'username',
								'username'=>'false',
								'api_support'=>'true',
							),
						'newsvine'=>array(
								'name'=>'newsvine',
								'label'=>'Newsvine',
								'placeholder'=>'username',
								'username'=>'false',
								'api_support'=>'true',
							),
						'aol'=>array(
								'name'=>'aol',
								'label'=>'AOL',
								'placeholder'=>'username',
								'username'=>'false',
								'api_support'=>'true',
						),	
						'gmail'=>array(
								'name'=>'gmail',
								'label'=>'Gmail',
								'placeholder'=>'username',
								'username'=>'false',
								'api_support'=>'true',
						),	
						'printfriendly'=>array(
								'name'=>'printfriendly',
								'label'=>'Print Friendly',
								'placeholder'=>'username',
								'username'=>'false',
								'api_support'=>'true',
						),
						'yahoomail'=>array(
								'name'=>'yahoomail',
								'label'=>'Yahoo Mail',
								'placeholder'=>'username',
								'username'=>'false',
								'api_support'=>'true',
						),						
						'delicious'=>array(
								'name'=>'delicious',
								'label'=>'Delicious',
								'placeholder'=>'username',
								'username'=>'false',
								'api_support'=>'true',
						),
						'reddit'=>array(
								'name'=>'reddit',
								'label'=>'Reddit',
								'placeholder'=>'username',
								'username'=>'false',
								'api_support'=>'true',
						),
						'vkontakte'=>array(
								'name'=>'vkontakte',
								'label'=>'VKontakte',
								'placeholder'=>'username',
								'username'=>'false',
								'api_support'=>'true',
						),
						'linkedin'=>array(
								'name'=>'linkedin',
								'label'=>'LinkedIn',
								'placeholder'=>'username',
								'username'=>'false',
								'api_support'=>'true',
						),
						'myspace'=>array(
								'name'=>'myspace',
								'label'=>'Myspace',
								'placeholder'=>'username',
								'username'=>'false',
								'api_support'=>'true',
						),
						'blogger'=>array(
								'name'=>'blogger',
								'label'=>'Blogger',
								'placeholder'=>'username',
								'username'=>'false',
								'api_support'=>'true',
						),
						'stumbleupon'=>array(
								'name'=>'stumbleupon',
								'label'=>'StumbleUpon',
								'placeholder'=>'username',
								'username'=>'false',
								'api_support'=>'true',
						),
						'tumblr'=>array(
								'name'=>'tumblr',
								'label'=>'Tumblr',
								'placeholder'=>'username',
								'username'=>'false',
								'api_support'=>'true',
						),
						'like'=>array(
								'name'=>'like',
								'label'=>'Like',
								'placeholder'=>'username',
								'username'=>'false',
								'api_support'=>'true',
						),
						'like'=>array(
								'name'=>'whatsapp',
								'label'=>'WhatsApp',
								'placeholder'=>'username',
								'username'=>'false',
								'api_support'=>'true',
						),
					);			
		}
		protected function getSelectedNetworks($data = array()){
			$selected = array();
			$networks = json_decode($data);
			if(!empty($networks) && is_array($networks)){
				foreach(json_decode($data) as $k=>$v){
					$selected[] = $v->network;
				}
			}
			return $selected;
		}
}