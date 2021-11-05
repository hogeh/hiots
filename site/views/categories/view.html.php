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
 * Content categories view.
 *
 * @since  1.5
 */
class HiotsViewCategories extends JViewCategories
{
	protected $item = null;

	/**
	 * @var    string  Default title to use for page title
	 * @since  3.2
	 */
	protected $defaultPageTitle = 'COM_HIOTS_DEFAULT_PAGE_TITLE';

	/**
	 * @var    string  The name of the extension for the category
	 * @since  3.2
	 */
	protected $extension = 'com_hiots';

	/**
	 * @var    string  The name of the view to link individual items to
	 * @since  3.2
	 */
	protected $viewName = 'hiot';

	/**
	 * Execute and display a template script.
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  mixed  A string if successful, otherwise a Error object.
	 */
	public function display($tpl = null)
	{
		$state		= $this->get('State');
		$items		= $this->get('Items');
		$parent		= $this->get('Parent');

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new \Exception(implode("\n", $errors),500);
			return false;
		}

		if ($items === false)
		{
			throw new \Exception(JText::_('JGLOBAL_CATEGORY_NOT_FOUND'),404);
		}

		if ($parent == false)
		{
			throw new \Exception(JText::_('JGLOBAL_CATEGORY_NOT_FOUND'),404);
		}

		$params = &$state->params;

		$items = array($parent->id => $items);

		// Escape strings for HTML output
		$this->pageclass_sfx = htmlspecialchars($params->get('pageclass_sfx'));

		$this->maxLevelcat = $params->get('maxLevelcat', -1);
		$this->params = &$params;
		$this->parent = &$parent;
		$this->items  = &$items;

		return parent::display($tpl);
	}
}
