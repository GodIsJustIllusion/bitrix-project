<?php
namespace Intervolga\Migrato\Data\Module\Form;

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;
use Intervolga\Migrato\Data\BaseData;
use Intervolga\Migrato\Data\Record;
use Intervolga\Migrato\Data\RecordId;
use Intervolga\Migrato\Data\Link;
use Intervolga\Migrato\Tool\ExceptionText;

Loc::loadMessages(__FILE__);

class Field extends BaseData
{
	const XML_ID_SEPARATOR = '.';

	protected function configure()
	{
		Loader::includeModule("form");
		$this->setVirtualXmlId(true);
		$this->setEntityNameLoc(Loc::getMessage('INTERVOLGA_MIGRATO.FORM_FIELD_TYPE'));
		$this->setDependencies(array(
			'FORM' => new Link(Form::getInstance()),
		));
	}

	public function getList(array $filter = array())
	{
		$result = array();
		$by = 'ID';
		$order = 'ASC';
		$isFiltered = false;
		$getList = \CForm::GetList($by, $order, array(), $isFiltered);
		$formField = new \CFormField();
		while ($form = $getList->Fetch())
		{
			$rsFields = $formField->getList(
				$form['ID'],
				"ALL",
				$by,
				$order,
				array(),
				$isFiltered
			);
			while ($field = $rsFields->Fetch())
			{
				$record = new Record($this);
				$id = $this->createId($field['ID']);
				$record->setId($id);
				$record->setXmlId($this->getXmlId($id));
				$record->addFieldsRaw(array(
					"SID" => $field["SID"],
					"ACTIVE" => $field["ACTIVE"],
					"TITLE" => $field["TITLE"],
					"TITLE_TYPE" => $field["TITLE_TYPE"],
					"C_SORT" => $field["C_SORT"],
					"ADDITIONAL" => $field["ADDITIONAL"],
					"REQUIRED" => $field["REQUIRED"],
					"IN_FILTER" => $field["IN_FILTER"],
					"IN_RESULTS_TABLE" => $field["IN_RESULTS_TABLE"],
					"IN_EXCEL_TABLE" => $field["IN_EXCEL_TABLE"],
					"FIELD_TYPE" => $field["FIELD_TYPE"],
					"COMMENTS" => $field["COMMENTS"],
					"FILTER_TITLE" => $field["FILTER_TITLE"],
					"RESULTS_TABLE_TITLE" => $field["RESULTS_TABLE_TITLE"],
					"VARNAME" => $field["VARNAME"],
				));
				$dependency = clone $this->getDependency("FORM");
				$dependency->setValue(
					Form::getInstance()->getXmlId(RecordId::createNumericId($form['ID']))
				);
				$record->setDependency("FORM", $dependency);
				$result[] = $record;
			}
		}
		return $result;
	}

	public function getXmlId($id)
	{
		$formField = new \CFormField();
		$field = $formField->getByID($id->getValue())->Fetch();
		$form = \CForm::GetByID($field['FORM_ID'])->fetch();
		$formXmlId = Form::getInstance()->getXmlId(Form::getInstance()->createId($form['ID']));

		return $formXmlId . static::XML_ID_SEPARATOR . $field['SID'];
	}

	public function update(Record $record)
	{
		$data = $this->recordToArray($record);
		$id = $record->getId()->getValue();
		global $strError;
		$strError = '';
		$formField = new \CFormField();
		$result = $formField->set($data, $id);
		if (!$result)
		{
			throw new \Exception(ExceptionText::getFromString($strError));
		}
	}

	/**
	 * @param Record $record
	 * @return array
	 */
	protected function recordToArray(Record $record)
	{
		$array = array(
			'SID' => $record->getFieldRaw('SID'),
			'ACTIVE' => $record->getFieldRaw('ACTIVE'),
			'TITLE' => $record->getFieldRaw('TITLE'),
			'TITLE_TYPE' => $record->getFieldRaw('TITLE_TYPE'),
			'C_SORT' => $record->getFieldRaw('C_SORT'),
			'ADDITIONAL' => $record->getFieldRaw('ADDITIONAL'),
			'REQUIRED' => $record->getFieldRaw('REQUIRED'),
			'IN_FILTER' => $record->getFieldRaw('IN_FILTER'),
			'IN_RESULTS_TABLE' => $record->getFieldRaw('IN_RESULTS_TABLE'),
			'IN_EXCEL_TABLE' => $record->getFieldRaw('IN_EXCEL_TABLE'),
			'FIELD_TYPE' => $record->getFieldRaw('FIELD_TYPE'),
			'COMMENTS' => $record->getFieldRaw('COMMENTS'),
			'FILTER_TITLE' => $record->getFieldRaw('FILTER_TITLE'),
			'RESULTS_TABLE_TITLE' => $record->getFieldRaw('RESULTS_TABLE_TITLE'),
			'VARNAME' => $record->getFieldRaw('VARNAME'),
		);

		if ($form = $record->getDependency("FORM"))
		{
			if ($form->getId())
			{
				$array["FORM_ID"] = $form->getId()->getValue();
			}
		}


		return $array;
	}

	protected function createInner(Record $record)
	{
		$data = $this->recordToArray($record);
		global $strError;
		$strError = '';
		$formField = new \CFormField();
		$result = $formField->set($data, "");
		if ($result)
		{
			return $this->createId($result);
		}
		else
		{
			throw new \Exception(ExceptionText::getFromString($strError));
		}
	}

	protected function deleteInner(RecordId $id)
	{
		$formField = new \CFormField();
		$formField->delete($id->getValue());
	}
}