<?php

use backend\models\Apple;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var backend\models\AppleSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Apples';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="apple-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Generate Apples', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'color',
            'created_at',
            'fallen_at',
            [
                'attribute' => 'status',
                'value' => function($model) {
                    return $model->getStatus();
                },
                'filter'=> Html::activeDropDownList($searchModel,'status', Apple::getStatuses(), ['class' => 'form-control', 'prompt' => 'All']),
            ],
            'size',
            [
                'class' => ActionColumn::className(),
                'template' => '{fall} {eat} {delete}',
                'buttons' => [
                    'fall' => function ($url, $model) {
                        return Html::a(
                            'Fall', ['apple/fall', 'id' => $model->id],
                        );
                    },
                    'eat' => function ($url, $model) {
                        return Html::a(
                            'Eat', ['apple/eat', 'id' => $model->id],
                        );
                    },
                ],
            ],
        ],
    ]); ?>


</div>
