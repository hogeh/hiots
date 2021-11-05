<?php
/**
 * @copyright	Copyright (C) 2016 Horst Gehrmann. All rights reserved.
 * @copyright	Copyright (C) 2005 - 2016 Open Source Matters,  Inc. All right reserved
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
JLoader::register('CommonHogehsHelper', JPATH_SITE . '/components/com_hiots/helpers/common.php');

class HiotsViewHiots extends JViewLegacy
{
	protected $items;

	protected $state;

	protected $pagination;

	public function display($tpl = null)
	{
//		parent::commonCategoryDisplay();

		// Prepare the data.
		// Compute the hiot slug & link c.
		$this->items		= $this->get('Items');
		$this->state		= $this->get('State');
		$model=$this->getModel();
		$this->params		= JFactory::getApplication()->getParams();
		$this->pagination	= $this->get('Pagination');
		$user=JFactory::getUser();
		$this->timezone	= CommonHogehsHelper::getTimeZone();
		foreach ($this->items as $item)
		{
			$item->params=json_decode($item->params);
			$item->slug = $item->alias ? ($item->id . ':' . $item->alias) : $item->id;
			$details=$model->getdetails($item->id,(int)$item->params->current_session_id);
			if ($details){
				$item->maxdate=$details->maxdate;
				$item->counti=$details->counti;
			}
		} 
		$this->_prepareDocument();
		return parent::display($tpl);
	}

	protected function _prepareDocument()
	{
		$doc = JFactory::getDocument();
		$this->pageheading=$doc->getTitle();
		$doc->addStyledeclaration('
			div.scroll {
				overflow-x: auto;
			}
			
			td.leftcol
			{
				background-color: #f5f5f2;
				text-align: left;
			}
			
			td.middlecol
			{
				text-align: left;
			}
		'); 
	}


}
