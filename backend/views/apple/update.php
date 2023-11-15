<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var backend\models\Eat $model */

$this->title = 'Eat';
$this->params['breadcrumbs'][] = ['label' => 'Apples', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Eat';
?>
<div class="apple-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
