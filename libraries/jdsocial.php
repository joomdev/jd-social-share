<?php
/**
 * @package		JD Social Share
 * @version		1.4
 * @author		JoomDev
 * @copyright	Copyright (C) 2008 - 2019 Joomdev.com. All rights reserved
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */
 
defined('_JEXEC') or die;

class Jdsocial { 
	public function getTwitter($row,$params,$shortlink,$jdlable){
		$handler = ($params->get('twitter_handler') != '') ? '&via='.$params->get('twitter_handler') : '' ;		
		$button_formate	 = ($params->get('buttons_format') == 2) ? "<span>$jdlable</span>" : '';
		$class	 = $params->get('botton_shape');
		$class  .= ($params->get('buttons_format') == 2) ? ($params->get('botton_shape') == "circle" ?  " icon" :  " texticon") : ' icon';
		return '<li>
					<a class="popup twitter '.$class.'" href="http://twitter.com/share?text='.$row->title.'&url='.$shortlink.$handler.'">
					'.(($params->get('botton_shape') != "circle" ? $button_formate : "")).'
					</a> 
				</li>'; 
	}

	public function getFacebook($row,$params,$shortlink,$jdlable){
		
	 	$button_formate	 = ($params->get('buttons_format') == 2) ? "<span>$jdlable</span>" : '';
		$class	 = $params->get('botton_shape');	
		$class  .= ($params->get('buttons_format') == 2) ? ($params->get('botton_shape') == "circle" ?  " icon" :  " texticon") : ' icon';	
		$title = (isset($row->title)) ? $row->title : '';
		$link = sprintf( 'http://www.facebook.com/sharer.php?u=%1$s&t=%2$s', $shortlink,$title);
		
		return '<li>
					<a class="popup facebook '.$class.'" href="'.$link.'">'.(($params->get('botton_shape') != "circle" ? $button_formate : "")).'
					</a> 
				</li>'; 
	}
	public function getBuffer($row,$params,$shortlink,$jdlable){
		 $button_formate	 = ($params->get('buttons_format') == 2) ? "<span>$jdlable</span>" : '';
		 $class	 = $params->get('botton_shape');
		 $class  .= ($params->get('buttons_format') == 2) ? ($params->get('botton_shape') == "circle" ?  " icon" :  " texticon") : ' icon';	
		 $title = (isset($row->title)) ? $row->title : '';
		 $link = sprintf( 'https://bufferapp.com/add?url=%1$s&title=%2$s',$shortlink,$title);
		return '<li>
					<a class="popup buffer '.$class.'" href="'.$link.'">'.(($params->get('botton_shape') != "circle" ? $button_formate : "")).'
					</a> 
				</li>'; 
	}

	public function getDigg($row,$params,$shortlink,$jdlable){
		$button_formate	 = ($params->get('buttons_format') == 2) ? "<span>$jdlable</span>" : '';
		$class	 = $params->get('botton_shape');
		$class  .= ($params->get('buttons_format') == 2) ? ($params->get('botton_shape') == "circle" ?  " icon" :  " texticon") : ' icon';	
		$title = (isset($row->title)) ? $row->title : '';
		$link = sprintf('http://digg.com/submit?url=%1$s&title=%2$s',$shortlink,$title); 
		return '<li>
					<a class="popup digg '.$class.'" href="'.$link.'">'.(($params->get('botton_shape') != "circle" ? $button_formate : "")).'
					</a> 
				</li>';  
	}
	
	public function getEvernote($row,$params,$shortlink,$jdlable){
		$button_formate	 = ($params->get('buttons_format') == 2) ? "<span>$jdlable</span>" : '';
		$class	 = $params->get('botton_shape');
		$class  .= ($params->get('buttons_format') == 2) ? ($params->get('botton_shape') == "circle" ?  " icon" :  " texticon") : ' icon';	
		$title = (isset($row->title)) ? $row->title : '';
		$link = sprintf('http://www.evernote.com/clip.action?url=%1$s&title=%2$s',$shortlink,$title);  
		return '<li>
				<a class="popup evernote '.$class.'" href="'.$link.'">'.(($params->get('botton_shape') != "circle" ? $button_formate : "")).'
					</a> 
			</li>'; 
	}

