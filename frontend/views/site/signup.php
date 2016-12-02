<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \yii\widgets\MaskedInput;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>


    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['class'=>'form-horizontal']);   ?>

            <?= $form->field($model,'name')->textInput()->label('Ваше имя')?>

            <?= $form->field($model,'lastname')->textInput()->label('Ваша фамилия')?>

            <?= $form->field($model,'email')->textInput()->label('Ваша почта')?>

            <?=$form->field($model, 'phone')->widget(MaskedInput::className(),['mask' => '+3(999) 999-99999'])->label('Ваш телефон')?>

            <?=$form->field($model,'password')->passwordInput()->label('Ваш пароль')?>

            <div>
                <button type="submit" class="btn btn-primary">Регистрация</button>
            </div>

            <?php
            ActiveForm::end();
            ?>
        </div>
    </div>
</div>
