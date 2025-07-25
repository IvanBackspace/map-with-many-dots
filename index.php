<? if ($_GET['test'] == 'test') { ?>
    <style>
        .contact-info__top-item--adress {
            position: relative;
        }

        .contact-info__top-item--phone {
            position: relative;
        }

        .contact-info__top-item--time {
            position: relative;
        }

        .contact-info__top-item--mail {
            position: relative;
        }

        .contact-info__top-item--adress::before {
            content: "";
            position: absolute;
            left: -32px;
            top: 0;
            background-position: center center;
            background-repeat: no-repeat;
            width: 20px;
            aspect-ratio: 1 / 1;
            background-image: url("/local/src/img/img/media/adress.svg");
        }

        .contact-info__top-item--phone::before {
            content: "";
            position: absolute;
            left: -32px;
            top: 0;
            background-position: center center;
            background-repeat: no-repeat;
            width: 20px;
            aspect-ratio: 1 / 1;
            background-image: url("/local/src/img/img/media/phones.svg");
        }

        .contact-info__top-item--time::before {
            content: "";
            position: absolute;
            left: -32px;
            top: 0;
            background-position: center center;
            background-repeat: no-repeat;
            width: 20px;
            aspect-ratio: 1 / 1;
            background-image: url("/local/src/img/img/media/time.svg");
        }

        .contact-info__top-item--mail::before {
            content: "";
            position: absolute;
            left: -32px;
            top: 0;
            background-position: center center;
            background-repeat: no-repeat;
            width: 20px;
            aspect-ratio: 1 / 1;
            background-image: url("/local/src/img/img/media/maill.svg");
        }

        .contact-info__top-items {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            padding-left: 31px;
        }

        .contact-info__top-item {
            font-weight: 400;
            font-size: 16px;
            line-height: 150%;
            color: #01120E;
            width: 48%;
        }

        .contact-info__top-item a {
            font-weight: 400;
            font-size: 16px;
            line-height: 150%;
            color: #01120E;
            width: 48%;
        }

        .contact-info__wrap {
            background-color: #B8F5FA;
            border-radius: 40px;
            max-width: 646px;
        }

        .contact-info__top-city {
            font-weight: 700;
            font-size: 24px;
            line-height: 149%;
            color: #0573A0;
            margin-bottom: 12px;
        }

        .contact-info__top {
            padding: 24px 40px;
        }

        .contact-info__bottom {
            padding: 19px 40px;
            background-color: #ECFCFD;
        }

        .contact-info__bottom-title {
            font-weight: 700;
            font-size: 24px;
            line-height: 149%;
            color: #01120E;
            margin-bottom: 14px;
        }
        .maps {
            position: relative;
        }

        @media (max-width: 650px) {
            .contact-info__top-item {
                font-weight: 400;
                font-size: 14px;
                line-height: 150%;
            }

            .contact-info__bottom {
                padding: 17px 24px;
            }



            .contact-info__bottom-title {
                font-size: 20px;
                margin-bottom: 10px;
            }


            .contact-info__top-item {
                width: 100%;
            }

            .contact-info__top-city {
                font-size: 20px;
            }


            .contact-info__top-items {
                flex-direction: column;
            }

            .contact-info__top-items {
                display: flex;
                flex-wrap: wrap;
                gap: 12px;
                flex-direction: column;
                padding-left: 31px;
            }
        }
    </style>
    <script>
        if ((!document.querySelector('[src="https://api-maps.yandex.ru/2.1/?apikey=b45c587d-d157-4b1d-86d4-acefbe12350c&lang=ru_RU"]')) && (document.querySelector('#map-1'))) {
            const script = document.createElement('script');
            script.type = 'text/javascript';
            script.src = 'https://api-maps.yandex.ru/2.1/?apikey=556a806a-b239-476a-9342-caefdcba1c9d&lang=ru_RU';
            document.head.appendChild(script);
        }
    </script>
    <section class="maps">
        <div class="maps__container container">
            <div class="maps__row">
                <div>
                    <div class="maps__title">
                        <div>Наши бригады в городах России</div>
                    </div>
                </div>
                <?php
                $sql_sub_order = "SELECT Catalogue_Name, Coordinates1, Coordinates2 FROM Catalogue";
                $sub_order = $nc_core->db->get_results($sql_sub_order);

                foreach ($sub_order as $row) {
                    $coords = $row->Coordinates1 . ',' . $row->Coordinates2;
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
        <section class="contact-info__wrap">
            <div class="contact-info__top">
                <div class="contact-info__top-city">
                    <?= $current_catalogue['city_name'] ?>
                </div>
                <div class="contact-info__top-items">
                    <div class="contact-info__top-item contact-info__top-item--adress">
                        <p><?= $current_catalogue['adress'] ?></p>
                    </div>
                    <div class="contact-info__top-item contact-info__top-item--phone">
                        <a href="tel:+<?= $current_catalogue['tel'] ?>">
                            <?= $current_catalogue['phone'] ?>
                        </a>
                    </div>
                    <div class="contact-info__top-item contact-info__top-item--time">
                        <p>Пн-Вс: круглосуточно</p>
                    </div>
                    <div class="contact-info__top-item contact-info__top-item--mail">
                        <a href="mailto:<?= $current_catalogue['email'] ?>">
                            <?= $current_catalogue['email'] ?>
                        </a>
                    </div>
                </div>
            </div>
            <div class="contact-info__bottom">
                <div class="contact-info__bottom-title">Мы в городах:</div>
            </div>
        </section>
    </section>




<? } ?>
