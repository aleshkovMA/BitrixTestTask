<?php
IncludeModuleLangFile(__FILE__);

class BendersayYandexMap {

    /**
	 * Обработчик события OnUserTypeBuildList.
	 *
	 */
	public static function GetUserTypeDescription() {
        return array(
            "USER_TYPE_ID" => "BendersayYandexMap",
            "CLASS_NAME" => "BendersayYandexMap",
            "DESCRIPTION" => GetMessage("BENDER_YANDEX_MAP_DESCRIPTION"),
            "BASE_TYPE" => "string",
        );
    }
    
    /**
	 * Эта функция вызывается при добавлении нового свойства.
	 *
	 */
    public static function GetDBColumnType($arUserField) {
        global $DB;
        switch (strtolower($DB->type)) {
            case "mysql":
                return "text";
            case "oracle":
                return "varchar2(2000 char)";
            case "mssql":
                return "varchar(2000)";
        }
    }
    
    /**
     * Эта функция вызывается перед сохранением метаданных свойства в БД.
     *
     * <p>Она должна "очистить" массив с настройками экземпляра типа свойства.
     * Для того что бы случайно/намеренно никто не записал туда всякой фигни.</p>
     * @param array $arUserField Массив описывающий поле. <b>Внимание!</b> это описание поля еще не сохранено в БД!
     * @return array Массив который в дальнейшем будет сериализован и сохранен в БД.
     * @static
     */
    public static function PrepareSettings($arUserField) {

        return array( );
    }

    /**
     * Эта функция вызывается при выводе формы настройки свойства.
     *
     * <p>Возвращает html для встраивания в 2-х колоночную таблицу.
     * в форму usertype_edit.php</p>
     * <p>т.е. tr td bla-bla /td td edit-edit-edit /td /tr </p>
     * @param array $arUserField Массив описывающий поле. Для нового (еще не добавленного поля - <b>false</b>)
     * @param array $arHtmlControl Массив управления из формы. Пока содержит только один элемент NAME (html безопасный)
     * @return string HTML для вывода.
     * @static
     */
    public static function GetSettingsHTML($arUserField = false, $arHtmlControl, $bVarsFromForm) {
        $result = '';
        
        return false;
    }

    /**
     * Эта функция вызывается при выводе формы редактирования значения свойства.
     *
     * <p>Возвращает html для встраивания в ячейку таблицы.
     * в форму редактирования сущности (на вкладке "Доп. свойства")</p>
     * <p>Элементы $arHtmlControl приведены к html безопасному виду.</p>
     * @param array $arUserField Массив описывающий поле.
     * @param array $arHtmlControl Массив управления из формы. Содержит элементы NAME и VALUE.
     * @return string HTML для вывода.
     * @static
     */
    public static function GetEditFormHTML($arUserField, $arHtmlControl) {
        
            // Подрубаем jquery
            CJSCore::Init(array("jquery"));
            // Подрубаем JS
            BendersayMain::GetJsYandexMap();
        
            return '<script type="text/javascript">
                        $(function() {
                            // Работаем с кратой
                            ymaps.ready(function() {
                                var myMap,
                                    myPlacemark;

                                // Если значение пусто, показываем положение пользователя
                                if ($("#coords_" + "'.$arUserField["FIELD_NAME"].'").val() == "") {
                                    init("'.$arUserField["FIELD_NAME"].'");
                                } else {
                                    init("'.$arUserField["FIELD_NAME"].'", $("#coords_" + "'.$arUserField["FIELD_NAME"].'").val());
                                }
                            });
                        });
                    </script>'
                    . '<div id="map_'.$arUserField["FIELD_NAME"].'" style="width: 500px; height: 400px"></div>
                    <p><b YANDEX_Point_hover="'.GetMessage("YANDEX_Point_hover").'" class="YANDEX_Point_hover">'.GetMessage("YANDEX_MAP_COORDS").'</b><br>
                    <input name="'.$arUserField["FIELD_NAME"].'" id="coords_'.$arUserField["FIELD_NAME"].'" value="'.$arHtmlControl["VALUE"].'"></p>';
        
    }