	public function getPinterest($row,$params,$shortlink,$jdlable){
		$button_formate	 = ($params->get('buttons_format') == 2) ? "<span>$jdlable</span>" : '';
		$class	 = $params->get('botton_shape');
		$class  .= ($params->get('buttons_format') == 2) ? ($params->get('botton_shape') == "circle" ?  " icon" :  " texticon") : ' icon';	
		$title = (isset($row->title)) ? $row->title : '';
		$link = sprintf('http://www.pinterest.com/pin/create/button/?url=%1$s&description=%2$s',$shortlink,$title);
		return '<li>
				<a href="'.$link.'" class="popup pinterest '.$class.'">'.(($params->get('botton_shape') != "circle" ? $button_formate : "")).'
					</a> 
			</li>'; 
	}

	public function getFriendfeed($row,$params,$shortlink,$jdlable){
		$button_formate	 = ($params->get('buttons_format') == 2) ? "<span>$jdlable</span>" : '';
		$class	 = $params->get('botton_shape');
		$class  .= ($params->get('buttons_format') == 2) ? ($params->get('botton_shape') == "circle" ?  " icon" :  " texticon") : ' icon';	
		$title = (isset($row->title)) ? $row->title : '';
		//$link = sprintf( 'http://www.printfriendly.com/print?url=%1$s&title=%2$s',$shortlink,$title);
		$link = sprintf('http://friendfeed.com/?url=%1$s',$shortlink);
		 return '<li>
				<a href="'.$link.'" class="popup friendfeed '.$class.'">'.(($params->get('botton_shape') != "circle" ? $button_formate : "")).'
					</a> 
			</li>'; 
	}

	public function getHackernews($row,$params,$shortlink,$jdlable){
		$button_formate	 = ($params->get('buttons_format') == 2) ? "<span>$jdlable</span>" : '';
		$class	 = $params->get('botton_shape');
		$class  .= ($params->get('buttons_format') == 2) ? ($params->get('botton_shape') == "circle" ?  " icon" :  " texticon") : ' icon';	
		$title = (isset($row->title)) ? $row->title : '';
		$link = sprintf( 'https://news.ycombinator.com/submitlink?u=%1$s&t=%2$s',$shortlink,$title);
		 return '<li>
				<a href="'.$link.'" class="popup hackernews '.$class.'">'.(($params->get('botton_shape') != "circle" ? $button_formate : "")).'
				</a> 
			</li>'; 
	}

	public function getLivejournal($row,$params,$shortlink,$jdlable){
		$button_formate	 = ($params->get('buttons_format') == 2) ? "<span>$jdlable</span>" : '';
		$class	 = $params->get('botton_shape');
		$class  .= ($params->get('buttons_format') == 2) ? ($params->get('botton_shape') == "circle" ?  " icon" :  " texticon") : ' icon';	
		$title = (isset($row->title)) ? $row->title : '';
		$link = sprintf( 'http://www.livejournal.com/update.bml?subject=%2$s&event=%1$s',$shortlink,$title);
		 return '<li>
				<a href="'.$link.'"  class="popup livejournal '.$class.'">'.(($params->get('botton_shape') != "circle" ? $button_formate : "")).'
					</a> 
			</li>'; 
	}

	public function getNewsvine($row,$params,$shortlink,$jdlable){
		$button_formate	 = ($params->get('buttons_format') == 2) ? "<span>$jdlable</span>" : '';
		$class	 = $params->get('botton_shape');
		$class  .= ($params->get('buttons_format') == 2) ? ($params->get('botton_shape') == "circle" ?  " icon" :  " texticon") : ' icon';	
		$title = (isset($row->title)) ? $row->title : '';
		$link = sprintf( 'http://www.newsvine.com/_tools/seed&save?u=%1$s&h=%2$s', $shortlink,$title);
		return '<li>
				<a href="'.$link.'" class="popup newsvine '.$class.'">'.(($params->get('botton_shape') != "circle" ? $button_formate : "")).'
					</a> 
			</li>'; 
	}

