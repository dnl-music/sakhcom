<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\NewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'News';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php
    $searchParams = Yii::$app->getRequest()->getQueryParam('NewsSearch');
    ?>

    <span style="font:size:18">Рубрика: </span>
    <select onchange="prepareUrl(this.value)">
        <option value="">Все</option>
        <?php foreach($rubrics as $rubric) { ?>
            <option value="<?= $rubric->id ?>" <?= $searchParams && array_key_exists("rubric_id", $searchParams) && $searchParams['rubric_id']==$rubric->id?"selected":"" ?>><?= $rubric->name ?></option>
        <?php } ?>
    </select><br />
    <span style="font:size:18">Сортировать по: </span><?= $sort->link('created_at') ?> | <?= $sort->link('likes') ?>
    <script>
        function prepareUrl(newRubricId) {
            var href = window.location.href;
            if(href.search(/NewsSearch%5Brubric_id%5D=[0-9]+/) != -1) {
                window.location.href=href.replace(/NewsSearch%5Brubric_id%5D=[0-9]+/, 'NewsSearch%5Brubric_id%5D=' + newRubricId)
            } else {
                if(href.indexOf('?') > -1) {
                    window.location.href=href + '&NewsSearch%5Brubric_id%5D=' + newRubricId;
                } else {
                    window.location.href=href + '?NewsSearch%5Brubric_id%5D=' + newRubricId;
                }
            }
        }
    </script>
    <?php
    $models = $dataProvider->getModels();
    foreach($models as $model) {
        ?>
            <div>
                <?= Html::img($model->image, ['class' => 'pull-left img-responsive']); ?>
                <h3><?= $model->title ?></h3>
                <p><?= $model->short_desc ?></p>
                <p><?= $model->created_at ?></p>
                <?=Html::a("Читать", ['view', 'id' => $model->id]) ?><br />
                <span style="color:#3c3c3c; font-size: 10px">Лайков: <?= $model->likes ?></span>
            </div>
        <?php
    }
    ?>
    <hr />
    <p>
        <?= Html::a('Добавить новость', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
</div>
