<?php

namespace backend\controllers;

use Yii;
use common\models\SkinTone;
use common\models\SkinToneSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\CommonHelper;

/**
 * SkinToneController implements the CRUD actions for SkinTone model.
 */
class SkinToneController extends Controller
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
     * Lists all SkinTone models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SkinToneSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SkinTone model.
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
     * Finds the SkinTone model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SkinTone the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SkinTone::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Creates a new SkinTone model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SkinTone();

        $model->scenario = SkinTone::SCENARIO_ADD;
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
     * Updates an existing SkinTone model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $model = $this->findModel($id);
        $model->scenario = SkinTone::SCENARIO_UPDATE;
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
     * Deletes an existing SkinTone model.
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
