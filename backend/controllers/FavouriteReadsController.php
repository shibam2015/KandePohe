<?php

namespace backend\controllers;

use Yii;
use common\models\FavouriteReads;
use common\models\FavouriteReadsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\CommonHelper;

/**
 * FavouriteReadsController implements the CRUD actions for FavouriteReads model.
 */
class FavouriteReadsController extends Controller
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
     * Lists all FavouriteReads models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FavouriteReadsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single FavouriteReads model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Finds the FavouriteReads model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FavouriteReads the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FavouriteReads::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Creates a new FavouriteReads model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new FavouriteReads();

        $model->scenario = FavouriteReads::SCENARIO_ADD;
        if ($model->load(Yii::$app->request->post())) {
            $DATETIME = CommonHelper::getTime();
            $model->created_on = $DATETIME;
            $model->modified_on = $DATETIME;
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->ID]);
            }

        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing FavouriteReads model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = FavouriteReads::SCENARIO_UPDATE;
        if ($model->load(Yii::$app->request->post())) {
            $DATETIME = CommonHelper::getTime();
            $model->modified_on = $DATETIME;
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->ID]);
            }

        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing FavouriteReads model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
}