	public function getAol($row,$params,$shortlink,$jdlable){
		$button_formate	 = ($params->get('buttons_format') == 2) ? "<span>$jdlable</span>" : '';
		$class	 = $params->get('botton_shape');
		$class  .= ($params->get('buttons_format') == 2) ? ($params->get('botton_shape') == "circle" ?  " icon" :  " texticon") : ' icon';	
		$title = (isset($row->title)) ? $row->title : '';
		$link = sprintf( 'http://webmail.aol.com/Mail/ComposeMessage.aspx?subject=%2$s&body=%1$s',$shortlink,$title);
		return '<li>
				<a href="'.$link.'" class="popup aol '.$class.'">'.(($params->get('botton_shape') != "circle" ? $button_formate : "")).'
					</a> 
			</li>'; 
	}

	public function getGmail($row,$params,$shortlink,$jdlable){
		$button_formate	 = ($params->get('buttons_format') == 2) ? "<span>$jdlable</span>" : '';
		$class	 = $params->get('botton_shape');
		$class  .= ($params->get('buttons_format') == 2) ? ($params->get('botton_shape') == "circle" ?  " icon" :  " texticon") : ' icon';	
		$title = (isset($row->title)) ? $row->title : '';
		$link = sprintf( 'https://mail.google.com/mail/u/0/?view=cm&fs=1&su=%2$s&body=%1$s&ui=2&tf=1',$shortlink,$title);
		 return '<li>
				<a href="'.$link.'"  class="popup gmail '.$class.'">'.(($params->get('botton_shape') != "circle" ? $button_formate : "")).'
					</a> 
			</li>'; 
	}

	public function getPrintfriendly($row,$params,$shortlink,$jdlable){
		$button_formate	 = ($params->get('buttons_format') == 2) ? "<span>$jdlable</span>" : '';
		$class	 = $params->get('botton_shape');
		$class  .= ($params->get('buttons_format') == 2) ? ($params->get('botton_shape') == "circle" ?  " icon" :  " texticon") : ' icon';	
		$title = (isset($row->title)) ? $row->title : '';
		$link = sprintf( 'http://www.printfriendly.com/print?url=%1$s&title=%2$s',$shortlink,$title);
		 return '<li>
				<a href="'.$link.'" class="popup printfriendly '.$class.'">'.(($params->get('botton_shape') != "circle" ? $button_formate : "")).'
					</a> 
			</li>'; 
	}

	public function getYahoomail($row,$params,$shortlink,$jdlable){
		$button_formate	 = ($params->get('buttons_format') == 2) ? "<span>$jdlable</span>" : '';
		$class	 = $params->get('botton_shape');
		$class  .= ($params->get('buttons_format') == 2) ? ($params->get('botton_shape') == "circle" ?  " icon" :  " texticon") : ' icon';	
		$title = (isset($row->title)) ? $row->title : '';
		$link = sprintf('http://compose.mail.yahoo.com/?body=%1$s',$shortlink);
		 return '<li>
				<a href="'.$link .'" class="popup yahoomail '.$class.'">'.(($params->get('botton_shape') != "circle" ? $button_formate : "")).'
					</a> 
			</li>'; 
	}

	public function getAmazon($row,$params,$shortlink,$jdlable){
		$button_formate	 = ($params->get('buttons_format') == 2) ? "<span>$jdlable</span>" : '';
		$class	 = $params->get('botton_shape');
		$class  .= ($params->get('buttons_format') == 2) ? ($params->get('botton_shape') == "circle" ?  " icon" :  " texticon") : ' icon';	
		$title = (isset($row->title)) ? $row->title : '';
		$link = sprintf('http://www.amazon.com/gp/wishlist/static-add?u=%1$s&t=%2$s',$shortlink,$title);
		 return '<li>
				<a href="'.$link.'" class="popup amazon '.$class.'">'.(($params->get('botton_shape') != "circle" ? $button_formate : "")).'
					</a> 
			</li>'; 
	}

