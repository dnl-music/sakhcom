<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\News */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'News', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <h3><?= $model->title ?></h3>
    <?= Html::img($model->image) ?>
    <div><?= $model->content ?></div><br />
    <p><?= $model->created_at ?></p><br />
    <p>Лайков: <span id="likes"><?= $model->likes ?></span></p>
    <p><a id="likeIt" href="?r=news/vote">Нравится!</a></p>
    <?php
    $script = <<< JS
        document.getElementById("likeIt").onclick = function(e){
            $.post('/?r=news/vote&id=' + $model->id).done(function(data){
                var likesElem = document.getElementById("likes");
                likesElem.innerText = parseInt(likesElem.innerText) + 1; 
            });
            e.preventDefault();
        };
JS;
    $this->registerJs($script, yii\web\View::POS_READY);
    ?>
</div>
