<?php
/**
 * @copyright	Copyright (C) 2016 Horst Gehrmann. All rights reserved.
 * @copyright	Copyright (C) 2005 - 2016 Open Source Matters,  Inc. All right reserved
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
		
class HiotsControllerHdevrecs extends JControllerAdmin
{
	public function getModel($name = 'hdevrecs', $prefix = '', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);
		return $model;
	}

	public function delete(){ 
		//$input = JFactory::getApplication()->input;
		$pks = $this->input->post->get('cid', array(), 'array');
		$s_id=	$this->input->getint('s_id');
		$current_session_id=	$this->input->getint('current_session_id');
		$out = implode(",",$pks);
        $model=$this->getmodel();
		$msg=$model->delete_devrecs($out);
		$link = JRoute::_('index.php?option=com_hiots&view=hdevrecs&s&s_id='.$s_id.'&session_id='.$current_session_id,false);
		$this->setRedirect($link, $msg);
	}	
	public function delete_all(){ 
		$s_id=	$this->input->getint('s_id');
		$current_session_id=	$this->input->getint('current_session_id');
		$model=$this->getmodel();
		$msg=$model->delete_alldevrecs($s_id,$current_session_id);
		$link = JRoute::_('index.php?option=com_hiots&view=hdevrecs&s&s_id='.$s_id.'&session_id='.$current_session_id,false);
		$this->setRedirect($link, $msg);
	}	
	
	
}	
