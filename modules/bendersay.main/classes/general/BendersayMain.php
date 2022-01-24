<?

class BendersayMain {

	const MODULE_ID = 'bendersay.main';

	/** Склонение существительных с числительными
	 * @param int $n число
	 * @param string $form1 Единственная форма: 1 секунда
	 * @param string $form2 Двойственная форма: 2 секунды
	 * @param string $form5 Множественная форма: 5 секунд
	 * @return string Правильная форма
	 */
	public static function PluralForm($n, $form1, $form2, $form5) {
		$n = abs($n) % 100;
		$n1 = $n % 10;
		if ($n > 10 && $n < 20)
			return $form5;
		if ($n1 > 1 && $n1 < 5)
			return $form2;
		if ($n1 == 1)
			return $form1;
		return $form5;
	}

	/** Обрезка строки по слову
	 * 
	 * @param string $string входная строка
	 * @param int $maxlen сколько символов оставляем
	 * @param string $end добавляемая строка к концу строки, при обрезке. По умолчанию "..."
	 * @param string $type тип передаваемой строки, TEXT или HTML. По умолчанию TEXT
	 * @return string Готовая строка
	 */
	public static function CutString($string, $maxlen, $end = '...', $type = 'TEXT') {
		$maxlen = (int) $maxlen;
		if ($type == 'TEXT') {
			$len = (mb_strlen($string) > $maxlen) ? mb_strripos(mb_substr($string, 0, $maxlen), ' ') : $maxlen;
			$cutStr = mb_substr($string, 0, $len);
			return (mb_strlen($string) > $maxlen) ? $cutStr . $end : $cutStr;
		} else {
			$obParser = new CTextParser;
			$str = $obParser->html_cut($string, $maxlen);
			return str_replace('...', $end, $str);
		}
	}

	/** Возвращает значение для компонета bitrix:catalog.smart.filter
	 * 
	 * Если не передавать ID элемента работает для свойств типа список. 
	 * Если передать, работает для списка, значения списка, строки, привязка к элементу.
	 * 
	 * Возвращает FALSE в случае неудачи.
	 * 
	 * @param int $IBLOCK_ID ID информационого блока
	 * @param int|string $prop ID или символьный код свойства
	 * @param int $valID ID элемента, если нужно получить значение для конкретного элемента. По умолчанию false
	 * @param string $FILTER_NAME Имя фильтра. По умолчанию arrFilter
	 * @return array Массив со значениями для фильтра
	 */
	public static function GetSmartFilterValue($IBLOCK_ID, $prop, $valID = false, $FILTER_NAME = 'arrFilter') {

		$result = array();

		$resProperty = CIBlockProperty::GetByID($prop, $IBLOCK_ID, false)->Fetch();

		if ($resProperty) {

			if (!(int) $valID) {

				switch ($resProperty['PROPERTY_TYPE']) {
					// Для списка возвращаем массив всех возможных значений
					case 'L':
						$db_enum_list = CIBlockProperty::GetPropertyEnum($prop, Array(), Array("IBLOCK_ID" => $IBLOCK_ID));
						while ($res = $db_enum_list->Fetch()) {
							$result[$FILTER_NAME . '_' . $resProperty['ID']][$res['ID']] = abs(crc32($res['ID']));
						}
						break;
					default:
						return FALSE;
				}

				return $result;
			} else {

				$arSelect = array('ID', 'PROPERTY_' . $prop);
				$arFilter = array('IBLOCK_ID' => $IBLOCK_ID, 'ID' => $valID);
				$resElem = CIBlockElement::GetList(array('sort' => 'asc'), $arFilter, false, false, $arSelect)->Fetch();

				if ($resElem) {
					switch ($resProperty['PROPERTY_TYPE']) {
						case 'L':
							$res = CIBlockProperty::GetPropertyEnum(
									$prop, Array(), Array(
									"IBLOCK_ID" => $IBLOCK_ID,
									'ID' => $resElem['PROPERTY_' . strtoupper($prop) . '_ENUM_ID']
									)
								)->Fetch();
							if ($res) {
								$real_val = $resElem['PROPERTY_' . strtoupper($prop) . '_VALUE'];
								$result[$FILTER_NAME . '_' . $resProperty['ID']]['ID'] = $res['ID'];
								$result[$FILTER_NAME . '_' . $resProperty['ID']]['NAME'] = $FILTER_NAME . '_' . $resProperty['ID'];
								$result[$FILTER_NAME . '_' . $resProperty['ID']]['hash'] = abs(crc32($res['ID']));
								$result[$FILTER_NAME . '_' . $resProperty['ID']]['val'] = abs(crc32($res['ID']));
								$result[$FILTER_NAME . '_' . $resProperty['ID']]['real_val'] = $real_val;
							}
							break;
						case 'S':
							$real_val = $resElem['PROPERTY_' . strtoupper($prop) . '_VALUE'];
							$hash = abs(crc32($resElem['PROPERTY_' . strtoupper($prop) . '_VALUE']));
							$key = $resElem['PROPERTY_' . strtoupper($prop) . '_VALUE_ID'];
							$result[$FILTER_NAME . '_' . $resProperty['ID'] . '_' . $hash]['ID'] = $key;
							$result[$FILTER_NAME . '_' . $resProperty['ID'] . '_' . $hash]['NAME'] = $FILTER_NAME . '_' . $resProperty['ID'] . '_' . $hash;
							$result[$FILTER_NAME . '_' . $resProperty['ID'] . '_' . $hash]['hash'] = $hash;
							$result[$FILTER_NAME . '_' . $resProperty['ID'] . '_' . $hash]['val'] = 'Y';
							$result[$FILTER_NAME . '_' . $resProperty['ID'] . '_' . $hash]['real_val'] = $real_val;
							break;
						case 'E':
							$real_val = $resElem['PROPERTY_' . strtoupper($prop) . '_VALUE'];
							$hash = abs(crc32($resElem['PROPERTY_' . strtoupper($prop) . '_VALUE']));
							$key = $resElem['PROPERTY_' . strtoupper($prop) . '_VALUE_ID'];
							$result[$FILTER_NAME . '_' . $resProperty['ID']]['ID'] = $key;
							$result[$FILTER_NAME . '_' . $resProperty['ID']]['NAME'] = $FILTER_NAME . '_' . $resProperty['ID'];
							$result[$FILTER_NAME . '_' . $resProperty['ID']]['hash'] = $hash;
							$result[$FILTER_NAME . '_' . $resProperty['ID']]['val'] = $hash;
							$result[$FILTER_NAME . '_' . $resProperty['ID']]['real_val'] = $real_val;
							break;
						default:
							return FALSE;
					}
					return $result;
				} else {
					return FALSE;
				}
			}
		} else {
			return FALSE;
		}
	}

