<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  Hiots
 *
 * @copyright   Copyright (C)  2018 Hogeh
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

require_once JPATH_COMPONENT_ADMINISTRATOR . '/models/hiot.php';

/**
 * Hiots model.
 *
 * @since  1.6
 */
class HiotsModelForm extends HiotsModelHiot
{
	/**
	 * Model typeAlias string. Used for version history.
	 *
	 * @var    string
	 * @since  3.2
	 */
	public $typeAlias = 'com_hiots.hiot';

	/**
	 * Get the return URL.
	 *
	 * @return  string  The return URL.
	 *
	 * @since   1.6
	 */
	public function getReturnPage()
	{
		return base64_encode($this->getState('return_page'));
	}

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	protected function populateState()
	{
		$app = JFactory::getApplication();

		// Load state from the request.
		$pk = $app->input->getInt('id');
		$this->setState('hiot.id', $pk);

		// Add compatibility variable for default naming conventions.
		$this->setState('form.id', $pk);

		$categoryId = $app->input->getInt('catid');
		$this->setState('hiot.catid', $categoryId);

		$type_id = $app->getUserStateFromRequest($this->option.'hiot.type_id','type_id');
		$this->setState('hiot.type_id', $type_id);

		$return = $app->input->get('return', null, 'base64');

		if (!JUri::isInternal(base64_decode($return)))
		{
			$return = null;
		}

		$this->setState('return_page', base64_decode($return));

		// Load the parameters.
		$params = $app->getParams();
		$this->setState('params', $params);

		$this->setState('layout', $app->input->getString('layout'));
	}
}
