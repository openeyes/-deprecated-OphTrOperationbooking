<?php
/**
 * OpenEyes
 *
 * (C) Moorfields Eye Hospital NHS Foundation Trust, 2008-2011
 * (C) OpenEyes Foundation, 2011-2012
 * This file is part of OpenEyes.
 * OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package OpenEyes
 * @link http://www.openeyes.org.uk
 * @author OpenEyes <info@openeyes.org.uk>
 * @copyright Copyright (c) 2008-2011, Moorfields Eye Hospital NHS Foundation Trust
 * @copyright Copyright (c) 2011-2012, OpenEyes Foundation
 * @license http://www.gnu.org/licenses/gpl-3.0.html The GNU General Public License V3.0
 */

?>
<div class="curvybox white">
	<div class="admin">
		<h3 class="georgia"><?php echo $rule->id ? 'Edit' : 'Add'?> letter warning rule</h3>
		<?php echo $this->renderPartial('//admin/_form_errors',array('errors'=>$errors))?>
		<div>
			<?php
			$form = $this->beginWidget('BaseEventTypeCActiveForm', array(
				'id'=>'adminform',
				'enableAjaxValidation'=>false,
				'htmlOptions' => array('class'=>'sliding'),
				'focus'=>'#contactname'
			))?>
			<?php echo $form->dropDownList($rule,'rule_type_id',CHtml::listData(OphTrOperationbooking_Admission_Letter_Warning_Rule_Type::model()->findAll(array('order'=>'name')),'id','name'),array('empty'=>'- Rule type -'))?>
			<?php echo $form->dropDownList($rule,'parent_rule_id',CHtml::listData(OphTrOperationbooking_Admission_Letter_Warning_Rule::model()->getListAsTree(),'id','treeName'),array('empty'=>'- None -'))?>
			<?php echo $form->textField($rule,'rule_order')?>
			<?php echo $form->dropDownList($rule,'site_id',CHtml::listData(Site::model()->findAll(array('order'=>'name asc','condition'=>'institution_id = 1')),'id','name'),array('empty'=>'- Not set -'))?>
			<?php echo $form->dropDownList($rule,'firm_id',Firm::model()->getListWithSpecialties(),array('empty'=>'- Not set -'))?>
			<?php echo $form->dropDownList($rule,'subspecialty_id',CHtml::listData(Subspecialty::model()->findAllByCurrentSpecialty(),'id','name'),array('empty'=>'- Not set -'))?>
			<?php echo $form->dropDownList($rule,'theatre_id',CHtml::listData(OphTrOperationbooking_Operation_Theatre::model()->findAll(array('order'=>'name')),'id','name'),array('empty'=>'- Not set -'))?>
			<?php echo $form->dropDownList($rule,'is_child',array(''=>'- Not set -','1'=>'Child','0'=>'Adult'))?>
			<?php echo $form->radioBoolean($rule,'show_warning')?>
			<?php echo $form->textArea($rule,'warning_text',array('rows'=>5,'cols'=>80))?>
			<?php echo $form->radioBoolean($rule,'emphasis')?>
			<?php echo $form->radioBoolean($rule,'strong')?>
			<?php $this->endWidget()?>
		</div>
	</div>
</div>
<?php echo $this->renderPartial('//admin/_form_errors',array('errors'=>$errors))?>
<div>
	<?php echo EventAction::button('Save', 'save', array('colour' => 'green'))->toHtml()?>
	<?php echo EventAction::button('Cancel', 'cancel', array('colour' => 'red'))->toHtml()?>
	<?php if ($rule->id) echo EventAction::button('Delete', 'delete', array('colour' => 'blue'))->toHtml()?>
	<img class="loader" src="<?php echo Yii::app()->createUrl('/img/ajax-loader.gif')?>" alt="loading..." style="display: none;" />
</div>
<script type="text/javascript">
	handleButton($('#et_cancel'),function() {
		window.location.href = baseUrl+'/OphTrOperationbooking/admin/viewLetterContactRules';
	});
	handleButton($('#et_save'),function() {
		$('#adminform').submit();
	});
	handleButton($('#et_delete'),function() {
		window.location.href = baseUrl+'/OphTrOperationbooking/admin/deleteLetterContactRule/<?php echo $rule->id?>';
	});
</script>
