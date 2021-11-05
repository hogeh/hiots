<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  Hdevrec
 *
 * @copyright   Copyright (C)  2018 Hogeh
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
//JHtml::_('behavior.caption')
JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidator');
JHtml::_('formbehavior.chosen', 'select');

?>

<div class="edit<?php echo $this->pageclass_sfx; ?>">
	<?php if ($this->params->get('show_page_heading')) : ?>
	<h1>
		<?php echo $this->escape($this->params->get('page_heading')); ?>
	</h1>
	<?php endif; ?>
	<form action="<?php echo JRoute::_('index.php?option=com_hiots&view=hdevrec&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm" class="form-validate form-vertical">

		<?php echo $this->form->renderField('id'); ?>
		<?php echo $this->form->renderField('s_id'); ?>
		<?php echo $this->form->renderField('tdate'); ?>
		<?php echo $this->form->renderField('session_id'); ?>
		<?php $fieldSets = $this->form->getFieldsets('params');?>
		<?php foreach ($fieldSets as $name => $fieldSet) : ?>
			<?php if((substr($name,0,4)<>'type') OR  ((substr($name,0,4)=='type') AND (substr($name,4,1)==$this->item->iot_type))): ?>
				<div class="tab-pane" id="params-<?php echo $name; ?>">
				<h3><?php echo JText::_($fieldSet->label);?></h3>
				<?php if (isset($fieldSet->description) && trim($fieldSet->description)) : ?>
					<?php echo '<p class="alert alert-info">' . $this->escape(JText::_($fieldSet->description)) . '</p>'; ?>
				<?php endif; ?>
				<?php foreach ($this->form->getFieldset($name) as $field) : ?>
					<div class="control-group">
						<div class="control-label"><?php echo $field->label; ?></div>
						<div class="controls"><?php echo $field->input; ?></div>
					</div>
				<?php endforeach; ?>
				</div>
			<?php endif; ?>
		<?php endforeach; ?>
		<div class="btn-toolbar">
			<div class="btn-group">
				<button type="button" class="btn btn-primary" onclick="Joomla.submitbutton('hdevrec.save')">
					<span class="icon-ok"></span> <?php echo JText::_('JSAVE') ?>
				</button>
			</div>
			<div class="btn-group">
				<button type="button" class="btn" onclick="Joomla.submitbutton('hdevrec.cancel')">
					<span class="icon-cancel"></span> <?php echo JText::_('JCANCEL') ?>
				</button>
			</div>
		</div>
		<input type="hidden" name="return" value="<?php echo $this->return_page;?>" />
		<input type="hidden" name="task" value="" />
		<?php echo JHtml::_('form.token'); ?>
	</form>
</div>
