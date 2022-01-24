/** Перессылка метом AJAX формы с файлами
 * Внимание!
 * Функция является оберткой над стандартной jQuery функции $.ajax();
* @param string $formID ID формы
* @param function $obrres Функция которая обработает результат запроса
* @param string $url url, куда слать AJAX запрос
* @param string $type Метод запроса. По умолчанию POST
*  Пример Вызова:
*   AjaxFiles('ID', function(result) {
*        console.log(result);
*    });
*/
function AjaxFiles(formID, obrres, url, type ) {
    
    // По умолчанию
    type = type || 'POST';
    url = url || '';

    $.ajax({
        type: type,
        cache: false,
        url: url,    
        data: new FormData(document.getElementById(formID)),
        processData: false,
        contentType: false,
        success: function (data) {
             obrres(data);
        } // success
    }); // ajax 

}

/** Печатает выбранный элемент
 * Создает новое окно для печати, с переданным HTML содержимым
* @param string $data HTML содержимое выбранного блока
* @return bool True, если все хорошо
*  Пример Вызова:
*   Popup($('#ID')[0].outerHTML);
*/
function Popup(data) {
    var mywindow = window.open('', 'my div', 'height=600,width=800');

    mywindow.document.write('<html><head><title>' + $('title').text() + '</title>');
    /*optional stylesheet*/ //mywindow.document.write('<link rel="stylesheet" href="main.css" type="text/css" />');
    mywindow.document.write('</head><body >');
    mywindow.document.write(data);
    mywindow.document.write('</body></html>');

    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10

    mywindow.print();
    mywindow.close();

    return true;
}
    
/** Объединяем параметры из объекта обратно в строку
* @param object $param Объект с параметрами, пример: Object { ss="1", ddd="2"}
* @return string строка с параметрами
*/
function ParamToStr(param) {
    
    var str = '';
    
    for(var index in param) { 
        if (param.hasOwnProperty(index)) {
            str += index + '=' + param[index] + '&';
        }
    }
    
    str = str.substr(0, str.length - 1);
     
    return str;
    
}

/** Получаем все параметры из URL
* @return object Объект с параметрами, пример: Object { ss="1", ddd="2"}
*/
function ParseUrlQuery() {
    var data = {};
    if(location.search) {
        var pair = (location.search.substr(1)).split('&');
        for(var i = 0; i < pair.length; i ++) {
            var param = pair[i].split('=');
            data[param[0]] = param[1];
        }
    }
    return data;
}

/** устанавливает cookie c именем name и значением value
* @param string $name Имя куки
* @param string $value строка со значением
* @param object $options- объект с свойствами cookie (expires, path, domain, secure)
*/
function setCookie(name, value, options) {
  options = options || {};

  var expires = options.expires;

  if (typeof expires == "number" && expires) {
    var d = new Date();
    d.setTime(d.getTime() + expires*1000);
    expires = options.expires = d;
  }
  if (expires && expires.toUTCString) { 
  	options.expires = expires.toUTCString();
  }

  value = encodeURIComponent(value);

  var updatedCookie = name + "=" + value;

  for(var propName in options) {
    updatedCookie += "; " + propName;
    var propValue = options[propName];    
    if (propValue !== true) { 
      updatedCookie += "=" + propValue;
     }
  }

  document.cookie = updatedCookie;
}

/** возвращает cookie с именем name, если есть, если нет, то undefined
* @param string $name Имя куки
*/
function getCookie(name) {
  var matches = document.cookie.match(new RegExp(
    "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
  ));
  return matches ? decodeURIComponent(matches[1]) : undefined;
}

/** удаляет cookie с именем name
* @param string $name Имя куки
* @param object $options- объект с свойствами cookie (expires, path, domain, secure)
*/
function deleteCookie(name, options) {
  setCookie(name, "", options)
}
