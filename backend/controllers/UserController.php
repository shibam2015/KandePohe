<?php

namespace backend\controllers;

use Yii;
use common\models\User;
use common\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
                    //'approve' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionApprove($id)
    {
        $model = $this->findModel($id);

        if ($model->validate()) {
            $model->status = 5;
            $model->save();
            return $this->redirect(Yii::$app->request->referrer);
        }
    }

    public function actionDisapprove($id)
    {
        $model = $this->findModel($id);
        if ($model->validate()) {
            $model->status = 4;
            $model->save();
            return $this->redirect(Yii::$app->request->referrer);
        }
    }
    public function actionBlock($id)
    {
        $model = $this->findModel($id);
        if ($model->validate()) {
            $model->status = 6;
            $model->save();
            return $this->redirect(Yii::$app->request->referrer);
        }
    }



    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionUseractive()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->searchActive(Yii::$app->request->queryParams);

        return $this->render('useractive', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionUserapprove()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->searchApprove(Yii::$app->request->queryParams);

        return $this->render('userapprove', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionUserInOwnWords()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->searchInOwnWords(Yii::$app->request->queryParams);

        return $this->render('userinownwords', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionInownwords($id)
    {
        $model = $this->findModel($id);
        #$model = new User();
        if ($model->load(Yii::$app->request->post())) {
            #echo "<pre>";print_r(Yii::$app->request->post());
            #echo " IF ";exit;
            $USER_ARRAY = Yii::$app->request->post();
            $commentInOwnWordsAdmin = $USER_ARRAY['User']['commentInOwnWordsAdmin'];
            $ACTION_TYPE = $USER_ARRAY['submit'];
            #$EMAIL = 'vikas.maheshwari1991.vm@gmail.com';//$model->email ;
            $EMAIL = $model->email ;
            $subject = 'Regarding In Own Word Content On Kande-pohe.com';
            $message = "";

            if($ACTION_TYPE == 'APPROVE'){

                $model->eStatusInOwnWord = 'Approve';

                $message .= "Dear ".$model->First_Name.",
                              We are Approve Your Content of a About YourSelf, Now it is visible to others site users.
                        ";
                $message .= "\n ".$commentInOwnWordsAdmin;
            }else{
                $model->eStatusInOwnWord = 'Disapprove';
                $message .= "Dear ".$model->First_Name.",
                              We are not Approve Your about your self content because of Something Wrong in your content so it is not showing to other site User.
                        ";
                $message .= "\n ".$commentInOwnWordsAdmin;
            }
            if($model->save()){
                $res = Yii::$app->mailer->compose()
                    ->setTo($EMAIL)
                    #->setFrom('no-replay@vcodertechnolab.com')
                    ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . '.com'])
                    ->setSubject($subject)
                    ->setTextBody($message)
                    ->send();

            }

        }
        return $this->render('inownwords', [
            'model' => $this->findModel($id),
        ]);
    }
    public function actionUserProfilePic()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->searchProfilePhoto(Yii::$app->request->queryParams);

        return $this->render('userprofilepic', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionProfilepic($id)
    {
        $model = $this->findModel($id);
        #$model = new User();
        if ($model->load(Yii::$app->request->post())) {
            #echo "<pre>";print_r(Yii::$app->request->post());
            #echo " IF ";exit;
            $USER_ARRAY = Yii::$app->request->post();
            $commentInOwnWordsAdmin = $USER_ARRAY['User']['commentInOwnWordsAdmin'];
            $ACTION_TYPE = $USER_ARRAY['submit'];
            #$EMAIL = 'vikas.maheshwari1991.vm@gmail.com';//$model->email ;
            $EMAIL = $model->email ;
            $subject = 'Regarding Your Profile Photo On Kande-pohe.com';
            $message = "";

            if($ACTION_TYPE == 'APPROVE'){

                $model->eStatusPhotoModify = 'Approve';

                $message .= "Dear ".$model->First_Name.",
                              We are Approve Your profile Photo, Now it is visible to others site users.
                        ";
                $message .= "\n ".$commentInOwnWordsAdmin;
            }else{
                $model->eStatusPhotoModify = 'Disapprove';
                $message .= "Dear ".$model->First_Name.",
                              We are not Approve Your Profile Photo because of Something Wrong in your Profile Photo so it is not showing to other site User,Please Select Another Profile Photo.
                        ";
                $message .= "\n ".$commentInOwnWordsAdmin;
            }
            if($model->save()){
                $res = Yii::$app->mailer->compose()
                    ->setTo($EMAIL)
                    #->setFrom('no-replay@vcodertechnolab.com')
                    ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . '.com'])
                    ->setSubject($subject)
                    ->setTextBody($message)
                    ->send();

            }

        }
        return $this->render('profilepic', [
            'model' => $this->findModel($id),
        ]);
    }
    function userInfo()
    {

        $model = new User();
        $ABC = $model->getUserInfo();


        #$customers = User::findBySql($sql, [':status' => User::STATUS_INACTIVE])->all();

    exit;
    }
    public function helloWorld(){
        echo "hello world";
    }

}
