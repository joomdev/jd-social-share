<?php
/**
 * @package	JD Social Share
 * @version	1.0
 * @author	joomdev.com
 * @copyright	Copyright (C) 2008 - 2018 Joomdev.com. All rights reserved
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_PLATFORM') or die;
class JFormFieldArticles extends JFormField
{
    protected $type = 'articles'; 

    protected function getInput()
	{
		$value = $this->value;
		if(!is_array($value))
		$value = array();
		
		$db    =  JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('*');
		$query->from($db->quoteName('#__content'));
		$query->where($db->quoteName('state') . ' = 1');
		$query->order('ordering ASC');
		$db->setQuery($query);
		$rows = $db->loadObjectList();
		$options = '';
		$options .= '<select id="'.$this->id.'" name="'.$this->name.'" multiple="multiple" >';
		foreach($rows as $row){
				$selected = (in_array($row->id,$value)) ? 'selected="selected"' : '';
                $options .= '<option '.$selected.' value="'.$row->id.'" >'.$row->title.'</option>';
         }
		$options .= '</select>';	
		return $options; 
	} 
}