	public function getDelicious($row,$params,$shortlink,$jdlable){
		$button_formate	 = ($params->get('buttons_format') == 2) ? "<span>$jdlable</span>" : '';
		$class	 = $params->get('botton_shape');
		$class  .= ($params->get('buttons_format') == 2) ? ($params->get('botton_shape') == "circle" ?  " icon" :  " texticon") : ' icon';	
		$title = (isset($row->title)) ? $row->title : '';
		$link = sprintf( 'https://delicious.com/post?url=%1$s&title=%2$s',$shortlink,$title);
		 return '<li>
				<a href="'.$link.'" class="popup delicious '.$class.'">'.(($params->get('botton_shape') != "circle" ? $button_formate : "")).'
					</a> 
			</li>'; 
	}

	public function getReddit($row,$params,$shortlink,$jdlable){
		$button_formate	 = ($params->get('buttons_format') == 2) ? "<span>$jdlable</span>" : '';
		$class	 = $params->get('botton_shape');
		$class  .= ($params->get('buttons_format') == 2) ? ($params->get('botton_shape') == "circle" ?  " icon" :  " texticon") : ' icon';	
		$title = (isset($row->title)) ? $row->title : '';
		$link = sprintf( 'http://www.reddit.com/submit?url=%1$s&title=%2$s',$shortlink,$title);
		 return '<li>
				<a href="'.$link.'"  class="popup reddit '.$class.'">'.(($params->get('botton_shape') != "circle" ? $button_formate : "")).'
					</a> 
			</li>'; 
	}

	public function getVkontakte($row,$params,$shortlink,$jdlable){
		$button_formate	 = ($params->get('buttons_format') == 2) ? "<span>$jdlable</span>" : '';
		$class	 = $params->get('botton_shape');
		$class  .= ($params->get('buttons_format') == 2) ? ($params->get('botton_shape') == "circle" ?  " icon" :  " texticon") : ' icon';	
		$title = (isset($row->title)) ? $row->title : '';
		$link = sprintf( 'http://vk.com/share.php?url=%1$s',$shortlink);
		 return '<li>
				<a href="'.$link.'" class="popup vkontakte '.$class.'">'.(($params->get('botton_shape') != "circle" ? $button_formate : "")).'
					</a> 
			</li>'; 
	}	

	public function getLinkedin($row,$params,$shortlink,$jdlable){
		$button_formate	 = ($params->get('buttons_format') == 2) ? "<span>$jdlable</span>" : '';
		$class	 = $params->get('botton_shape');
		$class  .= ($params->get('buttons_format') == 2) ? ($params->get('botton_shape') == "circle" ?  " icon" :  " texticon") : ' icon';	
		$title = (isset($row->title)) ? $row->title : '';
		$link = sprintf('http://www.linkedin.com/shareArticle?mini=true&url=%1$s&title=%2$s',$shortlink,$title);
		
		 return '<li>
				<a href="'.$link.'" class="popup linkedin '.$class.'">'.(($params->get('botton_shape') != "circle" ? $button_formate : "")).'
					</a>
			</li>';
	}

	public function getMyspace($row,$params,$shortlink,$jdlable){
		$button_formate	 = ($params->get('buttons_format') == 2) ? "<span>$jdlable</span>" : '';
		$class	 = $params->get('botton_shape');
		$class  .= ($params->get('buttons_format') == 2) ? ($params->get('botton_shape') == "circle" ?  " icon" :  " texticon") : ' icon';	
		$title = (isset($row->title)) ? $row->title : '';
		$link = sprintf( 'https://myspace.com/post?u=%1$s', $shortlink);
		 return '<li>
				<a href="'.$link.'" class="popup myspace '.$class.'">'.(($params->get('botton_shape') != "circle" ? $button_formate : "")).'
					</a>
			</li>';
	}

