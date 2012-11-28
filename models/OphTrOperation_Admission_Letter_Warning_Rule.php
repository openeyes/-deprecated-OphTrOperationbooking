<?php /**
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

/**
 * This is the model class for table "et_ophtroperation_operation_preop_assessment_rule".
 *
 * The followings are the available columns in table:
 * @property integer $id
 * @property integer $parent_rule_id
 * @property integer $theatre_id
 * @property integer $subspecialty_id
 * @property boolean $show_warning
 */

class OphTrOperation_Admission_Letter_Warning_Rule extends BaseActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ophtroperation_admission_letter_warning_rule';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rule_type_id, parent_rule_id, rule_order, site_id, theatre_id, subspecialty_id, is_child, show_warning, warning_text, emphasis, strong', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name', 'safe', 'on' => 'search'),
		);
	}
	
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'user' => array(self::BELONGS_TO, 'User', 'created_user_id'),
			'usermodified' => array(self::BELONGS_TO, 'User', 'last_modified_user_id'),
			'children' => array(self::HAS_MANY, 'OphTrOperation_Admission_Letter_Warning_Rule', 'parent_rule_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id, true);
		$criteria->compare('name', $this->name, true);

		return new CActiveDataProvider(get_class($this), array(
				'criteria' => $criteria,
			));
	}

	static public function getRule($rule_type_name, $site_id, $is_child, $theatre_id, $subspecialty_id) {
		if (!$rule_type = OphTrOperation_Admission_Letter_Warning_Rule_Type::model()->find('name=?',array('Preop Assessment'))) {
			throw new Exception("We were asked for a rule type that doesn't exist: $rule_type_name");
		}

		$criteria = new CDbCriteria;
		$criteria->addCondition('parent_rule_id is null');
		$criteria->addCondition("rule_type_id = $rule_type->id");
		$criteria->order = 'rule_order asc';

		foreach (OphTrOperation_Admission_Letter_Warning_Rule::model()->findAll($criteria) as $rule) {
			if ($rule->applies($site_id, $is_child, $theatre_id, $subspecialty_id)) {
				return $rule->parse($site_id, $is_child, $theatre_id, $subspecialty_id);
			}
		}
	}

	public function applies($site_id, $is_child, $theatre_id, $subspecialty_id) {
		foreach (array('site_id', 'is_child', 'theatre_id','subspecialty_id') as $field) {
			if ($this->{$field} !== null && $this->{$field} != ${$field}) {
				return false;
			}
		}

		return true;
	}

	public function parse($site_id, $is_child, $theatre_id, $subspecialty_id) {
		foreach ($this->children as $rule) {
			if ($rule->applies($site_id, $is_child, $theatre_id, $subspecialty_id)) {
				return $rule->parse($site_id, $is_child, $theatre_id, $subspecialty_id);
			}
		}

		return $this;
	}
}