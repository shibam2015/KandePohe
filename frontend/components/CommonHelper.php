<?php	
	/**
	* 
	*/
namespace frontend\components;
use Yii;

class CommonHelper {
	
	/*function __construct(argument) {

	}*/

	public function getReligion() {
		$religion = \common\models\Religion::find()->all();
		return $religion;
	}

	public function getAnnualIncome() {
		return \common\models\AnnualIncome::find()->all();
	}

	public function getWorkingWith() {
		return \common\models\WorkingWith::find()->all();
	}

	public function getEducationField() {
		return \common\models\EducationField::find()->all();
	}

	public function getEducationLevel() {
		return \common\models\EducationLevel::find()->all();
	}

	public function getWorkingAS() {
		return \common\models\WorkingAS::find()->all();
	}

	public function getCommunity() {
		return \common\models\MasterCommunity::find()->all();
	}
	public function getSubCommunity() {
		return \common\models\MasterCommunitySub::find()->all();
	}
	public function getMaritalStatus() {
		return \common\models\MasterMaritalStatus::find()->all();
	}
	public function getGotra() {
		return \common\models\MasterGotra::find()->all();
	}
	public function getDistrict() {
		return \common\models\MasterDistrict::find()->all();
	}
	public function getTaluka() {
		return \common\models\MasterTaluka::find()->all();
	}
	public function getCountry() {
		return \common\models\Countries::find()->all();
	}
	public function getState($id='') {
		if($id == '')
			return \common\models\States::find()->all();
		else
			return \common\models\States::find()->where(['iCountryId' => $id])->all();
	}
	public function getCity($id='') {
		if($id == '')
			return \common\models\Cities::find()->all();
		else
			return \common\models\Cities::find()->where(['iStateId' => $id])->all();

	}
	public function getHeight() {
		return \common\models\MasterHeight::find()->all();
	}
	public function getDiet() {
		return \common\models\MasterDiet::find()->all();
	}
	public function getFmstatus() {
		return \common\models\MasterFmStatus::find()->all();
	}

	function encryptor($action, $string) {
    $output = false;

    $encrypt_method = "AES-256-CBC";
    //pls set your unique hashing key
    $secret_key = 'vCoderTeam';
    $secret_iv = 'vCoderTeam123';

    // hash
    $key = hash('sha256', $secret_key);

    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    //do the encyption given text/string/number
    if( $action == 'encrypt' ) {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    }
    else if( $action == 'decrypt' ){
    	//decrypt the given text/string/number
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }

    return $output;
}

}
?>