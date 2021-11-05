<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  Hdevrec
 *
 * @copyright   Copyright (C)  2018 Hogeh
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\Utilities\ArrayHelper;

/**
 * Hdevrec class.
 *
 * @since  1.5
 */
class HiotsControllerHdevrec extends JControllerForm
{
	/**
	 * The URL view item variable.
	 *
	 * @var    string
	 * @since  1.6
	 */
	protected $view_item = 'hdevrec';

	/**
	 * The URL view list variable.
	 *
	 * @var    string
	 * @since  1.6
	 */
	protected $view_list = 'categories';

	/**
	 * The URL edit variable.
	 *
	 * @var    string
	 * @since  3.2
	 */
	protected $cVar = 'a.id';

	/**
	 * Method to add a new record.
	 *
	 * @return  boolean  True if the article can be added, false if not.
	 *
	 * @since   1.6
	 */
	public function add()
	{
		if (!parent::add())
		{
			// Redirect to the return page.
			$this->setRedirect($this->getReturnPage());
		}
	}

	/**
	 * Method override to check if you can add a new record.
	 *
	 * @param   array  $data  An array of input data.
	 *
	 * @return  boolean
	 *
	 * @since   1.6
	 */
	protected function allowAdd($data = array())
	{
		$categoryId = ArrayHelper::getValue($data, 'catid', $this->input->getInt('id'), 'int');
		$allow      = null;

		if ($categoryId)
		{
			// If the category has been passed in the URL check it.
			$allow = JFactory::getUser()->authorise('core.create', $this->option . '.category.' . $categoryId);
		}

		if ($allow !== null)
		{
			return $allow;
		}

		// In the absense of better information, revert to the component permissions.
		return parent::allowAdd($data);
	}

	/**
	 * Method to check if you can add a new record.
	 *
	 * @param   array   $data  An array of input data.
	 * @param   string  $key   The name of the key for the primary key.
	 *
	 * @return  boolean
	 *
	 * @since   1.6
	 */
	protected function allowEdit($data = array(), $key = 'id')
	{
		$recordId   = (int) isset($data[$key]) ? $data[$key] : 0;
		$categoryId = 0;

		if ($recordId)
		{
			$categoryId = (int) $this->getModel()->getItem($recordId)->catid;
		}

		if ($categoryId)
		{
			// The category has been set. Check the category permissions.
			return JFactory::getUser()->authorise('core.edit', $this->option . '.category.' . $categoryId);
		}

		// Since there is no asset tracking, revert to the component permissions.
		return parent::allowEdit($data, $key);
	}

	/**
	 * Method to cancel an edit.
	 *
	 * @param   string  $key  The name of the primary key of the URL variable.
	 *
	 * @return  boolean  True if access level checks pass, false otherwise.
	 *
	 * @since   1.6
	 */
	public function cancel($key = 'id')
	{
		$return = parent::cancel($key);
		// Redirect to the return page.
		$this->setRedirect($this->getReturnPage());
		return $return;
	}

	/**
	 * Method to edit an existing record.
	 *
	 * @param   string  $key     The name of the primary key of the URL variable.
	 * @param   string  $cVar  The name of the URL variable if different from the primary key (sometimes required to avoid router collisions).
	 *
	 * @return  boolean  True if access level check and checkout passes, false otherwise.
	 *
	 * @since   1.6
	 */
	public function edit($key = null, $cVar = 'id')
	{
		return parent::edit($key, $cVar);
	}

	/**
	 * Method to get a model object, loading it if required.
	 *
	 * @param   string  $name    The model name. Optional.
	 * @param   string  $prefix  The class prefix. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
	 *
	 * @return  object  The model.
	 *
	 * @since   1.5
	 */
	public function getModel($name = 'hdevrec', $prefix = '', $config = array('ignore_request' => true))
	{
		return parent::getModel($name, $prefix, $config);
	}
	



	/**
	 * Gets the URL arguments to append to an item redirect.
	 *
	 * @param   integer  $recordId  The primary key id for the item.
	 * @param   string   $cVar    The name of the URL variable for the id.
	 *
	 * @return  string  The arguments to append to the redirect URL.
	 *
	 * @since   1.6
	 */
	protected function getRedirectToItemAppend($recordId = null, $cVar = null)
	{
		$append = parent::getRedirectToItemAppend($recordId, $cVar);
		$itemId = $this->input->getInt('Itemid');
		$return = $this->getReturnPage();
		if ($itemId)
		{
			$append .= '&Itemid=' . $itemId;
		}

		if ($return)
		{
			$append .= '&return=' . base64_encode($return);
		}
		return $append;
	}

	/**
	 * Get the return URL if a "return" variable has been passed in the request
	 *
	 * @return  string  The return URL.
	 *
	 * @since   1.6
	 */
	protected function getReturnPage()
	{
		$return = $this->input->get('return', null, 'base64');
		if (empty($return) || !JUri::isInternal(base64_decode($return)))
		{
			return JRoute::_('index.php?option=com_hiots&view=hdevrecs',false);
		}
		return base64_decode($return);
	}

	/**
	 * Method to save a record.
	 *
	 * @param   string  $key     The name of the primary key of the URL variable.
	 * @param   string  $cVar  The name of the URL variable if different from the primary key (sometimes required to avoid router collisions).
	 *
	 * @return  boolean  True if successful, false otherwise.
	 *
	 * @since   1.6
	 */
	
	public function save($key = NULL, $urlVar = NULL)
	{
		if (!parent::save($key = NULL, $urlVar = NULL))
		{
			JFactory::getApplication()->enqueueMessage(JText::_('COM_HIOTS_DATABASE_ERROR'), 'error');
		}
		$this->setRedirect($this->getReturnPage());
	}
	





}
