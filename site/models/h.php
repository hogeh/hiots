<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  Hs
 *
 * @copyright   Copyright (C)  2018 Hogeh
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */


defined('_JEXEC') or die;
class HiotsModelH extends JModelAdmin
{
	


	public function get_iot_device($title,$token){
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);
		$query->select(	'a.*');
		$query->from($db->quoteName('#__hiots').' AS a');
		$query->where('a.title='.$db->quote($title));
		try{
			$db->setQuery($query);
			$item= $db->loadobject();
			$item->params=json_decode($item->params);
			if ($item->token==$token){
				$item->pass=true;
			}
			return $item;
		}catch (RuntimeException $e){
			//print_r($e);
			exit;
		}
	}


	public function get_iot_device_session($session_id){
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);
		$query->select(	'id,params,session_params')	;
		$query->from($db->quoteName('#__hbrewsessions').' AS a');
		$query->where('a.id='.(int)($session_id));
		$db->setQuery($query);
		$sessionitem= $db->loadobject();
		return $sessionitem;
	}
	
	public function store_latest_value_to_device($device,$data){
		$params=$this->merge_params($device->params,$data);
		$params=json_encode($params);
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);
		$query->update($db->quoteName('#__hiots').' AS a');
		$query->set($db->quoteName('params').'='.$db->quote($params));
		$query->set($db->quoteName('checked_out_time').'='. $db->quote(JFactory::getDate()->toSql()));
		$query->where('a.id='.(int)($device->id));
		$db->setQuery($query);
		$a1=$db->query();
		if ($a1) {
			return true;
		} else {
			$app->enqueueMessage('COM_HIOTS_DATABASE_ERROR', 'error');
    	    return false;
		}
	}
	
	
	public function merge_params($oldparams,$data){
		$obj_merged = (object) array_merge( 
        (array) $oldparams, (array) $data); 
 		return $obj_merged; 
	}

	public function store_detail_device_record($device,$data){
		$params=json_encode($data);
		if (!isset($device->type))$device->type=0;
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);
		$query->insert($db->quoteName('#__hiots_records'));
		$query->set($db->quoteName('s_id').'='.(int)($device->id));
		$query->set($db->quoteName('session_id').'='.(int)($device->params->current_session_id));
		$query->set($db->quoteName('iot_type').'='.(int)($device->type));
		$query->set($db->quoteName('tdate').'='. $db->quote(JFactory::getDate()->toSql()));
		$query->set($db->quoteName('params').'='.$db->quote($params));
		$db->setQuery($query);
		$a1=$db->query();
		if ($a1) {
			return true;
		}else {
			$app->enqueueMessage('COM_HIOTS_DATABASE_ERROR', 'error');
			return false;
		}
	}
	
	public function get_last_stored_record($id){
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);
		$query->select('tdate,params');
		$query->from($db->quoteName('#__hiots_records').' AS a');
		$query->where('s_id='.(int)$id);
		$query->ORDER('id DESC');
		$db->setQuery($query);
		$record= $db->loadobject();
		$params=json_decode($record->params);
		$params->tdate=$record->tdate;
		return $params;
	}
	
	public function saveautoparam($session_id,$sessionparams){
		$params=json_encode($sessionparams);
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);
		$query->update($db->quoteName('#__hbrewsessions').' AS a');
		$query->set($db->quoteName('session_params').'='.$db->quote($params));
		$query->where('a.id='.(int)($session_id));
		$db->setQuery($query);
		$a1=$db->query();
		if ($a1) 
		{
			return true;
		}else {
			$app->enqueueMessage('COM_HIOTS_DATABASE_ERROR', 'error');
			return false;
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
	
	public function getrecords($id,$session_id,$backviewdays=NULL)
	{
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);
		$query->select(
			$this->getState(
				'list.select','a.*')
		);
		$query->from($db->quoteName('#__hiots_records').' AS a');
		$query->where('s_id='.(int)$id);
		if ((int)$backviewdays){
			$anfdatback= new JDate();
			$anfdatback= date_modify($anfdatback, '-'.((int)$backviewdays).' day');
			$query->where('a.tdate >= "'.$anfdatback->format('Y-m-d H:i:s').'"');
		}		
		$query->where('session_id='.(int)$session_id);
		$db->setQuery($query);
		$records= $db->loadobjectlist();
		return $records;
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
	
	
	public function getminmaxavg($id,$session_id,$backviewdays=NULL)
	{
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);
		$query->select('min(tilt) as mini,max(tilt) as maxi,s_id,avg(TO_SECONDS(tdate)) as avgx,avg(tilt)as avgy,min(TO_SECONDS(tdate)) as minx,max(TO_SECONDS(tdate)) as maxx,session_id,min(tdate),max(tdate)');
		$query->from($db->quoteName('#__hiots_records').' AS a');
		$query->where('s_id='.(int)$id);
		$query->where('session_id='.(int)$session_id);
		if ($backviewdays){
			$anfdatback= new JDate();
			$anfdatback= date_modify($anfdatback, '-'.($backviewdays).' day');
			$query->where('a.tdate >= "'.$anfdatback->format('Y-m-d H:i:s').'"');
		}		
		$query->group('s_id,session_id');
		$db->setQuery($query);
		$records= $db->loadobject();
		return $records;
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


	public function getTable($type = 'H', $prefix = 'HiotsTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	
	public function getForm($data = array(), $loadData = true)
	{
		$app = JFactory::getApplication();
		$form = $this->loadForm('com_hiots.h', 'h', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form))
		{
			return false;
		}
		return $form;
	}

	
	protected function loadFormData()
	{
		$data = JFactory::getApplication()->getUserState('com_hiots.edit.h.data', array());
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
	
	
	/**
	 * Method to increment the hit counter for the h
	 *
	 * @param   integer  $id  Optional ID of the h.
	 *
	 * @return  boolean  True on success
	 */

	public function hit($id = null)
	{
		if (empty($id))
		{
			$id = $this->getState('h.id');
		}
		return $this->getTable('H', 'HiotsTable')->hit($id);
	}
}
