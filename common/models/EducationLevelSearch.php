<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\EducationLevel;

/**
 * EducationLevelSearch represents the model behind the search form about `common\models\EducationLevel`.
 */
class EducationLevelSearch extends EducationLevel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['iEducationLevelID'], 'integer'],
            [['vEducationLevelName', 'status'], 'safe'],
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
        $query = EducationLevel::find();

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
            'iEducationLevelID' => $this->iEducationLevelID,
        ]);

        $query->andFilterWhere(['like', 'vEducationLevelName', $this->vEducationLevelName])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
