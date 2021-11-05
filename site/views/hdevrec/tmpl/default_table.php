<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  Hiots
 *
 * @copyright   Copyright (C)  2018 Hogeh
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
	JLoader::register('BrewerHbeerrecipesHelper', JPATH_SITE . '/components/com_hiots/helpers/brewer.php');


//JHtml::_('behavior.caption')?>
	<style>
		td.icon
		{
			min-width: 40px;
		}
	</style>

	<div id="filter-bar" class="btn-toolbar">
		<div class="btn-group pull-right hidden-phone">
			<label for="limit" class="element-invisible"><?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC');?></label>
			
		</div>
	</div>
	<div class="clearfix"> </div>
	<table class="table table-striped" id="hspindelrecordList">

	<thead>
		<tr>
			<th width="*" class="">
				<?php echo Jtext::_('COM_HIOTS_DATE'); ?>
			</th>
			<th width="*" class="">
				<?php echo Jtext::_(''); ?>
			</th>
			<th width="*" class="">
				<?php echo Jtext::_(''); ?>
			</th>
			<th width="5%" >
				<?php echo Jtext::_(''); ?>
			</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($this->records as $i => $item) :?>
		<tr class= "<?php echo $class; ?>">
			<td>
				<?php echo CommonHogehsHelper::showlocaltime($this->timezone,NULL,$form='d.m. H:i',$this->escape($item->tdate)); ?>
			</td>
			<td class="">
						<?php foreach ($item->params as $name => $param) :?>
							<?php if (!in_array($name, array("name", "ID", "token", "interval", "a","b","c","temp_units") ) AND $param):?>
								<?php echo JText::_(strtoupper('COM_HIOTS_'.$name)).': '.$param.'<br>';?>
							<?php endif; ?>
						<?php endforeach; ?>
			</td>
			<td class="">
				</td>
			<td class="icon">
					<?php echo JHTML::link(JRoute::_('index.php?option=com_hiots&task=hiot.deletespindelrecord&id='.(int) $item->id).'&return='.base64_encode(JUri::getInstance()),JHTML::image(JURI::base().'/media/com_hiots/images/delete.png' , Jtext::_('COM_HIOTS_DELETE')));?>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php //echo $this->pagination->getListFooter(); ?>
