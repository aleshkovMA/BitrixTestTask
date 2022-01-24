{"version":3,"sources":["core_autosave.js"],"names":["window","topWindow","BX","PageObject","getRootWindow","CAutoSave","params","this","FORM_NAME","form","FORM_MARKER","form_marker","FORM_ID","form_id","PERIOD","period","RESTORE_DATA","TIMERS","bInited","bRestoreInProgress","DISABLE_STANDARD_NOTIFY","NOTIFY_CONTEXT","ready","defer","Prepare","garbage","delegate","Clear","type","isNotEmptyString","formMarker","name","addCustomEvent","proxy","Reset","prototype","i","isString","FORM","document","forms","isDomNode","BXAUTOSAVE","bind","ClearTimers","elements","length","RegisterInput","setTimeout","_PrepareAfter","inp","Init","UnRegisterInput","unbind","onCustomEvent","id","Math","random","Restore","o","_NotifyContext","Notify","message","util","urlencode","clearTimeout","TimerHandler","setInterval","Save","clearInterval","isNodeInDom","j","el","data","autosave_id","form_data","n","v","t","toLowerCase","checked","value","substring","options","selected","push","indexOf","_encodeName","ajax","post","bitrix_sessid","_Save","clicker","_decodeData","undefined","isArray","shift","bChange","fireEvent","q","in_array","hideNotify","parentNode","WindowManager","Get","adminPanel","admin","panel","exec","replace","str_pad_left","charCodeAt","toString","_decodeName","String","fromCharCode","parseInt","d"],"mappings":"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","file":"core_autosave.map.js"}