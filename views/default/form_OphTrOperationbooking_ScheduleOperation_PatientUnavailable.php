<?php /**
 * OpenEyes
 *
 * (C) Moorfields Eye Hospital NHS Foundation Trust, 2008-2011
 * (C) OpenEyes Foundation, 2011-2014
 * This file is part of OpenEyes.
 * OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package OpenEyes
 * @link http://www.openeyes.org.uk
 * @author OpenEyes <info@openeyes.org.uk>
 * @copyright Copyright (c) 2008-2011, Moorfields Eye Hospital NHS Foundation Trust
 * @copyright Copyright (c) 2011-2013, OpenEyes Foundation
 * @license http://www.gnu.org/licenses/gpl-3.0.html The GNU General Public License V3.0
 */
?>
<tr class="patient-unavailable" data-key="<?php echo $key ?>">
	<td>
		<?php if (isset($unavailable) && $unavailable->id) { ?>
			<input type="hidden" name="<?php echo $element_name; ?>[patient_unavailables][<?php echo $key ?>][id]" value="<?php echo $unavailable->id?>" />
		<?php } ?>
		<?php $form->widget('application.widgets.DatePicker',array(
						'element' => $unavailable,
						'name' => $element_name . '[patient_unavailables]['.$key.'][start_date]',
						'field' => 'start_date',
						'htmlOptions' => array(
								'id' => 'patient_unavailables_' . $key . '_start_date',
								'nowrapper' => true,
								'class' => 'unavailable-start-date'
						)));
		?>
	</td>
	<td>
		<?php $form->widget('application.widgets.DatePicker',array(
						'element' => $unavailable,
						'name' => $element_name . '[patient_unavailables]['.$key.'][end_date]',
						'field' => 'end_date',
						'htmlOptions' => array(
								'id' => 'patient_unavailables_' . $key . '_end_date',
								'nowrapper' => true,
								'class' => 'unavailable-end-date'
						)));
		?>
	</td>
	<td>
		<?php echo CHtml::dropDownList($element_name . '[patient_unavailables]['.$key.'][reason_id]',
				$unavailable->reason_id,
				CHtml::listData($unavailable->getPatientUnavailbleReasons(), 'id', 'name'),
				array('class'=>'small', 'empty' => '- Please select -'))?>
	</td>
	<td class="patient-unavailable-actions">
			<a class="remove-unavailable" href="#">Remove</a>
	</td>
</tr>