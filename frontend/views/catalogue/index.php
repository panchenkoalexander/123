<?php

use yii\helpers\Url;

?>

<div class="row">
    <div class="box">
        <div class="col-lg-12">
            <h1>Каталог запчастей для марка+модель+год</h1>
            <!--ЕСЛИ НЕ ВЫбрана модель - то просто "Каталог запчастей" и на странице кнопки не активные-->
            <div class="btn-group btn-group-justified" role="group" aria-label="...">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-default dropdown-toggle btn-primary" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                        <b>Марка</b> <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <div class="row">
                            <div class="col-lg-1">
                            </div>
                            <div class="col-lg-3">
                                <?php foreach ($convertedBrands as $brandFirstLetter => $brands): ?>
                                    <h4 align="center"><?= $brandFirstLetter ?></h4>
                                    <?php foreach ($brands as $brand): ?>
                                        <li><a brandId="<?= $brand->getId() ?>" class="brandLink"
                                               href="#"><?= $brand->getName() ?></a></li>
                                    <?php endforeach; ?>
                                <?php endforeach; ?>
                            </div>
                            <!--                            <div class="col-lg-3">-->
                            <!--                                <h4 align="center">A</h4>-->
                            <!--                                <li><a href="#">AUDI</a></li>-->
                            <!--                                <li><a href="#">ACURA</a></li>-->
                            <!--                                <h4 align="center">T</h4>-->
                            <!--                                <li><a href="#">TOYOTA</a></li>-->
                            <!--                                <li><a href="#">TRANSPORTER</a></li>-->
                            <!--                                <h4 align="center">B</h4>-->
                            <!--                                <li><a href="#">BMW</a></li>-->
                            <!--                                <li><a href="#">BUMMER</a></li>-->
                            <!--                            </div>-->
                            <!---->
                            <!--                            <div class="col-lg-3">-->
                            <!--                                <h4 align="center">T</h4>-->
                            <!--                                <li><a href="#">TOYOTA</a></li>-->
                            <!--                                <li><a href="#">TRANSPORTER</a></li>-->
                            <!--                                <h4 align="center">A</h4>-->
                            <!--                                <li><a href="#">AUDI</a></li>-->
                            <!--                                <li><a href="#">ACURA</a></li>-->
                            <!--                                <h4 align="center">B</h4>-->
                            <!--                                <li><a href="#">BMW</a></li>-->
                            <!--                                <li><a href="#">BUMMER</a></li>-->
                            <!--                            </div>-->
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;........................................................................................................................................................&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </div>
                    </ul>
                </div>
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-default dropdown-toggle btn-primary" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                        <b>Модель</b> <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" id="catalogue-models">

                    </ul>
                </div>
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-default dropdown-toggle btn-primary" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                        <b>Двигатель</b> <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" id="catalogue-engines">

                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="box">
        <div class="col-lg-5">
            <?php foreach ($categories as $category): ?>
                <a href="#" type="button" class="btn btn-default btn-lg btn-block">
                    <?= $category->getName() ?>
                </a>
            <?php endforeach; ?>

        </div>
        <div class="col-lg-7">
            <h4>Багажник / помещение для груза</h4>
            <button type="button" class="btn btn-default btn-block">Пружина газовая крышки багажника <span
                    class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> <span
                    class="glyphicon-class"></span></button>
            <h4>Пружина газовая крышки багажника</h4>
            <button type="button" class="btn btn-default btn-block">Пружина газовая крышки багажника <span
                    class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> <span
                    class="glyphicon-class"></span></button>
            <button type="button" class="btn btn-default btn-block">Пружина газовая крышки багажника <span
                    class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> <span
                    class="glyphicon-class"></span></button>
        </div>
    </div>
    <div class="box">
        <div class="col-lg-12">
            <h2 class="intro-text text-center">Запчасти на марка+модель+год
            </h2>
            <p>
                Для того чтоб подобрать запчасть на <strong>марка+модель</strong>, Вы можете воспользоваться нашим
                каталогом запчастей. Выбрав нужную запчасть, Вы получите подробную информацию о ней и всех аналогах.
                Если Вы не уверены в правильности подбора запчастей на <strong>марка+модель+год</strong> - можете
                предоставить нашим менеджерам VIN (номер кузова автомобиля). Информация будет передана специалисту по
                <strong>марка</strong>, который с 100% гарантией подберет запчасть на Ваш автомобиль.
            </p>
            <button type="button" class="btn btn-default btn-block">Запрос по VIN</button>
            <h2 class="intro-text text-center">Каталог запчастей марка+модель
            </h2>
            <p>
                Данный каталог запчастей разработан специально для автолюбителей. Интуитивно понятный интерфейс, поможет
                владельцам <strong>марка+модель</strong> легко подобрать нужную запчасть.
            </p>
            Теги: <span class="label label-success">Каталог запчастей марка+модель+год</span> <span
                class="label label-primary">Марка</span> <span class="label label-warning">Марка+модель</span> <span
                class="label label-danger">модель+год</span>
        </div>
    </div>
    <script>
        $('.brandLink').on('click', function () {
            var brandId = $(this).attr('brandId');
            var route = "<?= Url::toRoute('catalogue/models') ?>";
            $.get(route, {brandId: brandId}, function (r) {
                var parsedResponse = JSON.parse(r);
                if (parsedResponse.result == 'success') {
                    $('#catalogue-models').html(parsedResponse.data);
                }
            })
            return false;
        })

        $('body').on('click', '.modelLink', function () {
            var modelId = $(this).attr('modelId');
            var route = "<?= Url::toRoute('catalogue/engines') ?>";
            $.get(route, {modelId: modelId}, function (r) {
                var parsedResponse = JSON.parse(r);
                $('#catalogue-engines').html(parsedResponse.data);
            })
            return false;
        })
    </script>