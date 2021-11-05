<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  Hdevrec
 *
 * @copyright   Copyright (C)  2018 Hogeh
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */


defined('_JEXEC') or die;
class HiotsModelHdevrec extends JModelAdmin
{
	

	protected function populateState()
	{
		$app = JFactory::getApplication();
		$return = $app->input->get('return', null, 'base64');
		if (!JUri::isInternal(base64_decode($return))){
			$return = null;
		}
		$this->setState('return_page', base64_decode($return));
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
			$query->from($db->quoteName('#__hiots_records').' AS a');
			$query->where('a.id='.(int)$pk);
			$db->setQuery($query);
			$item= $db->loadobject();
			$item->params=json_decode($item->params);
			return $item;
		} else {
			return parent::getitem($pk= null);
		}
	}
	
	
	public function getTable($type = 'Hdevrec', $prefix = 'HiotsTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	
	public function getForm($data = array(), $loadData = true)
	{
		$app = JFactory::getApplication();

		$form = $this->loadForm('com_hiots.hdevrec', 'hdevrec', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form))
		{
			return false;
		}

		return $form;
	}

	
	protected function loadFormData()
	{
		$data = JFactory::getApplication()->getUserState('com_hiots.edit.hdevrec.data', array());

		if (empty($data))
		{
			$data = $this->getItem();
		}
		return $data;
	}

	
	
	/**
	 * Method to increment the hit counter for the hdevrec
	 *
	 * @param   integer  $id  Optional ID of the hdevrec.
	 *
	 * @return  boolean  True on success
	 */

}
