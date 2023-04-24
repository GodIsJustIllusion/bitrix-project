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

class Answer extends BaseData
{
	const XML_DELIMITER = '.';

	protected function configure()
	{
		Loader::includeModule("form");
		$this->setVirtualXmlId(true);
		$this->setEntityNameLoc(Loc::getMessage('INTERVOLGA_MIGRATO.FORM_ANSWER_TYPE'));
		$this->setDependencies(array(
			'FIELD' => new Link(Field::getInstance()),
		));
	}

	public function getList(array $filter = array())
	{
		$result = array();
		$by = 'ID';
		$order = 'ASC';
		$isFiltered = false;
		$getList = \CForm::GetList($by, $order, array(), $isFiltered);
		$formAnswer = new \CFormAnswer();
		$formField = new \CFormField();
		while ($form = $getList->Fetch())
		{
			$rsQuestions = $formField->getList(
				$form['ID'],
				"ALL",
				$by,
				$order,
				array(),
				$isFiltered
			);
			while ($field = $rsQuestions->Fetch())
			{
				$rsAnswers = $formAnswer->getList(
					$field["ID"],
					$by,
					$order,
					array(),
					$isFiltered
				);
				while ($answer = $rsAnswers->Fetch())
				{
					$record = new Record($this);
					$id = $this->createId($answer['ID']);
					$record->setId($id);
					$record->setXmlId(
						$this->getXmlId($id)
					);
					$record->addFieldsRaw(array(
						"MESSAGE_ENC" => static::encodeMessage($answer["MESSAGE"]),
						"VALUE" => $answer["VALUE"],
						"FIELD_TYPE" => $answer["FIELD_TYPE"],
						"FIELD_WIDTH" => $answer["FIELD_WIDTH"],
						"FIELD_HEIGHT" => $answer["FIELD_HEIGHT"],
						"FIELD_PARAM" => $answer["FIELD_PARAM"],
						"C_SORT" => $answer["C_SORT"],
						"ACTIVE" => $answer["ACTIVE"],
					));

					$dependency = clone $this->getDependency("FIELD");
					$fieldXmlId = Field::getInstance()->getXmlId(Field::getInstance()->createId($field['ID']));
					$dependency->setValue($fieldXmlId);
					$record->setDependency("FIELD", $dependency);
					$result[] = $record;
				}
			}
		}
		return $result;
	}

	public function getXmlId($id)
	{
		$formAnswer = new \CFormAnswer();
		$answer = $formAnswer->getByID($id->getValue())->Fetch();
		$message = $answer["MESSAGE"];
		if ($message != '')
		{
			$message = md5($message);
		}
		else
		{
			$message = 'null';
		}
		$formField = new \CFormField();
		$field = $formField->getByID($answer["FIELD_ID"])->Fetch();
		$fieldXmlId = Field::getInstance()->getXmlId(Field::getInstance()->createId($field['ID']));

		$xmlid = $fieldXmlId . static::XML_DELIMITER . $message;

		return $xmlid;
	}


	public function update(Record $record)
	{
		$data = $this->recordToArray($record);
		$id = $record->getId()->getValue();
		global $strError;
		$strError = '';
		$formAnswer = new \CFormAnswer();
		$result = $formAnswer->set($data, $id);
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
			'MESSAGE' => static::decodeMessage($record->getFieldRaw('MESSAGE_ENC')),
			'VALUE' => $record->getFieldRaw('VALUE'),
			'FIELD_TYPE' => $record->getFieldRaw('FIELD_TYPE'),
			'FIELD_WIDTH' => $record->getFieldRaw('FIELD_WIDTH'),
			'FIELD_HEIGHT' => $record->getFieldRaw('FIELD_HEIGHT'),
			'FIELD_PARAM' => $record->getFieldRaw('FIELD_PARAM'),
			'C_SORT' => $record->getFieldRaw('C_SORT'),
			'ACTIVE' => $record->getFieldRaw('ACTIVE'),
		);
		if ($field = $record->getDependency("FIELD"))
		{
			if ($field->getId())
			{
				$array["FIELD_ID"] = $field->getId()->getValue();
			}
		}
		return $array;
	}

	protected function createInner(Record $record)
	{
		$data = $this->recordToArray($record);
		global $strError;
		$strError = '';
		$formAnswer = new \CFormAnswer();
		$result = $formAnswer->set($data, "");
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
		$formAnswer = new \CFormAnswer();
		$formAnswer->delete($id->getValue());
	}

	/**
	 * @param string $message
	 * @return string
	 */
	protected static function encodeMessage($message)
	{
		return str_replace(' ', '&nbsp;', $message);
	}

	/**
	 * @param string $message
	 * @return string
	 */
	protected static function decodeMessage($encodedMessage)
	{
		return str_replace('&nbsp;', ' ', $encodedMessage);
	}
}