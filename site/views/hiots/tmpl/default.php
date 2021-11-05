<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  Hiots
 *
 * @copyright   Copyright (C)  2018 Hogeh
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JLoader::register('CommonHogehsHelper', JPATH_SITE . '/components/com_hiots/helpers/common.php');

JHtml::_('behavior.framework');
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');


// Get the user object.
$user = JFactory::getUser();

// Check if user is allowed to add/edit based on hiots permissinos.

$n = count($this->items);
$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn  = $this->escape($this->state->get('list.direction'));
$user = JFactory::getUser();

?>
<h2><?php echo $this->pageheading?>	</h2>
<form action="<?php echo htmlspecialchars(JUri::getInstance()->toString()); ?>" method="post" name="adminForm" id="adminForm">
	<?php if ($this->params->get('filter_field') != 'hide' || $this->params->get('show_pagination_limit')) : ?>
	<fieldset class="filters btn-toolbar">
		<?php if ($this->params->get('filter_field') != 'hide') : ?>
			<div class="btn-group">
				<label class="filter-search-lbl element-invisible" for="filter-search"><?php echo JText::_('COM_HIOTS_SEARCH_IOT') . '&#160;'; ?></label>
				<input type="text" name="filter-search" id="filter-search" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" class="inputbox" onchange="document.adminForm.submit();" title="<?php echo JText::_('COM_HIOTS_SEARCH_IOT'); ?>" placeholder="<?php echo JText::_('COM_HIOTS_SEARCH_IOT'); ?>" />
			</div>
		<?php endif; ?>
		<div class="btn-group pull-right">
			<?php if ($user->id) : ?>
				<?php echo JHTML::link(JRoute::_('index.php?option=com_hiots&view=hiot&layout=edit&return='.base64_encode(JUri::getInstance())),JHTML::image(JURI::base().'/media/com_hiots/images/smalladd.png' , Jtext::_('COM_HIOTS_ADD')));?>
			<?php endif; ?>
		</div>
	</fieldset>
	<?php endif;?>
	<?php if ($this->params->get('show_pagination_limit')) : ?>
		<div class="btn-group pull-right">
			<label for="limit" class="element-invisible">  
				<?php echo JText::_('JGLOBAL_DISPLAY_NUM'); ?>
			</label>
			<?php echo $this->pagination->getLimitBox(); ?>
		</div>
	<?php endif; ?>

		<table class="table table-striped" id="d_blogrecList">
			<thead>
				<tr>
					<th width="95px" class="nowrap ">
						<?php echo Jtext::_('&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'); ?>
					</th>
					<th width="10%" class="">
						<?php echo JHtml::_('grid.sort', 'JGLOBAL_TITLE', 'a.title', $listDirn, $listOrder); ?>
					</th>
					<th width="10%" class="">
						<?php echo JHtml::_('grid.sort', 'COM_HIOTS_LAST_UPDATE', 'a.modified', $listDirn, $listOrder); ?>
					</th>
					<th width="22%" class="">
						<?php echo Jtext::_('COM_HIOTS_PARAMS'); ?>
					</th>
					<th width="22%" class="">
						<?php echo Jtext::_('COM_HIOTS_MODE'); ?>
					</th>
					<th width="22%" class="">
						<?php echo Jtext::_('COM_HIOTS_DATARECORDS'); ?>
					</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($this->items as $i => $item) :?>
				<?php $class='row<?php echo $i % 2; ?>" sortable-group-id="1'; ?>
				<?php if ($user->id==$item->created_by|| $this->items[$i]->state==1)  : ?>
					<tr class= "<?php echo $class; ?>">
							<td >
								<?php if ($user->id==$item->created_by AND $user->id)  : ?>
									<?php echo JHTML::link(JRoute::_('index.php?option=com_hiots&view=hiot&id=' . (int) $item->id.'&layout=edit'),JHTML::image(JURI::base().'media/com_hiots/images/edit.png' , Jtext::_('COM_HIOTS_EDIT')));?>
								<?php else: ?>
										
								<?php endif; ?>
							</td>
							<td>
								<?php echo JHTML::link(JRoute::_('index.php?option=com_hiots&view=hiot&id=' .(int) $item->id),$item->title);?>
							<?php if (!$item->iot_type) echo JText::_('COM_HIOTS_ISPINDEL');  else 
							 if ($item->iot_type==1) echo JText::_('COM_HIOTS_MESHCONTROLLER');else  
								if ($item->iot_type==2) echo JText::_('COM_HIOTS_HEATING');else 
									if ($item->iot_type==3) echo JText::_('COM_HIOTS_COOLING');?>

								<?php if ($this->items[$i]->state == 0) : ?>
									<span class="label label-warning"><?php echo JText::_('COM_HIOTS_UNPUBLISHED'); ?></span>
								<?php endif; ?>
							</td>
						<td class="">
								<?php echo CommonHogehsHelper::showlocaltime($this->timezone,NULL,'d.m H:i',$this->escape($item->modified)) ?>
						</td>
						<td class="">
							<?php foreach ($item->params as $name => $param) :?>
								<?php if (!in_array($name, array("name", "ID", "token", "interval", "a","b","c","temp_units","mode","current_session_id","message","status_message") ) AND $param):?>
									<?php echo JText::_(strtoupper('COM_HIOTS_'.$name)).': '.$param.'<br>';?>
								<?php endif; ?>
							<?php endforeach; ?>
						</td>
						<td>
							<?php $mode=$item->params->mode;?>
							<?php  if ($mode==0) $modetext= JText::_('COM_HIOTS_ALWAYSOFF');else  
							if ($mode==1) $modetext= JText::_('COM_HIOTS_ALWAYSON');else 
								if ($mode==2) $modetext= JText::_('COM_HIOTS_AUTOMATIC');
									if ($mode==-1) $modetext= JText::_('COM_HIOTS_TRANSMITONLY');?>

							<?php echo $modetext;?>
							<p/><?php echo JText::_('COM_HIOTS_STATUSMESSAGE').': '.JText::_($item->params->status_message);?>
								<p/>(<?php echo CommonHogehsHelper::showlocaltime($this->timezone,NULL,'d.m H:i:s',$this->escape($item->checked_out_time)) ?>
							<?php if (isset($item->maxdate)) : ?>
								/<p/><?php echo CommonHogehsHelper::showlocaltime($this->timezone,NULL,'d.m H:i:s',$this->escape($item->maxdate)) ?>)
							<?php else: ?>)	
							<?php endif; ?>
							<?php if ($this->items[$i]->state == 0) : ?>
								<span class="label label-warning"><?php echo JText::_('COM_HIOTS_UNPUBLISHED'); ?></span>
							<?php endif; ?>
						</td>
						<td>
								<?php if (!isset($item->params->current_session_id)) $item->params->current_session_id=0;?>
							<?php if (isset($item->counti)) : ?>
								<?php echo JHTML::link(JRoute::_('index.php?option=com_hiots&view=hdevrecs&s_id=' .(int) $item->id.'&session_id=' .(int)$item->params->current_session_id), $item->counti );?>
							<?php endif; ?>
							<p>	<?php echo JText::_('COM_HIOTS_RELATED_SESSION_ID').': '.$item->params->current_session_id;?>
						</td>
					</tr>
					<?php endif; ?>
				<?php endforeach; ?>
			</tbody>
		</table>
		<?php if ($this->params->get('show_pagination')) : ?>
		 <div class="pagination">
			<?php if ($this->params->def('show_pagination_results', 1)) : ?>
				<p class="counter">
					<?php echo $this->pagination->getPagesCounter(); ?>
				</p>
			<?php endif; ?>
			<?php echo $this->pagination->getPagesLinks(); ?>
		</div>
		<?php endif; ?>
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
	</form>

