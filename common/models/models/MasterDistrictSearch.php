<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\MasterDistrict;

/**
 * MasterDistrictSearch represents the model behind the search form about `common\models\MasterDistrict`.
 */
class MasterDistrictSearch extends MasterDistrict
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['iDistrictID'], 'integer'],
            [['vName', 'eStatus'], 'safe'],
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
        $query = MasterDistrict::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'iDistrictID' => $this->iDistrictID,
        ]);

        $query->andFilterWhere(['like', 'vName', $this->vName])
            ->andFilterWhere(['like', 'eStatus', $this->eStatus]);

        return $dataProvider;
    }
}
