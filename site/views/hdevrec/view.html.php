<?php
/**
 * @copyright	Copyright (C) 2016 Horst Gehrmann. All rights reserved.
 * @copyright	Copyright (C) 2005 - 2016 Open Source Matters,  Inc. All right reserved
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
	
class hiotsViewHdevrec extends JViewLegacy
{

	protected $item;

	protected $form;

	/**
	 * Display the view.
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  mixed  A string if successful, otherwise an Error object.
	 */


	public function display($tpl = null)
	{
		$app 		= JFactory::getApplication();
		$this->params		= $app->getParams();
		
		$this->item		= $this->get('Item');
		$this->form		= $this->get('Form');
		$this->return_page =  JFactory::getApplication()->input->get('return', null, 'base64');
		if (count($errors = $this->get('Errors')))
		{
			JFactory::getApplication()->enqueueMessage(implode("\n", $errors), 'error');
			return false;
		}
		parent::display($tpl);
	}
	
	


	
	
	protected function _prepareDocument()
	{
		$app   = JFactory::getApplication();
		$menus = $app->getMenu();
		$title = null;

		// Because the application sets a default page title,
		// we need to get it from the menu item itself
		$menu = $menus->getActive();

		if ($menu)
		{
			$this->params->def('page_heading', $this->params->get('page_title', $menu->title));
		}
		else
		{
			$this->params->def('page_heading', $head);
		}

		$title = $this->params->def('page_title', $head);

		if ($app->get('sitename_pagetitles', 0) == 1)
		{
			$title = JText::sprintf('JPAGETITLE', $app->get('sitename'), $title);
		}
		elseif ($app->get('sitename_pagetitles', 0) == 2)
		{
			$title = JText::sprintf('JPAGETITLE', $title, $app->get('sitename'));
		}

		$this->document->setTitle($title);

		if ($this->params->get('menu-meta_description'))
		{
			$this->document->setDescription($this->params->get('menu-meta_description'));
		}

		if ($this->params->get('menu-meta_keywords'))
		{
			$this->document->setMetadata('keywords', $this->params->get('menu-meta_keywords'));
		}

		if ($this->params->get('robots'))
		{
			$this->document->setMetadata('robots', $this->params->get('robots'));
		}
		$doc = JFactory::getDocument();
		$doc->addStyleSheet(JUri::base(true) .'/media/jui/css/bootstrap.min.css'); 
	}
	



	
	

}
