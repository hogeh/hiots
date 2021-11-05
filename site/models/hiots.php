<?php
/**
 * @copyright	Copyright (C) 2016 Horst Gehrmann. All rights reserved.
 * @copyright	Copyright (C) 2005 - 2016 Open Source Matters,  Inc. All right reserved
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

class HiotsModelHiots extends JModelList
{
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				'id', 'a.id',
				'title', 'a.title',
				'modified','a.modified',
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
		parent::populateState('a.id', 'desc');
	}


	protected function getListQuery()
	{
		$myrecords=JRequest::getInt('myrecords');
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);
		$query->select('a.*');
		$query->from($db->quoteName('#__hiots').' AS a');
		$query->where('a.state<>-2');
		$search = $this->getState('filter.search');
		if ($myrecords)
		{
			$user = JFactory::getUser();
			$query->where('created_by = '.$db->quote($user->id));
		}
		if (!empty($search))
		{
			$search = $db->Quote('%'.$db->escape($search, true).'%');
			$query->where('(a.title LIKE '.$search.')');
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
	
	public function getDetails($s_id,$session_id=NULL) {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('b.session_id, b.s_id,count(b.id) as counti, max(b.tdate) as maxdate');
		$query->From('#__hiots_records AS b');
		$query->group('b.session_id, b.s_id');
		$query->where('state=1');
		$query->where('s_id = '.(int)$s_id);
		$query->where('session_id = '.(int)$session_id);
		try{
			$db->setQuery($query);
			$item=$db->loadObject();
			return $item; 
		}catch (RuntimeException $e){
			JFactory::getApplication()->enqueueMessage(JText::_('COM_HIOTS_DATABASE_ERROR'));
			return false;
		}
	}

}