    /**
     * Эта функция вызывается при выводе формы редактирования значения <b>множественного</b> свойства.
     *
     * <p>Если класс не предоставляет такую функцию,
     * то менеджер типов "соберет" требуемый html из вызовов GetEditFormHTML</p>
     * <p>Возвращает html для встраивания в ячейку таблицы.
     * в форму редактирования сущности (на вкладке "Доп. свойства")</p>
     * <p>Элементы $arHtmlControl приведены к html безопасному виду.</p>
     * <p>Поле VALUE $arHtmlControl - массив.</p>
     * @param array $arUserField Массив описывающий поле.
     * @param array $arHtmlControl Массив управления из формы. Содержит элементы NAME и VALUE.
     * @return string HTML для вывода.
     * @static
     */

    public static function GetEditFormHTMLMulty($arUserField, $arHtmlControl) {
        
        // Подрубаем jquery
        CJSCore::Init(array("jquery"));
        // Подрубаем JS
        BendersayMain::GetJsYandexMap();

        if (empty($arHtmlControl['VALUE'])) {
            return '<script type="text/javascript">
                        $(function() {
                            // Работаем с кратой
                            ymaps.ready(function() {
                                var myMap,
                                    myPlacemark;

                                // Если значение пусто, показываем положение пользователя
                                if ($("#coords_" + "'.$arUserField["FIELD_NAME"].'_0").val() == "") {
                                    init("'.$arUserField["FIELD_NAME"].'_0");
                                } else {
                                    init("'.$arUserField["FIELD_NAME"].'_0", $("#coords_" + "'.$arUserField["FIELD_NAME"].'_0").val());
                                }
                            });
                        });
                    </script>'
                    . '<div id="map_'.$arUserField["FIELD_NAME"].'_0" style="width: 500px; height: 400px"></div>
                    <p><b YANDEX_Point_hover="'.GetMessage("YANDEX_Point_hover").'" class="YANDEX_Point_hover">'.GetMessage("YANDEX_MAP_COORDS").'</b><br>
                    <input name="'.$arUserField["FIELD_NAME"].'[]" id="coords_'.$arUserField["FIELD_NAME"].'_0" value=""></p>'
                    . '<input type="button" value="Добавить" class="BendersayAddMap" key_name="'.$arUserField["FIELD_NAME"].'" key_i="0">';
        } else {
            $str = '';
            foreach ($arHtmlControl['VALUE'] as $key => $value) {
                $str .= '<script type="text/javascript">
                        $(function() {
                            // Работаем с кратой
                            ymaps.ready(function() {
                                var myMap,
                                    myPlacemark;

                                // Если значение пусто, показываем положение пользователя
                                if ($("#coords_" + "'.$arUserField["FIELD_NAME"].'_'.$key.'").val() == "") {
                                    init("'.$arUserField["FIELD_NAME"].'_'.$key.'");
                                } else {
                                    init("'.$arUserField["FIELD_NAME"].'_'.$key.'", $("#coords_" + "'.$arUserField["FIELD_NAME"].'_'.$key.'").val());
                                }
                            });
                        });
                    </script>'
                    . '<div id="map_'.$arUserField["FIELD_NAME"].'_'.$key.'" style="width: 500px; height: 400px"></div>
                    <p><b>'.GetMessage("YANDEX_MAP_COORDS").'</b><br>
                    <input name="'.$arUserField["FIELD_NAME"].'[]" id="coords_'.$arUserField["FIELD_NAME"].'_'.$key.'" value="'.$value.'"></p>';
            }
            $str .= '<input type="button" value="Добавить" class="BendersayAddMap" key_name="'.$arUserField["FIELD_NAME"].'" key_i="'.(count($arHtmlControl['VALUE'] ) - 1).'">';

            return $str;
        }

    }

