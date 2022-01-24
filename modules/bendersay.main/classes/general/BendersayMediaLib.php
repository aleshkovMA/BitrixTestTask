<?

IncludeModuleLangFile(__FILE__);

class	BendersayMediaLib	{

				public	function	GetUserTypeDescription()	{
								return	array(
												"PROPERTY_TYPE"	=>	"S",
												"USER_TYPE"	=>	'BendersayMediaLib',
												"DESCRIPTION"	=>	GetMessage('BendersayMediaLib_DESCRIPTION'),
												"GetPropertyFieldHtml"	=>	array(__CLASS__,	"GetPropertyFieldHtml"),
												//  "GetPropertyFieldHtmlMulty" => array(__CLASS__, 'GetPropertyFieldHtmlMulty'),
												"GetSettingsHTML"	=>	array(__CLASS__,	'GetSettingsHTML'),
												"PrepareSettings" => array(__CLASS__, 'PrepareSettings'),
												"GetAdminListViewHTML"	=>	array(__CLASS__,	'GetAdminListViewHTML'),
												"GetPublicViewHTML"	=>	array(__CLASS__,	'GetPublicViewHTML'),
											//	"GetPublicEditHTML"	=>	array(__CLASS__,	'GetPublicEditHTML'),
												"CheckFields"	=>	array(__CLASS__,	'CheckFields'),
												"ConvertToDB"	=>	array(__CLASS__,	'ConvertToDB'),
												"ConvertFromDB"	=>	array(__CLASS__,	'ConvertFromDB')
								);
				}
				
				/**
				 * 
				 * Сохраняет деволтные настройки свойства в  инфоблока
				 *
				 * @param type $arProperty
				 * @return type
				 */
				function PrepareSettings($arProperty) {

								$type = 0;
								if (is_array($arProperty["USER_TYPE_SETTINGS"])) {
												$type = intval($arProperty["USER_TYPE_SETTINGS"]["type"]);
								}

								return array(
												"type" => $type
								);
				}

				/*
					*  В списке элементов (режим просмотра)
					*/
				function	GetAdminListViewHTML($arProperty,	$value,	$strHTMLControlName)	{

								if	(empty($value['VALUE']))	{
												return	'&nbsp;';
								}	else	{

												$str	= $value['VALUE']['type'];
												return	$str;
								}
				}

				function	GetPublicViewHTML($arProperty,	$value,	$strHTMLControlName)	{
								return	$value["VALUE"];
				}
				
				/*
					*  Сохраняет значение свойства.
					*/
				public	function	ConvertToDB($arProperty,	$value)	{
								
								$result	=	array();
								if	(!empty($value['VALUE']))	{
												// Если все значения пустые, удаляем из БД
												if	(strlen($value['VALUE']['type'])	==	0)	{
																return	$result;
												}
												// Преобразуем в строку для хранения
												$result['VALUE']	=	serialize($value['VALUE']);
								}
								return	$result;
								
				}

				/*
					*  Извлекает значение свойства.
					*/
				public	function	ConvertFromDB($arProperty,	$value)	{
								
								$result	=	array();
								if	(!empty($value['VALUE']))	{
												// Преобразуем
												$result['VALUE']	=	unserialize($value['VALUE']);
								}
								return	$result;
								
				}

				/*
					* Массив сообщений об ошибках или пустой массив.
					*/
				function	CheckFields($arProperty,	$value)	{
								
								$arResult	=	array();
								// Если в инфоблоке = массив, в элементе = строка serialize
								if	(is_array($arProperty['USER_TYPE_SETTINGS']))	{
												if (empty($arProperty['USER_TYPE_SETTINGS'])) {
																$arResult[]	=	GetMessage("BendersayMediaLib_required");
												}
												
								}	else	{

								}

								return	$arResult;
				}

				/*
					* настрофки инфоблока
					*/
				function	GetSettingsHTML($arProperty,	$strHTMLControlName,	&$arPropertyFields)	{

								CModule::IncludeModule("fileman");
								CMedialib::Init();

								$arRes	=	CMedialib::GetTypes(array(),	true);
								
								$arPropertyFields = array(
												"HIDE" => array("ROW_COUNT", "COL_COUNT", "DEFAULT_VALUE", "MULTIPLE_CNT", "WITH_DESCRIPTION", "FILTRABLE", "SEARCHABLE"),
												"SET" => array("FILTRABLE" => "N", 'SEARCHABLE' => 'N', 'MULTIPLE_CNT' => 1),
									//			"USER_TYPE_SETTINGS_TITLE" => GetMessage("BendersayMediaLib_type")
								);
								
								$type = 0;
								if (is_array($arProperty["USER_TYPE_SETTINGS"])) {
												$type = intval($arProperty["USER_TYPE_SETTINGS"]["type"]);
								}

								$str = '<tr valign="top">
												<td>'.GetMessage("BendersayMediaLib_type").':</td>
                            <td><select name="' . $strHTMLControlName["NAME"] . '[type]">';
								foreach	($arRes	as	$value)	{
												$str .= '<option value="'.$value['id']. '" ';
												if ($type == $value['id']) {
																$str .= 'selected ' ;
												} 
												$str .= '>('.$value['id'].') '.$value['name'].'</option>';
								}
												
								$str .= '</select></td>
                   </tr>';
								return	$str;
				}

				/*
					* Редактирует на странице элемента
					*/
				function	GetPropertyFieldHtml($arProperty,	$value,	$strHTMLControlName)	{
								
								CModule::IncludeModule("fileman");
								CMedialib::Init();

								$new_val	=	'';
								if	(!empty($value['VALUE']))	{
												
								}	else	{
												$new_val	.=	'<p class="AMGnewValue">'	.	GetMessage("AMG_NEW_VALUE")	.	'</p>';
								}
								
								$arRes = CMedialibCollection::GetList(array('arFilter' => array('ACTIVE' => 'Y', 'ML_TYPE' => $arProperty['USER_TYPE_SETTINGS']['type']), 'arOrder' => array('NAME' => 'ASC')));
								
								$type = 0;
								if (!empty($value['VALUE'])) {
												$type = $value['VALUE']['type'];
								}

								$str = '<tr valign="top">
                            <td><select name="' . $strHTMLControlName["VALUE"] . '[type]">'
																.'<option value="">'	.	GetMessage("BendersayMediaLib_def_select")	.	'</option>';

								foreach	($arRes	as	$col)	{
												$str .= '<option value="'.$col['ID']. '" ';
												if ($type == $col['ID']) {
																$str .= 'selected ' ;
												} 
												$str .= '>('.$col['ID'].') '.$col['NAME'].'</option>';
								}
												
								$str .= '</select></td>
                   </tr>';
								return	$str;
				}

}

?>
