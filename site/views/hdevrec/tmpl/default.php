<?php
/**
 * @copyright	Copyright (C) 2016 Horst Gehrmann. All rights reserved.
 * @copyright	Copyright (C) 2005 - 2016 Open Source Matters,  Inc. All right reserved
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
	JLoader::register('BrewerHbeerrecipesHelper', JPATH_SITE . '/components/com_hiots/helpers/brewer.php');
//JHtml::_('behavior.caption')?>
<?php 	$user	= JFactory::getUser();
		$this->canEdit=($this->item->created_by == $user->id);

		?>
	<meta http-equiv="refresh" content="300">
	<form action="<?php echo JRoute::_('index.php?option=com_hiots&view=hdevrec&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm" class="form-validate form-vertical">
		<div class="row-fluid form-horizontal">
			<div class="pull-left"><h2><?php echo $this->item->title;?></h2></div>
			<div class="pull-right"><i>Stand: <?php if ($this->item->modified): echo CommonHogehsHelper::showlocaltime($this->timezone,NULL,$form='d.m H:i',$this->escape($this->item->modified));
			 else: echo '-'; endif;?></i></div>
		</div>
		<div class="row-fluid  form-horizontal">
			<div id="filter-bar" class="">
				<div class="filter-search btn-group pull-left">
					<label for="filter-backdays" class=""><?php echo JText::_('COM_HIOTS_BACKDAYS');?></label>
					<input type="text" name="filter-backdays" id="filter-backdays"  value="<?php echo $this->escape($this->state->get('filter.backdays')); ?>" title="<?php echo JText::_('COM_HIOTS_BACKDAYS'); ?>" />
				</div>
				<div class="btn-group pull-left">
					<button class="btn hasTooltip" type="submit" title="<?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>"><i class="icon-search"></i></button>
				</div>
			</div>
		</div>
	
	<?php if ($this->item->iot_type==0):?>
		<div class="row-fluid form-horizontal"><?php echo JText::_('COM_HIOTS_ORIGINAL_GRAVITY');?>: <?php echo number_format( $this->endvergaerung->stammwuerze, 1, JText::_('DECIMALS_SEPARATOR'), JText::_('THOUSANDS_SEPARATOR'))."°Plato (OG: ".
			number_format( BrewerHbeerrecipesHelper::platotosg($this->endvergaerung->sw), 3, JText::_('DECIMALS_SEPARATOR'), JText::_('THOUSANDS_SEPARATOR')).')';?></div>
		<div class="row-fluid form-horizontal"><?php echo JText::_('COM_HIOTS_RESTEXTRAKT');?>: <?php echo number_format( $this->endvergaerung->re, 1, JText::_('DECIMALS_SEPARATOR'), JText::_('THOUSANDS_SEPARATOR'))."/".
			number_format( $this->endvergaerung->tre, 1, JText::_('DECIMALS_SEPARATOR'), JText::_('THOUSANDS_SEPARATOR'))." °Plato (FG: ".
			number_format( BrewerHbeerrecipesHelper::platotosg($this->endvergaerung->re), 3, JText::_('DECIMALS_SEPARATOR'), JText::_('THOUSANDS_SEPARATOR')).')' ;?> </div> 
		<div class="row-fluid form-horizontal"><?php echo JText::_('COM_HIOTS_ENDVERGAERUNGSGRAD');?>: <?php echo number_format( $this->endvergaerung->sevg, 1, JText::_('DECIMALS_SEPARATOR'), JText::_('THOUSANDS_SEPARATOR'))."% (".
			number_format( $this->endvergaerung->tevg, 1, JText::_('DECIMALS_SEPARATOR'), JText::_('THOUSANDS_SEPARATOR'))."%)";?></div> 	
		<div class="row-fluid form-horizontal"><?php echo JText::_('COM_HIOTS_GAERDAUER');?>: <?php echo number_format($this->endvergaerung->gaerdauer, 1, JText::_('DECIMALS_SEPARATOR'), JText::_('THOUSANDS_SEPARATOR'));?> <?php echo JText::_('COM_HIOTS_DAYS');?></div>
		<ul class="">
			<?php if ($this->vergaerung3->gaerdauer>2):?>		
				<li><?php echo JText::sprintf('COM_HIOTS_FERMENTATION_IN_LAST_DAYS',$this->vergaerung3->gaerdauer).number_format(($this->vergaerung3->stammwuerze-$this->vergaerung3->restextract)/$this->vergaerung3->gaerdauer, 2, JText::_('DECIMALS_SEPARATOR'), JText::_('THOUSANDS_SEPARATOR')).'° Plato pro Tag</li>';?></li>
			<?php endif ?>		
			<?php if ($this->vergaerung2->gaerdauer>1):?>		
				<li><?php echo JText::sprintf('COM_HIOTS_FERMENTATION_IN_LAST_DAYS',$this->vergaerung2->gaerdauer).number_format(($this->vergaerung2->stammwuerze-$this->vergaerung2->restextract)/$this->vergaerung2->gaerdauer, 2, JText::_('DECIMALS_SEPARATOR'), JText::_('THOUSANDS_SEPARATOR')).'° Plato pro Tag</li>';?></li>
			<?php endif ?>		
			<?php if ($this->vergaerung1->gaerdauer>0):?>		
				<li><?php echo JText::sprintf('COM_HIOTS_FERMENTATION_IN_LAST_DAYS',$this->vergaerung1->gaerdauer).number_format( ($this->vergaerung1->stammwuerze-$this->vergaerung1->restextract)/$this->vergaerung1->gaerdauer, 2, JText::_('DECIMALS_SEPARATOR'), JText::_('THOUSANDS_SEPARATOR')).'° Plato pro Tag</li>';?></li>
			<?php endif ?>		
		</ul>
		<div>Aktueller Alkoholgehalt: <?php echo number_format( $this->endvergaerung->alk, 2, JText::_('DECIMALS_SEPARATOR'), JText::_('THOUSANDS_SEPARATOR'))."Vol%";?></div> 	

	<?php else:?>
	<?php endif;?>
		<?php 	echo '<div id="iotgraph'.$this->item->id.'" class="iotgraph'.$this->item->id.'"></div>'; ?>
		
		<div class="form-horizontal">
			<input type="hidden" name="return" value="<?php echo $this->return_page;?>" />
			<input type="hidden" name="task" value="" />
			<?php echo JHtml::_('form.token'); ?>
		</div>
		</form>
		<?php if($this->canEdit):?>
			<?php // echo $this->loadTemplate('table');?>
		<?php endif;?>