	public function getBlogger($row,$params,$shortlink,$jdlable){
		$button_formate	 = ($params->get('buttons_format') == 2) ? "<span>$jdlable</span>" : '';
		$class	 = $params->get('botton_shape');
		$class  .= ($params->get('buttons_format') == 2) ? ($params->get('botton_shape') == "circle" ?  " icon" :  " texticon") : ' icon';	
		$title = (isset($row->title)) ? $row->title : '';
		$link = sprintf('https://www.blogger.com/blog_this.pyra?t&u=%1$s&n=%2$s',$shortlink,$title);
		 return '<li>
				<a href="'.$link.'" class="popup blogger '.$class.'">'.(($params->get('botton_shape') != "circle" ? $button_formate : "")).'
					</a>
			</li>';
	}

	public function getStumbleupon($row,$params,$shortlink,$jdlable){
		$button_formate	 = ($params->get('buttons_format') == 2) ? "<span>$jdlable</span>" : '';
		$class	 = $params->get('botton_shape');
		$class  .= ($params->get('buttons_format') == 2) ? ($params->get('botton_shape') == "circle" ?  " icon" :  " texticon") : ' icon';	
		$title = (isset($row->title)) ? $row->title : '';
		$link = sprintf('http://www.stumbleupon.com/badge?url=%1$s&title=%2$s', $shortlink,$title);
		 return '<li>
				<a href="'.$link.'" class="popup stumbleupon '.$class.'">'.(($params->get('botton_shape') != "circle" ? $button_formate : "")).'
					</a>
			</li>';
	}

	public function getTumblr($row,$params,$shortlink,$jdlable){
		$button_formate	 = ($params->get('buttons_format') == 2) ? "<span>$jdlable</span>" : '';
		$class	 = $params->get('botton_shape');
		$class  .= ($params->get('buttons_format') == 2) ? ($params->get('botton_shape') == "circle" ?  " icon" :  " texticon") : ' icon';	
		$title = (isset($row->title)) ? $row->title : '';
		$link = sprintf( 'http://www.tumblr.com/share?t=%1$s&u=%2$s',$row->title,$shortlink);
		 return '<li>
				<a href="'.$link.'" class="popup tumblr '.$class.'">'.(($params->get('botton_shape') != "circle" ? $button_formate : "")).'
					</a>
			</li>';
	}
	
	public function getWhatsapp($row,$params,$shortlink,$jdlable){
		
		$handler = ($params->get('twitter_handler') != '') ? '&via='.$params->get('twitter_handler') : '' ;		
		$button_formate	 = ($params->get('buttons_format') == 2) ? "<span>$jdlable</span>" : '';
		$class	 = $params->get('botton_shape');
		$class  .= ($params->get('buttons_format') == 2) ? ($params->get('botton_shape') == "circle" ?  " icon" :  " texticon") : ' icon';
		return '<li>
			<a class="popup whatsapp" href="https://api.whatsapp.com/send?text='.urlencode($row->title).' '.urlencode($shortlink).'">
			'.(($params->get('botton_shape') != "circle" ? $button_formate : "")).'
			</a>
		</li>';
	}

	public function getLike($row,$params,$shortlink,$jdlable){
		$button_formate	 = ($params->get('buttons_format') == 2) ? "<span>$jdlable</span>" : '';
		$class	 = $params->get('botton_shape');
		$class  .= ($params->get('buttons_format') == 2) ? ($params->get('botton_shape') == "circle" ?  " icon" :  " texticon") : ' icon';	
		
		 return '<li>
				<a href="javascript:void(0);" class="popup like '.$class.'">'.(($params->get('botton_shape') != "circle" ? $button_formate : "")).'
					</a>
			</li>';
	}
}
?>