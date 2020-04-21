<?php
/**
 * @package		JD Social Share
 * @version		1.5
 * @author		JoomDev
 * @copyright	Copyright (C) 2008 - 2020 Joomdev.com. All rights reserved
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
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
		$task 	= JRequest::getVar('task');
		$jdparams = $this->params;
		// com_content
		if(isset($option) && $option == 'com_content'){
		
			$excludesPages = array();
			$articleType_ = explode('.',$context);
			$articleType = (isset($articleType_[1])) ? $articleType_[1] : '';
			$buttonPosition = $jdparams->get('buttons_position');
			$pageTypeOption = ($jdparams->get('pagetype_option') == 1 || ($jdparams->get('pagetype_option') != '' && $jdparams->get('pagetype_option') == 0)) ? $jdparams->get('pagetype_option') : 3;
			$excludesPages = $jdparams->get('pagetype');

			// exclude/ include for categories		
			$pageCategoryOption = ($jdparams->get('article_categories_option') == 1 || ($jdparams->get('article_categories_option') != '' && $jdparams->get('article_categories_option') == 0)) ? $jdparams->get('article_categories_option') : 3;
			$excludesCategories = $jdparams->get('article_categories');
			$catid = $row->catid;

			// exclude/ include article
			$pageArticleOption = ($jdparams->get('articles_option') == 1 || ($jdparams->get('articles_option') != '' && $jdparams->get('articles_option') == 0)) ? $jdparams->get('articles_option') : 3;
			$excludesArticles = $jdparams->get('articles');
			$aid = (isset($row->id)) ? $row->id : 0; 
			$contentDisplay = $this->GetDisplayValue($articleType,$pageTypeOption ,$excludesPages,$pageCategoryOption,$excludesCategories,$pageArticleOption,$excludesArticles,$aid,$catid);
			if($contentDisplay){
					if(!empty($buttonPosition) && in_array('beforecontent',$buttonPosition)){
						$html = $this->Template($this->params,$row,false,$context);
						return $html;
					}
			}
		}

		// com_k2
		if(isset($option) && $option == 'com_k2'){		
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
			 
			if($view == 'item'){
				$layout = 'item';
			}
		
			$k2displayPage = $this->GetDisplayValue($layout,$k2pageTypeOption,$k2pagetype,$k2categories_option,$k2excludesCategories,$k2itemOption,$excludesItems ,$k2aid,$k2cid);
			if($k2displayPage){
				if(!empty($k2position) && in_array('beforecontent',$k2position)){
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

		// com_easyblog
		if(isset($option) && $option == 'com_easyblog'){		
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
			
			$ebdisplayPage = $this->GetDisplayValue( $view ,$ebpageTypeOption,$ebpagetype,$ebcategories_option,$ebcategories,$ebitemOption,$ebitems ,$ebid,$ebcid);
			
			if($ebdisplayPage) {
				if(!empty($ebposition) && in_array('beforecontent',$ebposition)){
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

	public function onContentAfterDisplay($context, &$row, &$params, $page=0)
	{
		//echo $context;exit;
		$option	 	= JRequest::getVar('option');		
		$view 		= JRequest::getVar('view');	
		$layout 	= JRequest::getVar('layout');	
		$jdparams = $this->params;

		// com_content
		if(isset($option) && $option == 'com_content'){
		//echo $context;exit;
		$option	 	= JRequest::getVar('option');		
		$view 		= JRequest::getVar('view');	
		$layout 	= JRequest::getVar('layout');	
		$jdparams = $this->params;

		// com_content
	
			$excludesPages = array();
			$articleType_ = explode('.',$context);
			$articleType = (isset($articleType_[1])) ? $articleType_[1] : '';			
			$buttonPosition = $jdparams->get('buttons_position');
			$pageTypeOption = ($jdparams->get('pagetype_option') == 1 || ($jdparams->get('pagetype_option') != '' && $jdparams->get('pagetype_option') == 0)) ? $jdparams->get('pagetype_option') : 3;
			$excludesPages = $jdparams->get('pagetype');

			$pageCategoryOption = ($jdparams->get('article_categories_option') == 1 || ($jdparams->get('article_categories_option') != '' && $jdparams->get('article_categories_option') == 0)) ? $jdparams->get('article_categories_option') : 3;
			$excludesCategories = $jdparams->get('article_categories');
			$catid = $row->catid;
			// exclude/ include article
			$pageArticleOption = ($jdparams->get('articles_option') == 1 || ($jdparams->get('articles_option') != '' && $jdparams->get('articles_option') == 0)) ?$jdparams->get('articles_option') : 3;
			$excludesArticles = $jdparams->get('articles');

			$aid = (isset($row->id)) ? $row->id : 0; 
			$contentDisplay = $this->GetDisplayValue($articleType,$pageTypeOption ,$excludesPages,$pageCategoryOption,$excludesCategories,$pageArticleOption,$excludesArticles ,$aid,$catid);
			if($contentDisplay){
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

		// com_k2
		if(isset($option) && $option == 'com_k2'){	
		
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
			if($view == 'item'){
				$layout = 'item';
			}
			
			$k2displayPage = $this->GetDisplayValue($layout,$k2pageTypeOption,$k2pagetype,$k2categories_option,$k2excludesCategories,$k2itemOption,$excludesItems ,$k2aid,$k2cid);	
			if($k2displayPage){
				if(!empty($k2position) && in_array('aftercontent',$k2position)){
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

		// com_easyblog		
		if(isset($option) && $option == 'com_easyblog'){		
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
			
			$ebdisplayPage = $this->GetDisplayValue($view,$ebpageTypeOption,$ebpagetype,$ebcategories_option,$ebcategories,$ebitemOption,$ebitems ,$ebid,$ebcid);
			
			if($ebdisplayPage) {
				if(!empty($ebposition) && in_array('beforecontent',$ebposition)){
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

	/*
	* FUNCTION CREATED FOR DISPLAY OF ICONS ON PAGES BASED ON SELECTION IN BACKEND
	*	
	*/
	
	function GetDisplayValue($VIEW_PAGE,$PAGE_TYPE_OPTION,$PAGE_TYPE,$CATEGORY_OPTION,$CATEGORIES,$ITEM_OPTION,$ITEMS ,$ITEM_ID,$CATEGORY_ID){
				
				// PAGE TYPE SELECTION
				switch($PAGE_TYPE_OPTION){
						case 0 : 
							if(!empty($PAGE_TYPE) && in_array($VIEW_PAGE,$PAGE_TYPE)){
								$ebdisplayPage1 = 0;
							}else{				
								$ebdisplayPage1 = 1;
							} 
						break;
						case 1 :
							if((!empty($PAGE_TYPE) && in_array($VIEW_PAGE,$PAGE_TYPE))){
								$ebdisplayPage1 = 1;
								
							}else{			
								$ebdisplayPage1 = 0;
							}	
						break;
						
						default :
							$ebdisplayPage1 = 0;
					}
				// CATEGORY SELECTION	
					switch($CATEGORY_OPTION){
						case 0 :
							if(!empty($CATEGORY_ID) && in_array($CATEGORY_ID,$CATEGORIES)){
								$ebdisplayPage2 = 0;
							}else{				
								$ebdisplayPage2 = 1;
							} 
						break;
						case 1 :
							if((!empty($CATEGORY_ID) && in_array($CATEGORY_ID,$CATEGORIES))){
								$ebdisplayPage2 = 1;
								
							}else{			
								$ebdisplayPage2 = 0;
							}	
						break;
						
						default :
							$ebdisplayPage2 = 0;
						}
						
					// ITEM SELECTION
					switch($ITEM_OPTION){
					case 0 :
						if(!empty($ITEM_ID) && in_array($ITEM_ID,$ITEMS)){
							$ebdisplayPage3 = 0;
						}else{				
							$ebdisplayPage3 = 1;
						} 
					break;
					case 1 :
						if((!empty($ITEM_ID) && in_array($ITEM_ID,$ITEMS))){
							$ebdisplayPage3 = 1;
							
						}else{			
							$ebdisplayPage3 = 0;
						}	
					break;
					
					default :
						$ebdisplayPage3 = 0;
					}
								
					//echo $ebdisplayPage1 .' '. $ebdisplayPage2 .' '. $ebdisplayPage3;
					return $ebdisplayPage1 || $ebdisplayPage2 || $ebdisplayPage3;
				
	}
	/* 
	* FUNCTION CREATES THE ICONS TEMPLATE DISPLAYED ON FRONTEND 
	*
	*/
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
		$html = ''; 
		$buttonClass = ($jdparams->get('buttons_format') == 2) ? (($jdparams->get('botton_shape') != 'circle') ? 'button_'.$jdparams->get('botton_shape').' with_content' : 'button_'.$jdparams->get('botton_shape')) : 'button_'.$jdparams->get('botton_shape');
		$buttonAnimation = 'hover_'.$jdparams->get('button_animation');
		$html .= '<div class="jd-social-share icon_container '.$buttonClass.' '.$buttonAnimation.'"><ul>';

		if(!empty($networks) && is_array(json_decode($networks))){
				foreach(json_decode($networks) as $network){
					$jdnetwork = (isset($network->network)) ? 'get'.ucfirst($network->network) : '';
					$jdlable = (isset($network->label)) ? $network->label : '';
					$html .= $jdsocial->$jdnetwork($row,$this->params,$shortlink,$jdlable);									
				}
				$html .= '</ul></div>';	
			return $html;
		}else{
			return '';
		}
	}
	
	/* ******************************************************************** */
	
	
	/*
	* FUNCTION TO CREATE SORT LINK FOR TEH LINK PASSED . 
	* USING THE BITLY URL SORNING API .
	*/
		
	function getBitlyShortUrl($url,$format = 'xml',$version = '2.0.1')
	{
		$user_login = $this->params->get('bitly_username');
		$user_access_token = $this->params->get('user_access_token');
		
		if($user_access_token && $user_login){
			$bitly = new Bitly;
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
	
	/* ***************************************************************** */
	
	 /* 
	 * FUNCTION TO CREATE SORT LINK FOR THE LINK PASSED .
	 * USING GOOGLE API FOR URL SORTNING . 	
	 */
	 
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
	/* ************************************************** ***************/
}