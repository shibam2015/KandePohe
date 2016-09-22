<?php

namespace backend\controllers;

use Yii;
use common\models\Raashi;
use common\models\RaashiSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\CommonHelper;


/**
 * RaashiController implements the CRUD actions for Raashi model.
 */
class RaashiController extends Controller
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
     * Lists all Raashi models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RaashiSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Raashi model.
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
     * Finds the Raashi model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Raashi the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Raashi::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Creates a new Raashi model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Raashi();

        $model->scenario = Raashi::SCENARIO_ADD;
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
     * Updates an existing Raashi model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = Raashi::SCENARIO_UPDATE;
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
     * Deletes an existing Raashi model.
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