	/** Форматирует вес, с учетом Единицы веса в каталоге товаров, модуля Интернет-магазин
	 * @param int $weight Вес в граммах
	 * @param bool $suf Возвращать только цифры. По умолчанию FALSE.
	 * @param string $weight_unit Обозначение единицы веса
	 * @param int $weight_koef Коэффициент единицы веса к грамму
	 * @return string Отформатированная строка. В случае ошибки FALSE.
	 * 
	 */
	public static function FormatWeight($weight, $suf = FALSE, $weight_unit = FALSE, $weight_koef = FALSE) {

		if ((int) $weight) {
			if (!$weight_unit) {
				$weight_unit = htmlspecialcharsbx(COption::GetOptionString('sale', 'weight_unit', false, SITE_ID));
			}
			if (!$weight_koef) {
				$weight_koef = htmlspecialcharsbx(COption::GetOptionString('sale', 'weight_koef', 1, SITE_ID));
			}
			if (!$suf) {
				return roundEx(DoubleVal((int) $weight / $weight_koef), SALE_WEIGHT_PRECISION) . " " . $weight_unit;
			} else {
				return roundEx(DoubleVal((int) $weight / $weight_koef), SALE_WEIGHT_PRECISION);
			}
		} else {
			return FALSE;
		}
	}

	/** Подключает JS для карт
	 * 
	 */
	public static function GetJsYandexMap() {
		global $APPLICATION;
		$APPLICATION->AddHeadScript('//api-maps.yandex.ru/2.1/?lang=ru_RU', true);
		$APPLICATION->AddHeadScript( '/bitrix/js/' . self::MODULE_ID . '/YandexMap.js', true);
	}

	/** Подключает JS модуля
	 * 
	 */
	public static function GetJs() {
		global $APPLICATION;
		$APPLICATION->AddHeadScript('/bitrix/js/bendersay.main/main.js', true);
	}

}
