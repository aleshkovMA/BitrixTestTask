function init(ID, value_cord) {
    
    var value_cord = value_cord || '';
    var ID = ID || '',
        myPlacemark = {};
    
    if (value_cord == '') {
        
        var geolocation = ymaps.geolocation,
            myMap = new ymaps.Map("map_" + ID, {
                center: [55, 34],
                zoom: 10,
                controls: ["zoomControl", "typeSelector", "fullscreenControl"]
            }, {
                searchControlProvider: "yandex#search"
            });
        // Определим текущее положение и добавим метку на карту
        geolocation.get({
            provider: "auto",
            mapStateAutoApply: true
        }).then(function (result) {
            result.geoObjects.options.set({
                preset: "islands#orangeDotIcon",
                draggable: true
            });
           
            // При перемещении записываем координаты
            result.geoObjects.events.add([
                "dragend"
            ], function (e) {
                // Переводим координаты страницы в глобальные пиксельные координаты.
                var markerGlobalPosition = myMap.converter.pageToGlobal(e.get("position")),
                        // Получаем центр карты в глобальных пиксельных координатах.
                        mapGlobalPixelCenter = myMap.getGlobalPixelCenter(),
                        // Получением размер контейнера карты на странице.
                        mapContainerSize = myMap.container.getSize(),
                        mapContainerHalfSize = [mapContainerSize[0] / 2, mapContainerSize[1] / 2],
                        // Вычисляем границы карты в глобальных пиксельных координатах.
                        mapGlobalPixelBounds = [
                            [mapGlobalPixelCenter[0] - mapContainerHalfSize[0], mapGlobalPixelCenter[1] - mapContainerHalfSize[1]],
                            [mapGlobalPixelCenter[0] + mapContainerHalfSize[0], mapGlobalPixelCenter[1] + mapContainerHalfSize[1]]
                        ];

                // Теперь переводим глобальные пиксельные координаты в геокоординаты с учетом текущего уровня масштабирования карты.
                var geoPosition = myMap.options.get("projection").fromGlobalPixels(markerGlobalPosition, myMap.getZoom());
                // Запишем координаты в input
                $("#coords_" + ID).val(geoPosition.join(","));
            });
            // Контент метки.
            result.geoObjects.get(0).properties.set('hintContent' , $('.YANDEX_Point_hover').attr('YANDEX_Point_hover'));
            // Запоминаем метку    
            myPlacemark.ID = result.geoObjects.get(0);
            // Добавим на карту
            myMap.geoObjects.add(result.geoObjects);
        });
        
    } else {

        var coords = value_cord.split(',');
        myMap = new ymaps.Map("map_" + ID, {
            center: [coords[0], coords[1]],
            zoom: 10,
            controls: ["zoomControl", "typeSelector", "fullscreenControl"]
        });
        // Создаем геообъект с типом геометрии "Точка".
        myPlacemark.ID = new ymaps.GeoObject({
            // Описание геометрии.
            geometry: {
                type: "Point",
                coordinates: [coords[0], coords[1]]
            },
            // Свойства.
            properties: {
                // Контент метки.
                hintContent: $('.YANDEX_Point_hover').attr('YANDEX_Point_hover')
            }
        }, {
            // Опции.
            // Иконка метки будет растягиваться под размер ее содержимого.
            preset: "islands#orangeDotIcon",
            // Метку можно перемещать.
            draggable: true
        });
        
        myPlacemark.ID.events.add('dragend', function (e) {
            // Переводим координаты страницы в глобальные пиксельные координаты.
            var markerGlobalPosition = myMap.converter.pageToGlobal(e.get("position")),
                    // Получаем центр карты в глобальных пиксельных координатах.
                    mapGlobalPixelCenter = myMap.getGlobalPixelCenter(),
                    // Получением размер контейнера карты на странице.
                    mapContainerSize = myMap.container.getSize(),
                    mapContainerHalfSize = [mapContainerSize[0] / 2, mapContainerSize[1] / 2],
                    // Вычисляем границы карты в глобальных пиксельных координатах.
                    mapGlobalPixelBounds = [
                        [mapGlobalPixelCenter[0] - mapContainerHalfSize[0], mapGlobalPixelCenter[1] - mapContainerHalfSize[1]],
                        [mapGlobalPixelCenter[0] + mapContainerHalfSize[0], mapGlobalPixelCenter[1] + mapContainerHalfSize[1]]
                    ];

            // Теперь переводим глобальные пиксельные координаты в геокоординаты с учетом текущего уровня масштабирования карты.
            var geoPosition = myMap.options.get("projection").fromGlobalPixels(markerGlobalPosition, myMap.getZoom());
            // Запишем координаты в input
            $("#coords_" + ID).val(geoPosition.join(","));
        });
        
        myMap.geoObjects.add(myPlacemark.ID);
    }
    
    

    myMap.events.add("click", function (e) {
        // Переводим координаты страницы в глобальные пиксельные координаты.
        var markerGlobalPosition = myMap.converter.pageToGlobal(e.get("position")),
                // Получаем центр карты в глобальных пиксельных координатах.
                mapGlobalPixelCenter = myMap.getGlobalPixelCenter(),
                // Получением размер контейнера карты на странице.
                mapContainerSize = myMap.container.getSize(),
                mapContainerHalfSize = [mapContainerSize[0] / 2, mapContainerSize[1] / 2],
                // Вычисляем границы карты в глобальных пиксельных координатах.
                mapGlobalPixelBounds = [
                    [mapGlobalPixelCenter[0] - mapContainerHalfSize[0], mapGlobalPixelCenter[1] - mapContainerHalfSize[1]],
                    [mapGlobalPixelCenter[0] + mapContainerHalfSize[0], mapGlobalPixelCenter[1] + mapContainerHalfSize[1]]
                ];
        // Теперь переводим глобальные пиксельные координаты в геокоординаты с учетом текущего уровня масштабирования карты.
        var geoPosition = myMap.options.get("projection").fromGlobalPixels(markerGlobalPosition, myMap.getZoom());

        // Запишем координаты в input
        var coords = geoPosition.join(",");
        $("#coords_" + ID).val(coords);
        myPlacemark.ID.geometry.setCoordinates([geoPosition[0], geoPosition[1]]);

    });
}

$(function() {
    
    /*
     * Добавление карты во множественном свойстве
     */
    $('.BendersayAddMap').click(function() {
        
        var key_i = parseInt($(this).attr('key_i')) + 1;
        $(this).attr('key_i', key_i);
        
        var html = '<div id="map_' + $(this).attr('key_name') + '_' + key_i + '" style="width: 500px; height: 400px"></div>';
        html += $(this).prev('p')[0].outerHTML;
        
        //console.log(html);
        //// Правим input
        var name = $(this).attr('key_name') + '[]';
        var id = 'coords_' + $(this).attr('key_name') + '_' + key_i;
        // Вставляем html
        $(this).closest('tr').after('<tr><td></td><td class="BendersayMap">' + html + '</td></td>').next().find('td.BendersayMap').append($(this))
        .children('p').children('input').attr('value', '').attr('name', name).attr('id', id);

        // Рисуем карту
        init( $(this).attr('key_name') + '_' + key_i);

    });
    
});