<?php

namespace backend\controllers;

use Yii;
use common\models\MembershipType;
use common\models\MembershipTypeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\CommonHelper;

/**
 * MembershipTypeController implements the CRUD actions for MembershipType model.
 */
class MembershipTypeController extends Controller
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
     * Lists all MembershipType models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MembershipTypeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MembershipType model.
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
     * Finds the MembershipType model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MembershipType the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MembershipType::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Creates a new MembershipType model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MembershipType();

        $model->scenario = MembershipType::SCENARIO_ADD;
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
     * Deletes an existing MembershipType model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */

    /**
     * Updates an existing MembershipType model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = MembershipType::SCENARIO_UPDATE;
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
}
