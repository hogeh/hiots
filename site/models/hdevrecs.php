<?php
/**
 * @copyright	Copyright (C) 2016 Horst Gehrmann. All rights reserved.
 * @copyright	Copyright (C) 2005 - 2016 Open Source Matters,  Inc. All right reserved
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

class HiotsModelHdevrecs extends JModelList
{
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				'id', 'a.id',
				's_id', 'a.s_id',
				'session_id', 'a.session_id',
				'tdate', 'a.tdate',
			);
		}
		parent::__construct($config);
	}


	protected function populateState($ordering = null, $direction = null)
	{
		$app = JFactory::getApplication();
		$limit = $app->getUserStateFromRequest($this->option.'list.limit', 'limit', 0, 'uint');
		$this->setState('list.limit', $limit);
		$limitstart = $app->input->get('limitstart', 0, 'uint');
		$this->setState('list.start', $limitstart);
		$search = $this->getUserStateFromRequest($this->context.'.filter.search', 'filter-search');
		$this->setState('filter.search', $search);
		parent::populateState('a.tdate', 'desc');
	}



	public function getDevice()
	{
		$app = JFactory::getApplication();
		$s_id= $app->input->getInt('s_id');
		if ($s_id){
			$db		= JFactory::getDbo();
			$query	= $db->getQuery(true);
			$query->select(
				$this->getState(
					'list.select','a.*')
			);
			$query->from($db->quoteName('#__hiots').' AS a');
			$query->where('a.id='.(int)$s_id);
			$db->setQuery($query);
			$item= $db->loadobject();
			$item->params=json_decode($item->params);
			return $item;
		} else {
			return null;
		}
	}

	public function delete_devrecs($out){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->update($db->quoteName('#__hiots_records')); 
		$query->set('state=-2');
		$query->where('(id IN ('.$out.'))');
		try{
			$db->setQuery($query);
			$db->query();
			return JText::_('COM_HIOTS_RECORDS_DELETED');
		}catch (RuntimeException $e){
			return JText::_('COM_HIOTS_DATABASE_ERROR');
		}
		
	}


	public function delete_alldevrecs($s_id,$session_id){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->update($db->quoteName('#__hiots_records')); 
		$query->set('state=-2');
		$query->where('s_id='.$s_id);
		$query->where('session_id='.$session_id);
		try{
			$db->setQuery($query);
			$db->query();
			return JText::_('COM_HIOTS_RECORDS_DELETED');
		}catch (RuntimeException $e){
			return JText::_('COM_HIOTS_DATABASE_ERROR'.$e);
		}
		
	}
 
 protected function getListQuery()
	{
		$app = JFactory::getApplication();
		$s_id= $app->input->getInt('s_id');
		$session_id= $app->input->getInt('session_id');
		$myrecords=JRequest::getInt('myrecords');
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);
		$query->select('*');
		$query->from($db->quoteName('#__hiots_records').' AS a');
		$query->where('a.s_id='.(int)$s_id);
		$query->where('a.state=1');
		$query->where('a.session_id='.(int)$session_id);
		$search = $this->getState('filter.search');
		if (!empty($search))
		{
			$search = $db->Quote('%'.$db->escape($search, true).'%');
			$query->where('(a.params LIKE '.$search.')');
		}
		$orderCol	= $this->state->get('list.ordering');
		$orderDirn	= $this->state->get('list.direction');
		if ($orderCol == 'a.ordering')
		{
			$orderCol = 'a.modified '.$orderDirn.', a.ordering';
		}
		$query->order($db->escape($orderCol.' '.$orderDirn));
		return $query;
	}
	
}