<?php

namespace backend\controllers;

use Yii;
use common\models\User;
use common\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\MailHelper;
use common\components\CommonHelper;
use common\models\UserPhotos;
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

    public function actionApprove($id)
    {
        $model = $this->findModel($id);

        if ($model->validate()) {
            $model->status = 5;
            $model->completed_step = $model->setCompletedStep('10');
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
        if ($model->load(Yii::$app->request->post())) {
            $USER_ARRAY = Yii::$app->request->post();
            $commentInOwnWordsAdmin = $USER_ARRAY['User']['commentInOwnWordsAdmin'];
            $ACTION_TYPE = $USER_ARRAY['submit'];
            if($ACTION_TYPE == 'APPROVE'){
                $model->eStatusInOwnWord = 'Approve';
                if ($model->save()) {
                    $MAIL_DATA = array("EMAIL_TO" => $model->email, "NAME" => $model->First_Name . " " . $model->Last_Name, "COMMENT" => $commentInOwnWordsAdmin);
                    MailHelper::SendMail('IN_OWN_WORDS_APPROVE', $MAIL_DATA);
                }
            }else{
                $model->eStatusInOwnWord = 'Disapprove';
                if ($model->save()) {
                    $MAIL_DATA = array("EMAIL_TO" => $model->email, "NAME" => $model->First_Name . " " . $model->Last_Name, "COMMENT" => $commentInOwnWordsAdmin);
                    MailHelper::SendMail('IN_OWN_WORDS_DISAPPROVE', $MAIL_DATA);
                }
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
        if ($model->load(Yii::$app->request->post())) {
            $USER_ARRAY = Yii::$app->request->post();
            $commentAdmin = $USER_ARRAY['User']['commentAdmin'];
            $photo_id = $USER_ARRAY['User']['iPhoto_ID'];
            $ACTION_TYPE = $USER_ARRAY['submit'];
            $PG = new UserPhotos();
            $UP = $PG->findByPhotoId($id, $photo_id);
            if ($ACTION_TYPE == 'Approve') {
                if ($UP->Is_Profile_Photo == 'YES') {
                    $model->eStatusPhotoModify = 'Approve';
                    $model->save();
                }
                $UP->eStatus = 'Approve';
                if ($UP->save()) {
                    $MAIL_DATA = array("EMAIL_TO" => $model->email, "NAME" => $model->First_Name . " " . $model->Last_Name, "COMMENT" => $commentAdmin);
                    MailHelper::SendMail('PROFILE_PHOTO_APPROVE', $MAIL_DATA);
                }
            }else{
                if ($UP->Is_Profile_Photo == 'YES') {
                    $model->eStatusPhotoModify = 'Disapprove';
                    $model->save();
                }
                $UP->eStatus = 'Disapprove';
                if ($UP->save()) {
                    $MAIL_DATA = array("EMAIL_TO" => $model->email, "NAME" => $model->First_Name . " " . $model->Last_Name, "COMMENT" => $commentAdmin);
                    MailHelper::SendMail('PROFILE_PHOTO_DISAPPROVE', $MAIL_DATA);
                }
            }

        }
        $USER_PHOTO_MODEL = new UserPhotos();
        $USER_PHOTOS_LIST = $USER_PHOTO_MODEL->findByUserId($id);
        return $this->render('profilepic', [
            'model' => $this->findModel($id),
            'PHOTO_LIST' => $USER_PHOTOS_LIST
        ]);
    }

    public function actionPhotosview($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $USER_ARRAY = Yii::$app->request->post();
            $commentAdmin = $USER_ARRAY['User']['commentAdmin'];
            $photo_id = $USER_ARRAY['User']['iPhoto_ID'];
            $ACTION_TYPE = $USER_ARRAY['submit'];
            $PG = new UserPhotos();
            $UP = $PG->findByPhotoId($id, $photo_id);
            if ($ACTION_TYPE == 'Approve') {
                if ($UP->Is_Profile_Photo == 'YES') {
                    $model->eStatusPhotoModify = 'Approve';
                    $model->save();
                }
                $UP->eStatus = 'Approve';
                if ($UP->save()) {
                    $MAIL_DATA = array("EMAIL_TO" => $model->email, "NAME" => $model->First_Name . " " . $model->Last_Name, "COMMENT" => $commentAdmin);
                    MailHelper::SendMail('PROFILE_PHOTO_APPROVE', $MAIL_DATA);
                }
            } else {
                if ($UP->Is_Profile_Photo == 'YES') {
                    $model->eStatusPhotoModify = 'Disapprove';
                    $model->save();
                }
                $UP->eStatus = 'Disapprove';
                if ($UP->save()) {
                    $MAIL_DATA = array("EMAIL_TO" => $model->email, "NAME" => $model->First_Name . " " . $model->Last_Name, "COMMENT" => $commentAdmin);
                    MailHelper::SendMail('PROFILE_PHOTO_DISAPPROVE', $MAIL_DATA);
                }
            }

        }
        $USER_PHOTO_MODEL = new UserPhotos();
        $USER_PHOTOS_LIST = $USER_PHOTO_MODEL->findByUserId($id);
        return $this->render('photosview', [
            'model' => $this->findModel($id),
            'PHOTO_LIST' => $USER_PHOTOS_LIST
        ]);
    }


}
