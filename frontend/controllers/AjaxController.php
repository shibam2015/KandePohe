<?php

namespace frontend\controllers;

use Yii;
use frontend\components\CommonHelper;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;

class AjaxController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionGetcity()
    {
    	$id = Yii::$app->request->get('id');
    	//$countPosts = \common\models\Cities::find() ->where(['iStateId' => $id])->count();
    	$posts = CommonHelper::getCity($id);
        //var_dump($posts);
        	echo "<option value=''>City</option>";
            foreach($posts as $post){

                echo "<option value='".$post->iCityId."'>".$post->vCityName."</option>";
            }
        //return $city;
    }
    public function actionGetstate()
    {
        $id = Yii::$app->request->get('id');
        //$countPosts = \common\models\Cities::find() ->where(['iStateId' => $id])->count();
        $posts = CommonHelper::getState($id);
        //var_dump($posts);
            echo "<option value=''>State</option>";
            foreach($posts as $post){

                echo "<option value='".$post->iStateId."'>".$post->vStateName."</option>";
            }
        //return $city;
    }

    public function actionGetstatenew()
    {
        $id = Yii::$app->request->get('id');
        $posts = CommonHelper::getState($id);
        $data['state'] = $posts;
        $data['CountryId'] = $id;
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $data;
    }

    public function actionGetcitynew()
    {
        $id = Yii::$app->request->get('id');
        $posts = CommonHelper::getCity($id);
        $data['city'] = $posts;
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $data;
    }

    public function actionSameasaboveaddress()
    {
        $data = array();
        $iCountryId = Yii::$app->request->post('iCountryId');
        $iStateId = Yii::$app->request->post('iStateId');
        $iCityId = Yii::$app->request->post('iCityId');

        $iDistrictID = Yii::$app->request->post('iDistrictID');
        $iTalukaID = Yii::$app->request->post('iTalukaID');
        $vAreaName = Yii::$app->request->post('vAreaName');

        $countries = CommonHelper::getCountry();
        $country =  "<option value=''>Country</option>";
        foreach($countries as $key=>$value){
            $selected = $value->iCountryId==$iCountryId?'selected':'';
            $country.= "<option ".$selected." value='".$value->iCountryId."'>".$value->vCountryName."</option>";
        }
        $data['country'] = $country;

        $state =  "<option value=''>State</option>";
        if($iCountryId != ''){
            $states = CommonHelper::getState($iCountryId);
            foreach($states as $key=>$value){
                $selected = $value->iStateId==$iStateId?'selected':'';
                $state.= "<option ".$selected." value='".$value->iStateId."'>".$value->vStateName."</option>";
            }            
        }
        $data['state'] = $states;
        #$data['state'] = $state;

        $city =  "<option value=''>City</option>";
        if($iStateId != ''){
            $cities = CommonHelper::getCity($iStateId);
            foreach($cities as $key=>$value){
                $selected = $value->iCityId==$iCityId?'selected':'';
                $city.= "<option ".$selected." value='".$value->iCityId."'>".$value->vCityName."</option>";
            }
        }
        $data['city'] = $cities;
        #$data['city'] = $city;

        $district =  "<option value=''>District</option>";
        if($iDistrictID != ''){
            $districts = CommonHelper::getDistrict($iDistrictID);
            foreach($districts as $key=>$value){
                $selected = $value->iDistrictID==$iDistrictID?'selected':'';
                $district.= "<option ".$selected." value='".$value->iDistrictID."'>".$value->vName."</option>";
            }
        }
        $data['district'] = $districts;
        #$data['district'] = $district;

        $taluka =  "<option value=''>Taluka</option>";
        if($iTalukaID != ''){
            $talukas = CommonHelper::getTaluka($iTalukaID);
            foreach($talukas as $key=>$value){
                $selected = $value->iTalukaID==$iTalukaID?'selected':'';
                $taluka.= "<option ".$selected." value='".$value->iTalukaID."'>".$value->vName."</option>";
            }
        }
        $data['taluka'] = $talukas;
        #$data['taluka'] = $taluka;
        $data['areaname'] = $vAreaName;

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $data;
        //return $city;
    }

}
