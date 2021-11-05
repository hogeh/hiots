<?php
/**
 * @copyright	Copyright (C) 2016 Horst Gehrmann. All rights reserved.
 * @copyright	Copyright (C) 2005 - 2016 Open Source Matters,  Inc. All right reserved
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
JLoader::register('CommonHogehsHelper', JPATH_SITE . '/components/com_hiots/helpers/common.php');
JLoader::register('IotHiotsHelper', JPATH_SITE . '/components/com_hiots/helpers/iot.php');
	
class hiotsViewHiot extends JViewLegacy
{

	protected $item;

	protected $return_page;

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
		$app 		= JFactory::getApplication();
		$this->state= $this->get('State');
		$item = $this->get('Item');
		$model = $this->getmodel();
		$this->pagination	= $model->get('Pagination');
		$this->item=$item;
		$this->timezone	= CommonHogehsHelper::getTimeZone();
		if ($this->getLayout() <> 'edit'){
			$records =IotHiotsHelper::getrecords($item->id,(int)$item->params->current_session_id,$this->state->get('filter.backdays'));//$model->get('Items');
			$this->records=$records;
			if ($item->iot_type==0) {
				IotHiotsHelper::show_ispindel_graph($item->id,$item->params,$records);
				$this->endvergaerung=BrewerhbeerrecipesHelper::getvergaerungsparams($item->params,$records);
				$records = IotHiotsHelper::getrecords($this->item->id,(int)$item->params->current_session_id,1);
				$this->vergaerung1=BrewerhbeerrecipesHelper::getvergaerungsparams($item->params,$records,1);
				$records = IotHiotsHelper::getrecords($this->item->id,(int)$item->params->current_session_id,2);
				$this->vergaerung2=BrewerhbeerrecipesHelper::getvergaerungsparams($item->params,$records,2);
				$records = IotHiotsHelper::getrecords($this->item->id,(int)$item->params->current_session_id,3);
				$this->vergaerung3=BrewerhbeerrecipesHelper::getvergaerungsparams($item->params,$records,3);
			} else {
				if ($item->iot_type==1){
					IotHiotsHelper::show_meshcontroller_graph($item->id,$records);
				} else {
					if ($item->iot_type>1){
						$this->stati=IotHiotsHelper::show_heating_graph($item->id,$records);
					} 
				}
			}
			$this->iot_type=$item->iot_type;
		}
		$app 		= JFactory::getApplication();
		$params		= $app->getParams();
		$this->params=&$params;
		$this->form  = $this->get('Form');
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

		if (empty($this->item->id))
		{
			$head = JText::_('Neues Brauprotokoll');
		}
		else
		{
			$head = JText::_('Brauprotokoll');
		}

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
