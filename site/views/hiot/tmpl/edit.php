<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  Hiot
 *
 * @copyright   Copyright (C)  2018 Hogeh
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidator');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.modal', 'a.modal_jform_contenthistory');


// Create shortcut to parameters.
$params = $this->state->get('params');
?>



<form action="<?php echo JRoute::_('index.php?option=com_hiots&view=hiot&id=' . (int) $this->item->id); ?>" method="post" name="adminForm" id="adminForm" class="form-validate form-vertical">
	<div class="btn-toolbar">
		<div class="btn-group">
			<button type="button" class="btn btn-primary" onclick="Joomla.submitbutton('hiot.save')">
				<span class="icon-ok"></span> <?php echo JText::_('JSAVE') ?>
			</button>
		</div>
		<div class="btn-group">
			<button type="button" class="btn" onclick="Joomla.submitbutton('hiot.cancel')">
				<span class="icon-cancel"></span> <?php echo JText::_('JCANCEL') ?>
			</button>
		</div>
	</div><p>
	<div class="form-horizontal">
		<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'settings')); ?>
			<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'common', empty($this->item->id) ? JText::_('COM_HIOTS_NEW_IOT', true) : JText::_('COM_HIOTS_EDIT_IOT', true)); ?>
			<div class="row-fluid">
				<div class="span9">
					<div class="form-vertical">
						<?php echo $this->form->renderField('id'); ?>
						<?php echo $this->form->renderField('catid'); ?>
						<?php echo $this->form->renderField('state'); ?>
						<?php echo $this->form->renderField('title'); ?>
						<?php echo $this->form->renderField('token'); ?>
						<?php echo $this->form->renderField('iot_type'); ?>
						<?php echo $this->form->renderField('language'); ?>
					</div>
				</div>
			</div>
			<?php echo JHtml::_('bootstrap.endTab'); ?>
			<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'settings', JText::_('COM_HIOTS_SETTINGS', true)); ?>
				<div class="row-fluid">
					<div class="span6">
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
					</div>
				</div>
			<?php echo JHtml::_('bootstrap.endTab'); ?>
		<?php echo JHtml::_('bootstrap.endTabSet'); ?>
	</div>
	<div class="btn-toolbar">
		<div class="btn-group">
			<button type="button" class="btn btn-primary" onclick="Joomla.submitbutton('hiot.save')">
				<span class="icon-ok"></span> <?php echo JText::_('JSAVE') ?>
			</button>
		</div>
		<div class="btn-group">
			<button type="button" class="btn" onclick="Joomla.submitbutton('hiot.cancel')">
				<span class="icon-cancel"></span> <?php echo JText::_('JCANCEL') ?>
			</button>
		</div>
		<?php if ($params->get('save_history', 0)) : ?>
			<div class="btn-group">
				<?php echo $this->form->getInput('contenthistory'); ?>
			</div>
		<?php endif; ?>
	</div>
	<input type="hidden" name="return" value="<?php echo $this->return_page;?>" />
	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>
</form>

