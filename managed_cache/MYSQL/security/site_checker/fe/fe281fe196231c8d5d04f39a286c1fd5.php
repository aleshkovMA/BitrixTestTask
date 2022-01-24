<?
if($INCLUDE_FROM_CACHE!='Y')return false;
$datecreate = '001643028992';
$dateexpire = '001645620992';
$ser_content = 'a:2:{s:7:"CONTENT";s:0:"";s:4:"VARS";a:2:{s:7:"results";a:7:{i:0;a:5:{s:5:"title";s:77:"Используются устаревшие модули платформы";s:8:"critical";s:5:"HIGHT";s:6:"detail";s:55:"Доступны новые версии модулей";s:14:"recommendation";s:275:"Рекомендуется своевременно обновлять модули платформы, установить рекомендуемые обновления: <a href="/bitrix/admin/update_system.php" target="_blank">Обновление платформы</a>";s:15:"additional_info";s:198:"Модули для которых доступны обновления:<br>fileman<br />
iblock<br />
translate<br />
seo<br />
socialservices<br />
clouds<br />
mobileapp<br />
rest<br />
landing";}i:1;a:5:{s:5:"title";s:113:"Разрешено отображение сайта во фрейме с произвольного домена";s:8:"critical";s:6:"MIDDLE";s:6:"detail";s:307:"Запрет отображения фреймов сайта со сторонних доменов способен предотвратить целый класс атак, таких как <a href="https://www.owasp.org/index.php/Clickjacking" target="_blank">Clickjacking</a>, Framesniffing и т.д.";s:14:"recommendation";s:1875:"Скорее всего, вам будет достаточно разрешения на просмотр сайта в фреймах только на страницах текущего сайта.
Сделать это достаточно просто, достаточно добавить заголовок ответа "X-Frame-Options: SAMEORIGIN" в конфигурации вашего frontend-сервера.
</p><p>В случае использования nginx:<br>
1. Найти секцию server, отвечающую за обработку запросов нужного сайта. Зачастую это файлы в /etc/nginx/site-enabled/*.conf<br>
2. Добавить строку:
<pre>
add_header X-Frame-Options SAMEORIGIN;
</pre>
3. Перезапустить nginx<br>
Подробнее об этой директиве можно прочесть в документации к nginx: <a href="http://nginx.org/ru/docs/http/ngx_http_headers_module.html" target="_blank">Модуль ngx_http_headers_module</a>
</p><p>В случае использования Apache:<br>
1. Найти конфигурационный файл для вашего сайта, зачастую это файлы /etc/apache2/httpd.conf, /etc/apache2/vhost.d/*.conf<br>
2. Добавить строки:
<pre>
&lt;IfModule headers_module&gt;
	Header set X-Frame-Options SAMEORIGIN
&lt;/IfModule&gt;
</pre>
3. Перезапустить Apache<br>
4. Убедиться, что он корректно обрабатывается Apache и этот заголовок никто не переопределяет<br>
Подробнее об этой директиве можно прочесть в документации к Apache: <a href="http://httpd.apache.org/docs/2.2/mod/mod_headers.html" target="_blank">Apache Module mod_headers</a>
</p>";s:15:"additional_info";s:1830:"Адрес: <a href="http://lnkrayon.ru/" target="_blank">http://lnkrayon.ru/</a><br>Запрос/Ответ: <pre>GET / HTTP/1.1
host: lnkrayon.ru
accept: */*
user-agent: BitrixCloud BitrixSecurityScanner/Robin-Scooter

HTTP/1.1 200 OK
Server: openresty/1.13.6.2
Date: Thu, 01 Aug 2019 04:08:58 GMT
Content-Type: text/html; charset=UTF-8
Content-Length: 268492
Connection: keep-alive
Vary: Accept-Encoding
X-Powered-By: PHP/7.1.25
ETag: 54e59dca6c8b31918301a89ede335a21
Expires: Fri, 07 Jun 1974 04:00:00 GMT
Last-Modified: Wed, 31 Jul 2019 12:48:25 GMT
X-Bitrix-Composite: Cache (200)

