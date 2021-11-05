<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  Hiot
 *
 * @copyright   Copyright (C)  2018 Hogeh
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */


defined('_JEXEC') or die;
class HiotsModelHiot extends JModelAdmin
{
	

	protected function populateState()
	{
		$app = JFactory::getApplication();
		$params = $app->getParams();

		// Load the object state.
		$id = $app->input->getInt('id');
		$this->setState('hiot.id', $id);
		$this->setState('params', $params);
		$return = $app->input->get('return', null, 'base64');
		if (!JUri::isInternal(base64_decode($return))){
			$return = null;
		}
		$this->setState('return_page', base64_decode($return));
		$backdays = $app->getUserStateFromRequest('filter.backdays', 'filter-backdays',356);
		$this->setState('filter.backdays', $backdays);
		parent::populateState();
	}

	
	protected function canDelete($record)
	{
		if (!empty($record->id))
		{
			if ($record->state != -2)
			{
				return;
			}
			$user = JFactory::getUser();

			if ($record->catid)
			{
				return $user->authorise('core.delete', 'com_hiots.category.'.(int) $record->catid);
			}
			else
			{
				return parent::canDelete($record);
			}
		}
	}

	protected function canEditState($record)
	{
		$user = JFactory::getUser();

		if (!empty($record->catid))
		{
			return $user->authorise('core.edit.state', 'com_hiots.category.'.(int) $record->catid);
		}
		else
		{
			return parent::canEditState($record);
		}
	}

	
	
	public function getItem($pk = null)
	{
		$pk = (!empty($pk)) ? $pk : (int) $this->getState($this->getName() . '.id');
		if ($pk){
			$db		= JFactory::getDbo();
			$query	= $db->getQuery(true);
			$query->select(
				$this->getState(
					'list.select','a.*')
			);
			$query->from($db->quoteName('#__hiots').' AS a');
			$query->select('c.title AS category_title')
				->join('LEFT', '#__categories AS c ON c.id = a.catid');
			$query->where('a.id='.(int)$pk);
			$db->setQuery($query);
			$item= $db->loadobject();
			$item->params=json_decode($item->params);
			return $item;
		} else {
			return parent::getitem($pk= null);
		}
	}
	
/*	public function update()
	{
		//		UPDATE `f5s34_hiots_iot_records` SET `params`= concat('{"temperature":',`temp`,',"tilt":',`tilt`,',"is_gravity":',`is_gravity`,',"calc_gravity":',`calc_gravity`,'}') 
	}



	public function getlastrecorddate($id)
	{
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);
		$query->select(	'max(a.tdate)');
		$query->from($db->quoteName('#__hiots_records').' AS a');
		$query->where('s_id='.(int)$id);
		$db->setQuery($query);
		$recorddate= $db->loadresult();
		return $recorddate;
	}
	
	

	
	public function clearspindel($id)
	{
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);
		$query->delete($db->quoteName('#__hiots_records'));
		$query->where('s_id='.(int)$id);
		$query->where('session_id=0');
		try{
			$db->setQuery($query);
			$db->execute();
			return true;
		}catch (RuntimeException $e){
			JFactory::getApplication()->enqueueMessage(JText::_('COM_HIOTS_DATABASE_ERROR'.$e));
			return false;
		}
	}
	
	
	public function deletespindelrecord($id)
	{
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);
		$query->delete($db->quoteName('#__hiots_records'));
		$query->where('id='.(int)$id);
		try{
			$db->setQuery($query);
			$db->execute();
			return true;
		}catch (RuntimeException $e){
			JFactory::getApplication()->enqueueMessage(JText::_('COM_HIOTS_DATABASE_ERROR'.$e));
			return false;
		}
	}

*/	
	public function getTable($type = 'Hiot', $prefix = 'HiotsTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	
	public function getForm($data = array(), $loadData = true)
	{
		$app = JFactory::getApplication();

		$form = $this->loadForm('com_hiots.hiot', 'hiot', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form))
		{
			return false;
		}

		return $form;
	}

	
	protected function loadFormData()
	{
		$data = JFactory::getApplication()->getUserState('com_hiots.edit.hiot.data', array());

		if (empty($data))
		{
			$data = $this->getItem();
		}
		return $data;
	}

	protected function prepareTable($table)
	{
		$user	= JFactory::getUser();
		$table->created_by		= $user->id;
	}
	
	


	public function updatesession($id,$iot_type,$session_id,$iotparams)
	{
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);
		$query->select('session_params');
		$query->from($db->quoteName('#__hbrewsessions'));
		$query->where('id='.(int)$session_id);
		try{
			$db->setQuery($query);
			$params= $db->loadresult();
		}catch (RuntimeException $e){
			JFactory::getApplication()->enqueueMessage(JText::_('COM_HIOTS_DATABASE_ERROR'.$e));
		}
		$params=json_decode($params,1);
		$params['l_iot'.$iot_type.'id']=(int)$id;
		$params['l_iot'.$iot_type.'params']=json_encode($iotparams);
		$params=json_encode($params);
		$query	= $db->getQuery(true);
		$query->update($db->quoteName('#__hbrewsessions'));
		$query->where('id='.(int)$session_id);
		$query->set('session_params='.$db->quote($params));
		try{
			$db->setQuery($query);
			$db->execute();
			return true;
		}catch (RuntimeException $e){
			JFactory::getApplication()->enqueueMessage(JText::_('COM_HIOTS_DATABASE_ERROR'));
			return false;
		}
	}

	/**
	 * Method to increment the hit counter for the hiot
	 *
	 * @param   integer  $id  Optional ID of the hiot.
	 *
	 * @return  boolean  True on success
	 */

	public function hit($id = null)
	{
		if (empty($id))
		{
			$id = $this->getState('hiot.id');
		}

		return $this->getTable('Hiot', 'HiotsTable')->hit($id);
	}
}
