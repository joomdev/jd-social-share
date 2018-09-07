<?php
/**
 * @package	JD Social Share
 * @version	1.0
 * @author	joomdev.com
 * @copyright	Copyright (C) 2008 - 2018 Joomdev.com. All rights reserved
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
include_once('libraries/jdsocial.php');
include_once('libraries/bitly.php');
include_once('libraries/googleurl.php');
class PlgContentJdsocialshare extends JPlugin
{
	public function __construct(& $subject, $config)
	{
		$option = JRequest::getVar('option');		
		$view = JRequest::getVar('view');		
		JHtml::_('jquery.framework');
		$app = JFactory::getApplication();
		if(!$app->isAdmin()){
			$document = JFactory::getDocument();
			$document->addStyleSheet(JURI::root().'plugins/content/jdsocialshare/assets/animation/css/icon.css', 'text/css');
			$document->addStyleSheet(JURI::root().'plugins/content/jdsocialshare/assets/animation/css/style.css', 'text/css');
			$document->addScript(JURI::root().'plugins/content/jdsocialshare/assets/js/jdsocialshare.js');
		}else{
			return false;
		}		
		parent::__construct($subject, $config);
	} 

	public function onContentBeforeDisplay($context, &$row, &$params, $page=0)
    {
		$option	 	= JRequest::getVar('option');
		$view 		= JRequest::getVar('view');
		$layout 	= JRequest::getVar('layout');
		$jdparams = $this->params;
		// com_content
		if(isset($option)  && $option == 'com_content'){
			$excludesPages = array();
			$articleType_ = explode('.',$context);
			$articleType = (isset($articleType_[1])) ? $articleType_[1] : '';
			$buttonPosition = $jdparams->get('buttons_position');
			$pageTypeOption = ($jdparams->get('pagetype_option') == 1 || ($jdparams->get('pagetype_option') != '' && $jdparams->get('pagetype_option') == 0)) ? $jdparams->get('pagetype_option') : 3;
			$excludesPages = $jdparams->get('pagetype');
			// page type condition
			$displayPage = false;
			switch($pageTypeOption){
				case 0 :
					if(!empty($excludesPages) && in_array($articleType,$excludesPages)){ 
						$displayPage = false; 
					}else{
						$displayPage = true; 
					} 
				break;
				case 1 :
					if((!empty($excludesPages) && in_array($articleType,$excludesPages))){
						$displayPage = true; 
						
					}else{
						$displayPage = false; 
					}
				break;

				default :  
					$displayPage = true;
			}
			// exclude/ include for categories		
			$pageCategoryOption = ($jdparams->get('article_categories_option') == 1 || ($jdparams->get('article_categories_option') != '' && $jdparams->get('article_categories_option') == 0)) ? $jdparams->get('article_categories_option') : 3;
			$excludesCategories = $jdparams->get('article_categories');
			$catid = $row->catid;
			// exclude/ include article
			$pageArticleOption = ($jdparams->get('articles_option') == 1 || ($jdparams->get('articles_option') != '' && $jdparams->get('articles_option') == 0)) ? $jdparams->get('articles_option') : 3;
			$excludesArticles = $jdparams->get('articles');

			if(!isset($excludesCategories))
				$excludesCategories = array();
			
			$aid = (isset($row->id)) ? $row->id : 0; 
			if($displayPage || (in_array($aid,$excludesArticles) && $pageArticleOption == 1)){
				if(
				(($pageCategoryOption == 0 && $pageArticleOption == 1) && (!empty($excludesArticles) && in_array($aid,$excludesArticles))) || 
				(($pageCategoryOption ==1) && (isset($excludesArticles) && !in_array($aid,$excludesArticles)) && (in_array($catid,$excludesCategories)))|| 
				($pageArticleOption == 3 && $pageCategoryOption == 3) || 
				(($pageArticleOption == 3 && $pageCategoryOption == 1) && (in_array($catid,$excludesCategories))) || 
				($pageArticleOption == 1 && (!empty($excludesArticles) && in_array($aid,$excludesArticles))) ||
				($pageCategoryOption == 0 && (!empty($excludesCategories) && !in_array($aid,$excludesArticles))) 
				){
					if(!empty($buttonPosition) && in_array('beforecontent',$buttonPosition)){
						$html = $this->Template($this->params,$row,false,$context);
						return $html;
					}
				}
			}
		}

		// com_k2
		if(isset($option)  && $option == 'com_k2'){		
			$k2pageTypeOption = ($jdparams->get('k2pagetype_option') == 1 || ($jdparams->get('k2pagetype_option') != '' && $jdparams->get('k2pagetype_option') == 0)) ? $jdparams->get('k2pagetype_option') : 3;
			$k2pagetype = $jdparams->get('k2pagetype'); 			
			$k2categories_option = ($jdparams->get('k2categories_option') == 1 || ($jdparams->get('k2categories_option') != '' && $jdparams->get('k2categories_option') == 0)) ? $jdparams->get('k2categories_option') : 3;
			$k2excludesCategories = $jdparams->get('k2categories');
			$k2itemOption = ($jdparams->get('items_option') == 1 || ($jdparams->get('items_option') != '' && $jdparams->get('items_option') == 0)) ? $jdparams->get('items_option') : 3;
			$excludesItems = $jdparams->get('k2items');
			$k2aid = (isset($row->id)) ? $row->id : '';
			$k2cid = (isset($row->catid)) ? $row->catid : '';
			$k2displayPage = false;
			$k2position = $jdparams->get('k2position');
			switch($k2pageTypeOption){
				case 0 :
					if(!empty($k2pagetype) && in_array($layout,$k2pagetype)){ 
						$k2displayPage = false; 
					}else{
						$k2displayPage = true; 
					}
				break;
				case 1 :
					if((!empty($k2pagetype) && in_array($layout,$k2pagetype))){
						$k2displayPage = true; 

					}else{
						$k2displayPage = false;
					}
				break;
				default :
					$k2displayPage = true;
			}

			if(!isset($k2excludesCategories))
				$k2excludesCategories = array();
				
			if(!isset($excludesItems))
				$excludesItems = array();
				
			if($k2displayPage || (in_array($k2aid,$excludesItems) && $pageArticleOption == 1)){
				if(!empty($k2position) && in_array('beforecontent',$k2position)){
					if(
					(($k2categories_option == 0 && $k2itemOption == 1) && (!empty($excludesItems) && in_array($k2aid,$excludesItems))) || 
					(($k2categories_option ==1) && (isset($excludesItems) && !in_array($k2aid,$excludesItems)) && (in_array($k2cid,$k2excludesCategories)))|| 
					($k2itemOption == 3 && $k2categories_option == 3) || 
					(($k2itemOption == 3 && $k2categories_option == 1) && (in_array($k2cid,$k2excludesCategories))) || 
					($k2itemOption == 1 && (!empty($excludesItems) && in_array($k2aid,$excludesItems))) ||
					($k2categories_option == 0 && (!empty($k2excludesCategories) && !in_array($k2aid,$excludesItems))) 
					){	
						$html = '';
						$incentive = $jdparams->get('incentive');
						if($incentive){
							$html .= '<div class="incentive">'.$jdparams->get('incentive').'</div>';
						}
						$html .= $this->Template($this->params,$row,false,$context);
						return $html;
					}
				} 
			} 
		}

		// com_easyblog
		if(isset($option)  && $option == 'com_easyblog'){		
			$ebpageTypeOption = ($jdparams->get('ebpagetype_option') == 1 || ($jdparams->get('ebpagetype_option') != '' && $jdparams->get('ebpagetype_option') == 0)) ? $jdparams->get('ebpagetype_option') : 3;
			$ebpagetype = $jdparams->get('ebpagetype'); 			

			$ebcategories_option = ($jdparams->get('ebcategories_option') == 1 || ($jdparams->get('ebcategories_option') != '' && $jdparams->get('ebcategories_option') == 0)) ? $jdparams->get('ebcategories_option') : 3;
			$ebcategories = $jdparams->get('ebcategories');

			$ebitemOption = ($jdparams->get('ebitems_option') == 1 || ($jdparams->get('ebitems_option') != '' && $jdparams->get('ebitems_option') == 0)) ? $jdparams->get('ebitems_option') : 3;

			$ebitems = $jdparams->get('ebitems');			
			$ebid = (isset($row->id)) ? $row->id : '';
			$ebcid = (isset($row->catid)) ? $row->catid : ''; 
			$ebdisplayPage = false;
			$ebposition = $jdparams->get('ebposition');
			
			switch($ebpageTypeOption){
				case 0 : 
					if(!empty($ebpagetype) && in_array($view,$ebpagetype)){ 
						$ebdisplayPage = false; 
					}else{				
						$ebdisplayPage = true; 
					}
				break;
				case 1 :
					if((!empty($ebpagetype) && in_array($view,$ebpagetype))){
						$ebdisplayPage = true; 

					}else{
						$ebdisplayPage = false; 
					}
				break;

				default :
					$ebdisplayPage = true; 
			}
			if(!isset($ebcategories))
				$ebcategories = array();

			if(!isset($ebitems))
				$ebitems = array();

			if($ebdisplayPage || (in_array($ebid,$ebitems) && $ebpageTypeOption == 1)){
				if(!empty($ebposition) && in_array('beforecontent',$ebposition)){
					if(
					(($ebcategories_option == 0 && $ebitemOption == 1) && (!empty($ebitems) && in_array($ebid,$ebitems))) || 
					(($ebcategories_option ==1) && (isset($ebitems) && !in_array($ebid,$ebitems)) && (in_array($ebcid,$ebcategories)))|| 
					($ebitemOption == 3 && $ebcategories_option == 3) || 
					(($ebitemOption == 3 && $ebcategories_option == 1) && (in_array($ebcid,$ebcategories))) || 
					($ebitemOption == 1 && (!empty($ebitems) && in_array($ebid,$ebitems))) ||
					($ebcategories_option == 0 && (!empty($ebcategories) && !in_array($ebcid,$ebcategories))) 
					){	
						$html = '';
						$incentive = $jdparams->get('incentive');
						if($incentive){
							$html .= '<div class="incentive">'.$jdparams->get('incentive').'</div>';
						}
						$html .= $this->Template($this->params,$row,false,$context);
						return $html;
					}
				} 
			} 
		}
    }

	public function onContentAfterDisplay($context, &$row, &$params, $page=0)
    {
		//echo $context;exit;
		$option	 	= JRequest::getVar('option');		
		$view 		= JRequest::getVar('view');	
		$layout 	= JRequest::getVar('layout');	
		$jdparams = $this->params;

		// com_content
		if(isset($option)  && $option == 'com_content'){
			$excludesPages = array();
			$articleType_ = explode('.',$context);
			$articleType = (isset($articleType_[1])) ? $articleType_[1] : '';			
			$buttonPosition = $jdparams->get('buttons_position');
			$pageTypeOption = ($jdparams->get('pagetype_option') == 1 || ($jdparams->get('pagetype_option') != '' && $jdparams->get('pagetype_option') == 0)) ? $jdparams->get('pagetype_option') : 3;
			$excludesPages = $jdparams->get('pagetype');  

			// page type condition 
			$displayPage = false;
			switch($pageTypeOption){
				case 0 : 
					if(!empty($excludesPages) && in_array($articleType,$excludesPages)){ 
						$displayPage = false; 
					}else{				
						$displayPage = true; 
					} 
				break;			
				case 1 : 
					if((!empty($excludesPages) && in_array($articleType,$excludesPages))){
						$displayPage = true; 					
					}else{			
						$displayPage = false; 
					}	
				break;
				
				default :  
					$displayPage = true; 
			}

			// exclude/ include for categories		
			$pageCategoryOption = ($jdparams->get('article_categories_option') == 1 || ($jdparams->get('article_categories_option') != '' && $jdparams->get('article_categories_option') == 0)) ? $jdparams->get('article_categories_option') : 3;
			$excludesCategories = $jdparams->get('article_categories');
			$catid = $row->catid;   
			// exclude/ include article
			$pageArticleOption = ($jdparams->get('articles_option') == 1 || ($jdparams->get('articles_option') != '' && $jdparams->get('articles_option') == 0)) ?$jdparams->get('articles_option') : 3;
			$excludesArticles = $jdparams->get('articles');

			if(!isset($excludesCategories))
				$excludesCategories = array();
			$aid = (isset($row->id)) ? $row->id : 0; 
			if($displayPage || (in_array($aid,$excludesArticles) && $pageArticleOption == 1)){
				if(
				(($pageCategoryOption == 0 && $pageArticleOption == 1) && (!empty($excludesArticles) && in_array($aid,$excludesArticles))) || 
				(($pageCategoryOption ==1) && (isset($excludesArticles) && !in_array($aid,$excludesArticles)) && (in_array($catid,$excludesCategories)))|| 
				($pageArticleOption == 3 && $pageCategoryOption == 3) || 
				(($pageArticleOption == 3 && $pageCategoryOption == 1) && (in_array($catid,$excludesCategories))) || 
				($pageArticleOption == 1 && (!empty($excludesArticles) && in_array($aid,$excludesArticles))) ||
				($pageCategoryOption == 0 && (!empty($excludesCategories) && !in_array($aid,$excludesArticles))) 
				){
					if(!empty($buttonPosition) && in_array('aftercontent',$buttonPosition)){
						$html = '';
						$incentive = $jdparams->get('incentive');
						if($incentive){
							$html .= '<div class="incentive">'.$jdparams->get('incentive').'</div>';
						}
						$html .= $this->Template($this->params,$row,false,$context);
						return $html;
					}
				} 
			}
		}

		// com_k2
		if(isset($option)  && $option == 'com_k2'){		
			$k2pageTypeOption = ($jdparams->get('k2pagetype_option') == 1 || ($jdparams->get('k2pagetype_option') != '' && $jdparams->get('k2pagetype_option') == 0)) ? $jdparams->get('k2pagetype_option') : 3;
			$k2pagetype = $jdparams->get('k2pagetype'); 			
			$k2categories_option = ($jdparams->get('k2categories_option') == 1 || ($jdparams->get('k2categories_option') != '' && $jdparams->get('k2categories_option') == 0)) ? $jdparams->get('k2categories_option') : 3;
			$k2excludesCategories = $jdparams->get('k2categories');
			$k2itemOption = ($jdparams->get('items_option') == 1 || ($jdparams->get('items_option') != '' && $jdparams->get('items_option') == 0)) ? $jdparams->get('items_option') : 3;
			$excludesItems = $jdparams->get('k2items');
			$k2aid = (isset($row->id)) ? $row->id : '';
			$k2cid = (isset($row->catid)) ? $row->catid : '';
			$k2displayPage = false;
			$k2position = $jdparams->get('k2position');
			switch($k2pageTypeOption){
				case 0 : 
					if(!empty($k2pagetype) && in_array($layout,$k2pagetype)){ 
						$k2displayPage = false; 
					}else{				
						$k2displayPage = true; 
					}
				break;
				case 1 :
					if((!empty($k2pagetype) && in_array($layout,$k2pagetype))){
						$k2displayPage = true; 
						
					}else{
						$k2displayPage = false; 
					}
				break;
				
				default :  
					$k2displayPage = true; 
			}
			if(!isset($k2excludesCategories))
				$k2excludesCategories = array();

			if(!isset($excludesItems))
				$excludesItems = array();
				
			if($k2displayPage || (in_array($k2aid,$excludesItems) && $k2pageTypeOption == 1)){
				if(!empty($k2position) && in_array('aftercontent',$k2position)){
					if(
					(($k2categories_option == 0 && $k2itemOption == 1) && (!empty($excludesItems) && in_array($k2aid,$excludesItems))) || 
					(($k2categories_option ==1) && (isset($excludesItems) && !in_array($k2aid,$excludesItems)) && (in_array($k2cid,$k2excludesCategories)))|| 
					($k2itemOption == 3 && $k2categories_option == 3) || 
					(($k2itemOption == 3 && $k2categories_option == 1) && (in_array($k2cid,$k2excludesCategories))) || 
					($k2itemOption == 1 && (!empty($excludesItems) && in_array($k2aid,$excludesItems))) ||
					($k2categories_option == 0 && (!empty($k2excludesCategories) && !in_array($k2aid,$excludesItems))) 
					){	
						$html = '';
						$incentive = $jdparams->get('incentive');
						if($incentive){
							$html .= '<div class="incentive">'.$jdparams->get('incentive').'</div>';
						}
						$html .= $this->Template($this->params,$row,false,$context);
						return $html;
					} 						 
				} 
			}
		}

		// com_easyblog		
		if(isset($option)  && $option == 'com_easyblog'){		
			$ebpageTypeOption = ($jdparams->get('ebpagetype_option') == 1 || ($jdparams->get('ebpagetype_option') != '' && $jdparams->get('ebpagetype_option') == 0)) ? $jdparams->get('ebpagetype_option') : 3;
			$ebpagetype = $jdparams->get('ebpagetype'); 			

			$ebcategories_option = ($jdparams->get('ebcategories_option') == 1 || ($jdparams->get('ebcategories_option') != '' && $jdparams->get('ebcategories_option') == 0)) ? $jdparams->get('ebcategories_option') : 3;
			$ebcategories = $jdparams->get('ebcategories');
			
			$ebitemOption = ($jdparams->get('ebitems_option') == 1 || ($jdparams->get('ebitems_option') != '' && $jdparams->get('ebitems_option') == 0)) ? $jdparams->get('ebitems_option') : 3;
			
			$ebitems = $jdparams->get('ebitems');			
			$ebid = (isset($row->id)) ? $row->id : '';
			$ebcid = (isset($row->catid)) ? $row->catid : ''; 
			$ebdisplayPage = false;
			$ebposition = $jdparams->get('ebposition');

			switch($ebpageTypeOption){
				case 0 : 
					if(!empty($ebpagetype) && in_array($view,$ebpagetype)){ 
						$ebdisplayPage = false;
					}else{				
						$ebdisplayPage = true;
					} 
				break;
				case 1 : 
					if((!empty($ebpagetype) && in_array($view,$ebpagetype))){
						$ebdisplayPage = true;
						
					}else{			
						$ebdisplayPage = false;
					}	
				break;
				
				default :  
					$ebdisplayPage = true;
			}
			
			if(!isset($ebcategories))
				$ebcategories = array();

			if(!isset($ebitems))
				$ebitems = array();

			if($ebdisplayPage || (in_array($ebid,$ebitems) && $ebpageTypeOption == 1)){
				if(!empty($ebposition) && in_array('aftercontent',$ebposition)){
					if(
					(($ebcategories_option == 0 && $ebitemOption == 1) && (!empty($ebitems) && in_array($ebid,$ebitems))) || 
					(($ebcategories_option ==1) && (isset($ebitems) && !in_array($ebid,$ebitems)) && (in_array($ebcid,$ebcategories)))|| 
					($ebitemOption == 3 && $ebcategories_option == 3) || 
					(($ebitemOption == 3 && $ebcategories_option == 1) && (in_array($ebcid,$ebcategories))) || 
					($ebitemOption == 1 && (!empty($ebitems) && in_array($ebid,$ebitems))) ||
					($ebcategories_option == 0 && (!empty($ebcategories) && !in_array($ebcid,$ebcategories))) 
					){	
						$html = '';
						$incentive = $jdparams->get('incentive');
						if($incentive){
							$html .= '<div class="incentive">'.$jdparams->get('incentive').'</div>';
						}
						$html .= $this->Template($this->params,$row,false,$context);
						return $html;
					}
				} 
			} 
		} 
    }

	protected function Template(&$params,$row, $trigger = false,$context){	
		require_once JPATH_BASE . '/components/com_content/helpers/route.php';
		$jdsocial = new Jdsocial;
		$app = JFactory::getApplication();
		$active = $app -> getMenu() -> getActive();
		$Itemid = JRequest::getVar( "Itemid" , "1" );
		$jdparams = $this->params;
		if ( $row->id ) {
				$link = JURI::getInstance();
				$root = $link->getScheme() . "://" . $link->getHost();
				if ( $active->component ) {
					if ( $active->component == 'com_content') {
						if ( $row->slug && (isset($row->catslug) && !empty($row->catslug)) ) {
							$link = JRoute::_( ContentHelperRoute::getArticleRoute( $row->slug , $row->catslug ) , false );
						} 
					}
				}
				if ($active->component == 'com_content') {
					$link = $root.$link;
				}else if($active->component == 'com_k2' || $active->component =='com_easyblog'){
					$link = $link->toString();
				}
		} else {
			$jURI = JURI::getInstance();
			$link = $jURI->toString();
		}
		if($jdparams->get('url_shorting') == 1){
			$shortlink = $this->getBitlyShortUrl($link); 
		}else{
			$shortlink = $this->getGooglShortUrl($link);
			//$shortlink = $link; 
		}
		
		$networks = $jdparams->get('networks');
		$html  = ''; 
		$buttonClass = ($jdparams->get('buttons_format') == 2) ? (($jdparams->get('botton_shape') != 'circle') ? 'button_'.$jdparams->get('botton_shape').' with_content' : 'button_'.$jdparams->get('botton_shape')) : 'button_'.$jdparams->get('botton_shape');
		$buttonAnimation = 'hover_'.$jdparams->get('button_animation');
		$html  .= '<div class="icon_container '.$buttonClass.' '.$buttonAnimation.'"><ul>';

		if(!empty($networks) && is_array(json_decode($networks))){
				foreach(json_decode($networks) as $network){
					$jdnetwork = (isset($network->network)) ? 'get'.ucfirst($network->network) : '';
					$jdlable   = (isset($network->label)) ? $network->label : '';
					$html  .= $jdsocial->$jdnetwork($row,$this->params,$shortlink,$jdlable);									
				}
				$html  .= '</ul></div>';	
			return $html;
		}else{
			return '';
		} 
	}
	function getBitlyShortUrl($url,$format = 'xml',$version = '2.0.1')
	{
		$user_login = $this->params->get('bitly_username');
		$user_access_token = $this->params->get('user_access_token');  
		
		if($user_access_token && $user_login){
			$bitly  =  new Bitly;
			$params = array();
			$params['access_token'] = $user_access_token;
			$params['longUrl'] = $url;
			$params['domain'] = 'bit.ly';			
			$results = $bitly->bitly_get('shorten', $params); 
			if(isset($results['status_code']) && $results['status_code'] == 200){
				return (isset($results['data']['url'])) ? $results['data']['url'] : $url;
			}else{
				return $url;
			}
		}else{
			return $url;
		}		
	}
	// get short url form Googl
	function getGooglShortUrl($longUrl) {		
		$google_key = $this->params->get('googl_key');
		if(isset($google_key) && $google_key){
			$googer = new GoogleURLAPI($google_key);
			$data = $googer->shorten($longUrl); 
			return (isset($data) && !empty($data)) ? $data : $longUrl;
		}else{
			return $longUrl;
		}
	}	
}