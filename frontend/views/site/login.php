<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to login:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin();?>

                <?= $form->field($login_model,'email')->textInput()->label('Ваша почта')?>
                <?= $form->field($login_model,'password')->passwordInput()->label('Ваш пароль')?>



            <div>
                <button type="submit" class="btn btn-success">Войти</button>
            </div>

            <?php
            ActiveForm::end();
            ?>
        </div>
    </div>
</div>
