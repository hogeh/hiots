<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  Hdevrecs
 *
 * @copyright   Copyright (C)  2018 Hogeh
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\Registry\Registry;

/**
 * Hdevrecs model.
 *
 * @since  1.5
 */
class HiotsModelHdevrec extends JModelAdmin
{
	public function getTable($type = 'Hdevrec', $prefix = 'HiotsTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	 * Abstract method for getting the form from the model.
	 *
	 * @param   array    $data      Data for the form.
	 * @param   boolean  $loadData  True if the form is to load its own data (default case), false if not.
	 *
	 * @return  mixed  A JForm object on success, false on failure
	 *
	 * @since   1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_hiots.hdevrec', 'hdevrec', array('control' => 'jform', 'load_data' => $loadData));

		if (empty($form))
		{
			return false;
		}

		return $form;
	}

	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return  array  The default data is an empty array.
	 *
	 * @since   1.6
	 */
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_hiots.edit.hdevrec.data', array());

		if (empty($data))
		{
			$data = $this->getItem();

			// Prime some default values.
			if ($this->getState('hdevrec.id') == 0)
			{
				$app = JFactory::getApplication();
				$data->set('catid', $app->input->get('catid', $app->getUserState('com_hiots.hdevrecs.filter.category_id'), 'int'));
			}
		}

		$this->preprocessData('com_hiots.hdevrec', $data);

		return $data;
	}


	
}
