<?php
namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Cities;

/**
 * CitiesSearch represents the model behind the search form about `common\models\Cities`.
 */

/**
 * AdminSearch represents the model behind the search form about `backend\models\Admin`.
 */
class AdminSearch extends Admin
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['iAdminId'], 'integer'],
            [['vFirstName', 'vLastName', 'vEmail', 'vPassword', 'eStatus'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Admin::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        /*$dataProvider->setSort([
            'attributes' => [
                'iAdminId',
                'vFirstName' => [
                    'asc' => ['vFirstName' => SORT_ASC],
                    'desc' => ['vFirstName' => SORT_DESC],
                    'label' => 'Full Name',
                    'default' => SORT_ASC
                ],
                'iAdminId'
            ]]);*/
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'iAdminId' => $this->iAdminId,
        ]);

        $query->andFilterWhere(['like', 'vFirstName', $this->vFirstName])
            ->andFilterWhere(['like', 'vLastName', $this->vLastName])
            ->andFilterWhere(['like', 'vEmail', $this->vEmail])
            ->andFilterWhere(['like', 'vPassword', $this->vPassword])
            ->andFilterWhere(['like', 'eStatus', $this->eStatus]);


        return $dataProvider;
    }
}