    /**
     * Эта функция вызывается при выводе фильтра на странице списка.
     *
     * <p>Возвращает html для встраивания в ячейку таблицы.</p>
     * <p>Элементы $arHtmlControl приведены к html безопасному виду.</p>
     * @param array $arUserField Массив описывающий поле.
     * @param array $arHtmlControl Массив управления из формы. Содержит элементы NAME и VALUE.
     * @return string HTML для вывода.
     * @static
     */
    public static function GetFilterHTML($arUserField, $arHtmlControl) {
        return '<input type="text" ' .
                'name="' . $arHtmlControl["NAME"] . '" ' .
                'size="' . $arUserField["SETTINGS"]["SIZE"] . '" ' .
                'value="' . $arHtmlControl["VALUE"] . '"' .
                '>';
    }

    /**
     * Эта функция вызывается при выводе значения свойства в списке элементов.
     *
     * <p>Возвращает html для встраивания в ячейку таблицы.</p>
     * <p>Элементы $arHtmlControl приведены к html безопасному виду.</p>
     * @param array $arUserField Массив описывающий поле.
     * @param array $arHtmlControl Массив управления из формы. Содержит элементы NAME и VALUE.
     * @return string HTML для вывода.
     * @static
     */
    public static function GetAdminListViewHTML($arUserField, $arHtmlControl) {
        if (strlen($arHtmlControl["VALUE"]) > 0)
            return $arHtmlControl["VALUE"];
        else
            return '&nbsp;';
    }

    /**
     * Эта функция вызывается при выводе значения <b>множественного</b> свойства в списке элементов.
     *
     * <p>Возвращает html для встраивания в ячейку таблицы.</p>
     * <p>Если класс не предоставляет такую функцию,
     * то менеджер типов "соберет" требуемый html из вызовов GetAdminListViewHTML</p>
     * <p>Элементы $arHtmlControl приведены к html безопасному виду.</p>
     * <p>Поле VALUE $arHtmlControl - массив.</p>
     * @param array $arUserField Массив описывающий поле.
     * @param array $arHtmlControl Массив управления из формы. Содержит элементы NAME и VALUE.
     * @return string HTML для вывода.
     * @static
     */
    /*
      public static 	function GetAdminListViewHTMLMulty($arUserField, $arHtmlControl)
      {
      return implode(", ", $arHtmlControl["VALUE"]);
      }
     */

    /**
     * Эта функция вызывается при выводе значения свойства в списке элементов в режиме <b>редактирования</b>.
     *
     * <p>Возвращает html для встраивания в ячейку таблицы.</p>
     * <p>Элементы $arHtmlControl приведены к html безопасному виду.</p>
     * @param array $arUserField Массив описывающий поле.
     * @param array $arHtmlControl Массив управления из формы. Содержит элементы NAME и VALUE.
     * @return string HTML для вывода.
     * @static
     */
  /*  public static function GetAdminListEditHTML($arUserField, $arHtmlControl) {
        if ($arUserField["SETTINGS"]["ROWS"] < 2)
            return '<input type="text" ' .
                    'name="' . $arHtmlControl["NAME"] . '" ' .
                    'size="' . $arUserField["SETTINGS"]["SIZE"] . '" ' .
                    ($arUserField["SETTINGS"]["MAX_LENGTH"] > 0 ? 'maxlength="' . $arUserField["SETTINGS"]["MAX_LENGTH"] . '" ' : '') .
                    'value="' . $arHtmlControl["VALUE"] . '" ' .
                    '>';
        else
            return '<textarea ' .
                    'name="' . $arHtmlControl["NAME"] . '" ' .
                    'cols="' . $arUserField["SETTINGS"]["SIZE"] . '" ' .
                    'rows="' . $arUserField["SETTINGS"]["ROWS"] . '" ' .
                    ($arUserField["SETTINGS"]["MAX_LENGTH"] > 0 ? 'maxlength="' . $arUserField["SETTINGS"]["MAX_LENGTH"] . '" ' : '') .
                    '>' . $arHtmlControl["VALUE"] . '</textarea>';
    }*/

