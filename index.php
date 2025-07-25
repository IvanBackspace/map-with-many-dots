<?
    /*
        Проверить запрос на соответствие полей и заменить путь изображения для точек
    */
?>
<section class="maps">
    <div class="maps__container container">
        <div class="maps__row">
            <div>
                <div class="maps__title">
                    <div>Наши бригады в городах России</div>
                </div>
            </div>
            <?php
            $sql_sub_order = "SELECT Catalogue_Name, Coordinates FROM Catalogue";
            $sub_order = $nc_core->db->get_results($sql_sub_order);

            foreach ($sub_order as $row) {
                $coords = $row->Coordinates;
                $sitiName = $row->Catalogue_Name;
                $poinst .= "
          {
            coords: [$coords],
            hint: '$sitiName',
            iconImageHref: '/netcat_template/template/3/assets/upload/icon/map-black.svg', // Путь к SVG-иконке
            iconImageSize: [30, 30], // Размеры иконки
            iconImageOffset: [-15, -15] // Смещение, чтобы центр иконки совпадал с координатой
          },";
            }
            ?>
            <script>
                setTimeout(() => {
                    ymaps.ready(init);

                    function init() {
                        var myMapSiti = new ymaps.Map(document.getElementById('map-1'), {
                            center: [55.76, 37.64],
                            zoom: 10,
                        });
                        myMapSiti.behaviors.disable('scrollZoom')

                        var points = [
                            <?= $poinst ?>
                        ];

                        var svgIcon = {
                            iconLayout: 'default#image',
                            iconImageHref: '/local/src/img/img/map.svg',
                            iconImageSize: [30, 30],
                            iconImageOffset: [-15, -15]
                        };

                        points.forEach(function(point) {
                            var placemark = new ymaps.Placemark(point.coords, {
                                hintContent: point.hint,
                                balloonContent: point.balloon
                            }, svgIcon);

                            myMapSiti.geoObjects.add(placemark);
                        });
                    }
                }, 500);
            </script>
        </div>
    </div>
    <div id="map-1" style="width: 100%; height: 500px"></div>
</section>
