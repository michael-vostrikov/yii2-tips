<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use dektrium\user\models\User;
use common\models\Category;
use common\widgets\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model frontend\models\ProductSearch */
/* @var $form yii\widgets\ActiveForm */

$users = ArrayHelper::map(User::find()->all(), 'id', 'username');
$categories = ArrayHelper::map(Category::find()->all(), 'id', 'name');
?>

<div class="product-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'enableClientValidation' => false,
    ]); ?>

    <div class="row">
        <div class="col-sm-3">
            <?= $form->field($model, 'id') ?>
        </div>

        <div class="col-sm-3">
            <?= $form->field($model, 'name') ?>
        </div>

        <div class="col-sm-3">
            <?= $form->field($model, 'user_id')->dropdownList($users, ['prompt' => Yii::t('app', '[not set]')]) ?>
        </div>

        <div class="col-sm-3">
            <?= $form->field($model, 'category_id')->dropdownList($categories, ['prompt' => Yii::t('app', '[not set]')]) ?>
        </div>
    </div>

    <div class="row">
        <?php
            /*
            $datePickerOptions = [
                'removeButton' => '<span class="kv-date-remove kv-date-remove-custom">×</span>',
                'pluginEvents' => [
                    'changeDate' => "function(e) { $(this).find('.kv-date-remove-custom').toggle(e.dates.length != 0); }",
                    'clearDate'  => "function(e) { $(this).find('.kv-date-remove-custom').toggle(e.dates.length != 0); }",
                ],
            ];
            */

            $dateTimePickerOptions = [
                'removeButton' => '<span class="kv-date-remove kv-date-remove-custom">×</span>',
                'removeButtonSelector' => '.kv-date-remove-custom',
                'pluginEvents' => [
                    'changeDate' => "function(e) {
                        var isEmpty = ($(this).find('input').val() == '');
                        $(this).find('.kv-date-remove-custom').toggle(!isEmpty);
                    }",
                ],
            ];
        ?>
        <div class="col-sm-3">
            <?= $form->field($model, 'created_from')->widget(DateTimePicker::classname(), $dateTimePickerOptions) ?>
        </div>

        <div class="col-sm-3">
            <?= $form->field($model, 'created_to')->widget(DateTimePicker::classname(), $dateTimePickerOptions) ?>
        </div>

        <div class="col-sm-3">
            <?= $form->field($model, 'updated_from')->widget(DateTimePicker::classname(), $dateTimePickerOptions) ?>
        </div>

        <div class="col-sm-3">
            <?= $form->field($model, 'updated_to')->widget(DateTimePicker::classname(), $dateTimePickerOptions) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
