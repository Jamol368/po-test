<?php

namespace backend\controllers;

use backend\models\Apple;
use backend\models\AppleSearch;
use backend\models\Eat;
use backend\services\RandDateTime;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AppleController implements the CRUD actions for Apple model.
 */
class AppleController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => ['@'],
                        ],
                    ],
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Apple models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new AppleSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Apple models.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $timestamp = new RandDateTime(strtotime('2023-11-15'), time());

        for ($i = 0; $i < rand(5, 10); $i++) {
            $model = new Apple();

            $model->color = $model->getColor();
            $model->created_at = $timestamp->getRand();
            $model->status = $model->getRandStatus();

            $model->save();
        }

        return $this->redirect(['/apple']);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionFall($id)
    {
        $model = $this->findModel($id);

        if ($model->status !== Apple::FALLEN) {
            $model->status = Apple::FALLEN;
            $model->fallen_at = time();
            $model->update();
        }

        return $this->redirect(['/apple']);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionEat($id)
    {
        $eat = new Eat();

        if ($this->request->isPost && $eat->load($this->request->post())) {
            $model = $this->findModel($id);
            $model->eat($eat->size);
            $model->deleteIf();
            return $this->redirect(['/apple']);
        }

        return $this->render('update', [
            'model' => $eat,
        ]);
    }

    /**
     * Deletes an existing Apple model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Apple model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Apple the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Apple::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