    /**
     * Эта функция вызывается при выводе <b>множественного</b> свойства в списке элементов в режиме <b>редактирования</b>.
     *
     * <p>Возвращает html для встраивания в ячейку таблицы.</p>
     * <p>Если класс не предоставляет такую функцию,
     * то менеджер типов "соберет" требуемый html из вызовов GetAdminListEditHTML</p>
     * <p>Элементы $arHtmlControl приведены к html безопасному виду.</p>
     * <p>Поле VALUE $arHtmlControl - массив.</p>
     * @param array $arUserField Массив описывающий поле.
     * @param array $arHtmlControl Массив управления из формы. Содержит элементы NAME и VALUE.
     * @return string HTML для вывода.
     * @static
     */
    /*
      public static 	function GetAdminListEditHTMLMulty($arUserField, $arHtmlControl)
      {
      $result = array();
      foreach($arHtmlControl["VALUE"] as $value)
      {
      if($arUserField["SETTINGS"]["ROWS"] < 2)
      $result[] = '<input type="text" '.
      'name="'.$arHtmlControl["NAME"].'" '.
      'size="'.$arUserField["SETTINGS"]["SIZE"].'" '.
      ($arUserField["SETTINGS"]["MAX_LENGTH"]>0? 'maxlength="'.$arUserField["SETTINGS"]["MAX_LENGTH"].'" ': '').
      'value="'.$value.'" '.
      '>';
      else
      $result[] = '<textarea '.
      'name="'.$arHtmlControl["NAME"].'" '.
      'cols="'.$arUserField["SETTINGS"]["SIZE"].'" '.
      'rows="'.$arUserField["SETTINGS"]["ROWS"].'" '.
      ($arUserField["SETTINGS"]["MAX_LENGTH"]>0? 'maxlength="'.$arUserField["SETTINGS"]["MAX_LENGTH"].'" ': '').
      '>'.$value.'</textarea>';
      }
      return '&nbsp;'.implode("<br>", $result);
      }
     */

    /**
     * Эта функция валидатор.
     *
     * <p>Вызывается из метода CheckFields объекта $USER_FIELD_MANAGER.</p>
     * <p>Который в свою очередь может быть вызван из меторов Add/Update сущности владельца свойств.</p>
     * <p>Выполняется 2 проверки:</p>
     * <ul>
     * <li>на минимальную длину (если в настройках минимальная длина больше 0).
     * <li>на регулярное выражение (если задано в настройках).
     * </ul>
     * @param array $arUserField Массив описывающий поле.
     * @param array $value значение для проверки на валидность
     * @return array массив массивов ("id","text") ошибок.
     * @static
     */
    public static function CheckFields($arUserField, $value) {
        $aMsg = array();
        
        return $aMsg;
    }

    /**
     * Эта функция должна вернуть представление значения поля для поиска.
     *
     * <p>Вызывается из метода OnSearchIndex объекта $USER_FIELD_MANAGER.</p>
     * <p>Который в свою очередь вызывается и функции обновления поискового индекса сущности.</p>
     * <p>Для множественных значений поле VALUE - массив.</p>
     * @param array $arUserField Массив описывающий поле.
     * @return string посковое содержимое.
     * @static
     */
    public static function OnSearchIndex($arUserField) {
        if (is_array($arUserField["VALUE"]))
            return implode("\r\n", $arUserField["VALUE"]);
        else
            return $arUserField["VALUE"];
    }

    /**
     * Эта функция вызывается перед сохранением значений в БД.
     *
     * <p>Вызывается из метода Update объекта $USER_FIELD_MANAGER.</p>
     * <p>Для множественных значений функция вызывается несколько раз.</p>
     * @param array $arUserField Массив описывающий поле.
     * @param mixed $value Значение.
     * @return string значение для вставки в БД.
     * @static
     */
    
    public static function OnBeforeSave($arUserField, $value) {
        if (strlen($value) > 0)
            return $value;
    }

}