&lt;!DOCTYPE html&gt;
&lt;html&gt;
&lt;head&gt;
    &lt;title&gt;Официальный сайт Администрации Ленинск-Кузнецкого &lt;/title&gt;
    &lt;meta property=&quot;og:title&quot; content=&quot;&quot;&gt;
    &lt;meta property=&quot;og:description&quot; content=&quot;&quot;&gt;
    &lt;meta property=&quot;og:image&quot; content=&quot;&quot;&gt;
    &lt;!-- Global site tag (gtag.js) - Google Analytics --&gt;
&lt;script async src=&quot;https://www.googletagmanager.com/gtag/js?id=UA-112752366-1&quot;&gt;&lt;/script&gt;
&lt;script&gt;
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag(\'js\', new Date());

    gtag(\'config\', \'UA-112752366-1\');
&lt;/script&gt;

&lt;!-- Yandex.Metrika counter --&gt;
&lt;script type=&quot;text/javascript&quot; &gt;
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter47253615 = new Ya.Metrika({
                    id:47253615,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true
                });
   
----------Only 1Kb of body shown----------<pre>";}i:2;a:5:{s:5:"title";s:68:"Разрешено чтение файлов по URL (URL wrappers)";s:8:"critical";s:6:"MIDDLE";s:6:"detail";s:256:"Если эта, сомнительная, возможность PHP не требуется - рекомендуется отключить, т.к. она может стать отправной точкой для различного типа атак";s:14:"recommendation";s:89:"Необходимо в настройках php указать:<br>allow_url_fopen = Off";s:15:"additional_info";s:0:"";}i:3;a:5:{s:5:"title";s:110:"Установлен не корректный порядок формирования массива _REQUEST";s:8:"critical";s:6:"MIDDLE";s:6:"detail";s:392:"Зачастую в массив _REQUEST нет необходимости добавлять любые переменные, кроме массивов _GET и _POST. В противном случае это может привести к раскрытию информации о пользователе/сайте и иным не предсказуемым последствиям.";s:14:"recommendation";s:88:"Необходимо в настройках php указать:<br>request_order = "GP"";s:15:"additional_info";s:75:"Текущее значение: ""<br>Рекомендованное: "GP"";}i:4;a:5:{s:5:"title";s:119:"Временные файлы хранятся в пределах корневой директории проекта";s:8:"critical";s:6:"MIDDLE";s:6:"detail";s:271:"Хранение временных файлов, создаваемых при использовании CTempFile, в пределах корневой директории проекта не рекомендовано и несет с собой ряд рисков.";s:14:"recommendation";s:883:"Необходимо определить константу "BX_TEMPORARY_FILES_DIRECTORY" в "bitrix/php_interface/dbconn.php" с указанием необходимого пути.<br>
Выполните следующие шаги:<br>
1. Выберите директорию вне корня проекта. Например, это может быть "/home/bitrix/tmp/www"<br>
2. Создайте ее. Для этого выполните следующую комманду:
<pre>
mkdir -p -m 700 /полный/путь/к/директории
</pre>
3. В файле "bitrix/php_interface/dbconn.php" определите соответствующую константу, чтобы система начала использовать эту директорию:
<pre>
define("BX_TEMPORARY_FILES_DIRECTORY", "/полный/путь/к/директории");
</pre>";s:15:"additional_info";s:81:"Текущая директория: /home/h811082715/lnkrayon.ru/docs/upload/tmp";}i:5;a:5:{s:5:"title";s:44:"Включен Automatic MIME Type Detection";s:8:"critical";s:3:"LOW";s:6:"detail";s:248:"По умолчанию в Internet Explorer/FlashPlayer включен автоматический mime-сниффинг, что может служить источником XSS нападения или раскрытия информации.";s:14:"recommendation";s:1752:"Скорее всего, вам не нужна эта функция, поэтому её можно безболезненно отключить, добавив заголовок ответа "X-Content-Type-Options: nosniff" в конфигурации вашего веб-сервера.
</p><p>В случае использования nginx:<br>
1. Найти секцию server, отвечающую за обработку запросов нужного сайта. Зачастую это файлы в /etc/nginx/site-enabled/*.conf<br>
2. Добавить строку:
<pre>
add_header X-Content-Type-Options nosniff;
</pre>
3. Перезапустить nginx<br>
Подробнее об этой директиве можно прочесть в документации к nginx: <a href="http://nginx.org/ru/docs/http/ngx_http_headers_module.html" target="_blank">Модуль ngx_http_headers_module</a>
</p><p>В случае использования Apache:<br>
1. Найти конфигурационный файл для вашего сайта, зачастую это файлы /etc/apache2/httpd.conf, /etc/apache2/vhost.d/*.conf<br>
2. Добавить строки:
<pre>
&lt;IfModule headers_module&gt;
	Header set X-Content-Type-Options nosniff
&lt;/IfModule&gt;
</pre>
3. Перезапустить Apache<br>
4. Убедиться, что он корректно обрабатывается Apache и этот заголовок никто не переопределяет<br>
Подробнее об этой директиве можно прочесть в документации к Apache: <a href="http://httpd.apache.org/docs/2.2/mod/mod_headers.html" target="_blank">Apache Module mod_headers</a>
</p>";s:15:"additional_info";s:1780:"Адрес: <a href="http://lnkrayon.ru/bitrix/js/main/core/core.js?rnd=0.913756226183" target="_blank">http://lnkrayon.ru/bitrix/js/main/core/core.js?rnd=0.913756226183</a><br>Запрос/Ответ: <pre>GET /bitrix/js/main/core/core.js?rnd=0.913756226183 HTTP/1.1
host: lnkrayon.ru
accept: */*
user-agent: BitrixCloud BitrixSecurityScanner/Robin-Scooter

HTTP/1.1 200 OK
Server: openresty/1.13.6.2
Date: Thu, 01 Aug 2019 04:08:56 GMT
Content-Type: application/javascript
Content-Length: 123541
Connection: keep-alive
Last-Modified: Mon, 27 May 2019 09:53:05 GMT
Vary: Accept-Encoding
ETag: &quot;5cebb381-1e295&quot;
Accept-Ranges: bytes

if (typeof WeakMap === &quot;undefined&quot;)
{
	(function() {

		var counter = Date.now() % 1e9;

		var WeakMap = function(iterable)
		{
			this.name = &quot;__bx&quot; + (Math.random() * 1e9 &gt;&gt;&gt; 0) + counter++;
		};

		WeakMap.prototype =
		{
			set: function(key, value)
			{
				if (!this.isValid(key))
				{
					throw new TypeError(&quot;Invalid value used as weak map key&quot;);
				}

				var entry = key[this.name];
				if (entry &amp;&amp; entry[0] === key)
				{
					entry[1] = value;
				}
				else
				{
					Object.defineProperty(key, this.name, { value: [key, value], writable: true });
				}

				return this;
			},

			get: function(key)
			{
				if (!this.isValid(key))
				{
					return undefined;
				}

				var entry = key[this.name];

				return entry &amp;&amp; entry[0] === key ? entry[1] : undefined;
			},

			&quot;delete&quot;: function(key)
			{
				if (!this.isValid(key))
				{
					return false;
				}

				var entry = key[this.name];
				if (!entry)
				{
					return false;
				}
				var hasValue = entry[0] === key;
				entry[0] = entry[1] = u
----------Only 1Kb of body shown----------<pre>";}i:6;a:5:{s:5:"title";s:38:"Включен вывод ошибок";s:8:"critical";s:3:"LOW";s:6:"detail";s:202:"Вывод ошибок предназначен для разработки и тестовых стендов, он не должен использоваться на конечном ресурсе.";s:14:"recommendation";s:88:"Необходимо в настройках php указать:<br>display_errors = Off";s:15:"additional_info";s:0:"";}}s:9:"test_date";s:10:"01.08.2019";}}';
return true;
?>