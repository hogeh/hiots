<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  Hdevrecs
 *
 * @copyright   Copyright (C)  2018 Hogeh
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * View class for a list of hdevrecs.
 *
 * @since  1.5
 */
class HiotsViewHdevrecs extends JViewLegacy
{
	protected $items;

	protected $pagination;

	protected $state;

	/**
	 * Display the view.
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  mixed  A string if successful, otherwise an Error object.
	 */
	public function display($tpl = null)
	{
		$this->state         = $this->get('State');
		$this->items         = $this->get('Items');
		$this->pagination    = $this->get('Pagination');
//		$this->filterForm    = $this->get('FilterForm');
		$this->activeFilters = $this->get('ActiveFilters');

		HiotsHelper::addSubmenu('hdevrecs');

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		$this->addToolbar();
		$this->sidebar = JHtmlSidebar::render();
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	protected function addToolbar()
	{
		require_once JPATH_COMPONENT . '/helpers/hiots.php';

		$state = $this->get('State');
		$canDo = JHelperContent::getActions('com_hiots', 'category', $state->get('filter.category_id'));
		$user  = JFactory::getUser();

		// Get the toolbar object instance
		$bar = JToolBar::getInstance('toolbar');

		JToolbarHelper::title(JText::_('COM_HIOTS_MANAGER_HIOTS'), 'link hdevrecs');

		if (count($user->getAuthorisedCategories('com_hiots', 'core.create')) > 0)
		{
			JToolbarHelper::addNew('hdevrec.add');
		}

		if ($canDo->get('core.edit') || $canDo->get('core.edit.own'))
		{
			JToolbarHelper::editList('hdevrec.edit');
		}

		if ($canDo->get('core.edit.state'))
		{
			JToolbarHelper::publish('hdevrecs.publish', 'JTOOLBAR_PUBLISH', true);
			JToolbarHelper::unpublish('hdevrecs.unpublish', 'JTOOLBAR_UNPUBLISH', true);

			JToolbarHelper::archiveList('hdevrecs.archive');
			JToolbarHelper::checkin('hdevrecs.checkin');
		}

		if ($state->get('filter.published') == -2 && $canDo->get('core.delete'))
		{
			JToolbarHelper::deleteList('JGLOBAL_CONFIRM_DELETE', 'hdevrecs.delete', 'JTOOLBAR_EMPTY_TRASH');
		}
		elseif ($canDo->get('core.edit.state'))
		{
			JToolbarHelper::trash('hdevrecs.trash');
		}

		// Add a batch button
		if ($user->authorise('core.create', 'com_hiots') && $user->authorise('core.edit', 'com_hiots')
			&& $user->authorise('core.edit.state', 'com_hiots'))
		{
			//JHtml::_('bootstrap.modal', 'collapseModal');
			$title = JText::_('JTOOLBAR_BATCH');

			// Instantiate a new JLayoutFile instance and render the batch button
			$layout = new JLayoutFile('joomla.toolbar.batch');

			$dhtml = $layout->render(array('title' => $title));
			$bar->appendButton('Custom', $dhtml, 'batch');
		}

		if ($user->authorise('core.admin', 'com_hiots') || $user->authorise('core.options', 'com_hiots'))
		{
			JToolbarHelper::preferences('com_hiots');
		}

		JToolbarHelper::help('JHELP_COMPONENTS_HIOTS_LINKS');
	}

	/**
	 * Returns an array of fields the table can be sorted by
	 *
	 * @return  array  Array containing the field name to sort by as the key and display text as value
	 *
	 * @since   3.0
	 */
	protected function getSortFields()
	{
		return array(
			'a.state' => JText::_('JSTATUS'),
			'a.tdate' => JText::_('JGLOBAL_TITLE'),
			'a.id' => JText::_('JGRID_HEADING_ID')
		);
	}
}
