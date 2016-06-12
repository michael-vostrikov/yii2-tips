<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Products');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="panel panel-default">
        <div class="panel-heading">
            <?= Html::a(Yii::t('app', 'Filter'), '#filter', ['data-toggle' => 'collapse']) ?>
            <?= Html::a(Yii::t('app', 'Reset filter'), ['index'], ['class' => 'pull-right']) ?>
        </div>
        <div id="filter" class="panel-collapse collapse">
            <div class="panel-body">
                <?= $this->render('_search', ['model' => $searchModel]) ?>
            </div>
        </div>
    </div>

    <p>
        <?= Html::a(Yii::t('app', 'Create Product'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'name',
            'user.username',
            [
                'class' => 'common\components\grid\CombinedDataColumn',
                'labelTemplate' => '{0} &nbsp; / &nbsp; {1}',
                'valueTemplate' => '{0} &nbsp; / &nbsp; {1}',
                'labels' => [
                    'Created At',
                    '[ Updated At ]',
                ],
                'attributes' => [
                    'created_at:datetime',
                    'updated_at:html',
                ],
                'values' => [
                    null,
                    function ($model, $_key, $_index, $_column) {
                        return '[ ' . Yii::$app->formatter->asDatetime($model->updated_at) . ' ]';
                    },
                ],
                'sortLinksOptions' => [
                    ['class' => 'text-nowrap'],
                    null,
                ],
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
