<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dektrium\user\models\User;
use yii\helpers\ArrayHelper;
use common\models\Category;
use common\widgets\Script;

/* @var $this yii\web\View */
/* @var $model common\models\Product */
/* @var $form yii\widgets\ActiveForm */

$users = ArrayHelper::map(User::find()->all(), 'id', 'username');
$categories = ArrayHelper::map(Category::find()->all(), 'id', 'name');
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->dropdownList($users, ['prompt' => Yii::t('app', '[not set]')]) ?>

    <?= $form->field($model, 'category_id')->dropdownList($categories, ['prompt' => Yii::t('app', '[not set]')]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php Script::begin(); ?>
<script>

    console.log('Product form: $(document).ready()');

</script>
<?php Script::end(); ?>
