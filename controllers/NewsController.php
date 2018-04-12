<?php

namespace app\controllers;

use app\models\Rubric;
use Yii;
use app\models\News;
use app\models\NewsSearch;
use yii\data\Sort;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * NewsController implements the CRUD actions for News model.
 */
class NewsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all News models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NewsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $sort = new Sort([
            'attributes' => [
                'likes' => [
                    'label' => 'Лайкам',
                ],
                'created_at' => [
                    'label' => 'Дате',
                    'default' => SORT_DESC,
                ],
//                'name' => [
//                    'asc' => ['first_name' => SORT_ASC, 'last_name' => SORT_ASC],
//                    'desc' => ['first_name' => SORT_DESC, 'last_name' => SORT_DESC],
//                    'default' => SORT_DESC,
//                    'label' => 'Name',
//                ],
            ],
        ]);
        $dataProvider->setSort([
            'defaultOrder' => ['created_at'=>SORT_DESC],]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'rubrics' => Rubric::find()->all(),
            'sort' => $sort,
        ]);
    }

    /**
     * Displays a single News model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    public function actionVote($id)
    {
        if(Yii::$app->request->isAjax) {
            $model = $this->findModel($id);
            $model->likes += 1;
            $model->save(false);
            return 'OK';
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Creates a new News model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    public function actionCreate()
    {
        $model = new News();

        if ($model->load(Yii::$app->request->post())) {
            $model->upload = \yii\web\UploadedFile::getInstanceByName('News[upload]');

            $model->created_at = date("Y-m-d H:i:s");
            $model->likes = 0;

            if ($model->validate()) {
                if ($model->upload) {
                    $newFileName = Yii::$app->security->generateRandomString().'.'.$model->upload->extension;
                    //$filePath = 'uploads/' . $model->upload->baseName . '.' . $model->upload->extension;
                    $filePath = 'uploads/' . $newFileName;
                    if ($model->upload->saveAs($filePath)) {
                        $model->image = $filePath;
                    }
                }
                if ($model->save(false)) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
            'items' => $this->getRubrics(),
        ]);
    }

    private function getRubrics()
    {
        $items = array(0 => "");
        $items = array_merge($items, ArrayHelper::map(Rubric::find()->all(), 'id', 'name'));
        return $items;
    }

    /**
     * Finds the News model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return News the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = News::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
