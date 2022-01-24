<?

IncludeModuleLangFile(__FILE__);

Class	bendersay_main	extends	CModule	{

				const	MODULE_ID	=	'bendersay.main';

				var	$MODULE_ID	=	'bendersay.main';
				var	$MODULE_VERSION;
				var	$MODULE_VERSION_DATE;
				var	$MODULE_NAME;
				var	$MODULE_DESCRIPTION;
				var	$MODULE_CSS;
				var	$strError	=	'';
				public	$PARTNER_NAME;
				public	$PARTNER_URI;

				function	__construct()	{
								$arModuleVersion	=	array();
								include(dirname(__FILE__)	.	"/version.php");
								$this->MODULE_VERSION	=	$arModuleVersion["VERSION"];
								$this->MODULE_VERSION_DATE	=	$arModuleVersion["VERSION_DATE"];
								$this->MODULE_NAME	=	GetMessage("bendersay.main_MODULE_NAME");
								$this->MODULE_DESCRIPTION	=	GetMessage("bendersay.main_MODULE_DESC");

								$this->PARTNER_NAME	=	GetMessage("bendersay.main_PARTNER_NAME");
								$this->PARTNER_URI	=	GetMessage("bendersay.main_PARTNER_URI");
				}

				function	InstallDB($arParams	=	array())	{
								RegisterModuleDependences('main',	'OnBuildGlobalMenu',	self::MODULE_ID,	'CBendersayMain',	'OnBuildGlobalMenu');
								return	true;
				}

				function	UnInstallDB($arParams	=	array())	{
								UnRegisterModuleDependences('main',	'OnBuildGlobalMenu',	self::MODULE_ID,	'CBendersayMain',	'OnBuildGlobalMenu');
								return	true;
				}

				function	InstallEvents()	{
								return	true;
				}

				function	UnInstallEvents()	{
								return	true;
				}

				function	InstallFiles($arParams	=	array())	{
								if	(is_dir($p	=	$_SERVER['DOCUMENT_ROOT']	.	'/bitrix/modules/'	.	self::MODULE_ID	.	'/admin'))	{
												if	($dir	=	opendir($p))	{
																while	(false	!==	$item	=	readdir($dir))	{
																				if	($item	==	'..'	||	$item	==	'.'	||	$item	==	'menu.php')
																								continue;
																				file_put_contents($file	=	$_SERVER['DOCUMENT_ROOT']	.	'/bitrix/admin/'	.	self::MODULE_ID	.	'_'	.	$item,	'<'	.	'? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/'	.	self::MODULE_ID	.	'/admin/'	.	$item	.	'");?'	.	'>');
																}
																closedir($dir);
												}
								}
								if	(is_dir($p	=	$_SERVER['DOCUMENT_ROOT']	.	'/bitrix/modules/'	.	self::MODULE_ID	.	'/install/components'))	{
												if	($dir	=	opendir($p))	{
																while	(false	!==	$item	=	readdir($dir))	{
																				if	($item	==	'..'	||	$item	==	'.')
																								continue;
																				CopyDirFiles($p	.	'/'	.	$item,	$_SERVER['DOCUMENT_ROOT']	.	'/bitrix/components/'	.	$item,	$ReWrite	=	True,	$Recursive	=	True);
																}
																closedir($dir);
												}
								}
								if	(is_dir($p	=	$_SERVER['DOCUMENT_ROOT']	.	'/bitrix/modules/'	.	self::MODULE_ID	.	'/install/js'))	{
												CopyDirFiles($_SERVER['DOCUMENT_ROOT']	.	'/bitrix/modules/bendersay.main/install/js/',	$_SERVER['DOCUMENT_ROOT']	.	'/bitrix/js/',	true,	true);
								}
								return	true;
				}

				function	UnInstallFiles()	{
								if	(is_dir($p	=	$_SERVER['DOCUMENT_ROOT']	.	'/bitrix/modules/'	.	self::MODULE_ID	.	'/admin'))	{
												if	($dir	=	opendir($p))	{
																while	(false	!==	$item	=	readdir($dir))	{
																				if	($item	==	'..'	||	$item	==	'.')
																								continue;
																				unlink($_SERVER['DOCUMENT_ROOT']	.	'/bitrix/admin/'	.	self::MODULE_ID	.	'_'	.	$item);
																}
																closedir($dir);
												}
								}
								if	(is_dir($p	=	$_SERVER['DOCUMENT_ROOT']	.	'/bitrix/modules/'	.	self::MODULE_ID	.	'/install/components'))	{
												if	($dir	=	opendir($p))	{
																while	(false	!==	$item	=	readdir($dir))	{
																				if	($item	==	'..'	||	$item	==	'.'	||	!is_dir($p0	=	$p	.	'/'	.	$item))
																								continue;

																				$dir0	=	opendir($p0);
																				while	(false	!==	$item0	=	readdir($dir0))	{
																								if	($item0	==	'..'	||	$item0	==	'.')
																												continue;
																								DeleteDirFilesEx('/bitrix/components/'	.	$item	.	'/'	.	$item0);
																				}
																				closedir($dir0);
																}
																closedir($dir);
												}
								}
								DeleteDirFilesEx('/bitrix/js/bendersay.main/');

								return	true;
				}

				function	DoInstall()	{
								global	$APPLICATION;
								$this->InstallFiles();
								$this->InstallDB();
								RegisterModule(self::MODULE_ID);
								// Регистрируем класс нового типа свойства для инфоблока
								RegisterModuleDependences("main",	"OnUserTypeBuildList",	$this->MODULE_ID,	"BendersayYandexMap",	"GetUserTypeDescription");
								RegisterModuleDependences("iblock", "OnIBlockPropertyBuildList", $this->MODULE_ID, "BendersayMediaLib", "GetUserTypeDescription");
				}

				function	DoUninstall()	{
								global	$APPLICATION;
								UnRegisterModule(self::MODULE_ID);
								// Убираем регистрацию класс нового типа свойства для инфоблока
								UnRegisterModuleDependences("main",	"OnUserTypeBuildList",	$this->MODULE_ID,	"BendersayYandexMap",	"GetUserTypeDescription");
								UnRegisterModuleDependences("iblock", "OnIBlockPropertyBuildList", $this->MODULE_ID, "BendersayMediaLib", "GetUserTypeDescription");
								$this->UnInstallDB();
								$this->UnInstallFiles();
				}

}

?>
