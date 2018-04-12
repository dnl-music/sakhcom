<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Rubric */

$this->title = 'Update Rubric: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Rubrics', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="rubric-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
