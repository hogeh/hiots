<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  Hiots
 *
 * @copyright   Copyright (C)  2018 Hogeh
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Hiots Component Controller
 *
 * @since  1.5
 */
class HiotsController extends JControllerLegacy
{
	/**
	 * Method to display a view.
	 *
	 * @param   boolean  $cacheable  If true, the view output will be cached
	 * @param   array    $urlparams  An array of safe url parameters and their variable types,
	 *                               for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return  HiotsController  This object to support chaining.
	 *
	 * @since   1.5
	 */
	public function display($cacheable = false, $urlparams = false)
	{
		// Huh? Why not just put that in the constructor?
		$cacheable = true;

		/**
		 * Set the default view name and format from the Request.
		 * Note we are using id to avoid collisions with the router and the return page.
		 * Frontend is a bit messier than the backend.
		 */
		$id    = $this->input->getInt('id');
		$vName = $this->input->get('view', 'categories');
		$this->input->set('view', $vName);

		if (JFactory::getUser()->id ||($this->input->getMethod() == 'POST' && $vName == 'categories'))
		{
			$cacheable = false;
		}

		$safeurlparams = array(
			'id'               => 'INT',
			'limit'            => 'UINT',
			'limitstart'       => 'UINT',
			'filter_order'     => 'CMD',
			'filter_order_Dir' => 'CMD',
			'lang'             => 'CMD'
		);

		// Check for edit form.
		if ($vName == 'form' && !$this->checkEditId('com_hiots.edit.hiot', $id))
		{
			// Somehow the person just went to the form - we don't allow that.
			throw new \Exception(JText::sprintf('JLIB_APPLICATION_ERROR_UNHELD_ID', $id),403);
		}

		return parent::display($cacheable, $safeurlparams);
	}
}
