<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\SiteMessages;

/**
 * SiteMessagesSearch represents the model behind the search form about `common\models\SiteMessages`.
 */
class SiteMessagesSearch extends SiteMessages
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['message_action', 'message_type', 'message_value', 'Subject'], 'safe'],
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
        $query = SiteMessages::find()->orderBy(['message_action' => SORT_ASC]);

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
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'message_action', $this->message_action])
            ->andFilterWhere(['like', 'message_type', $this->message_type])
            ->andFilterWhere(['like', 'message_value', $this->message_value])
            ->andFilterWhere(['like', 'Subject', $this->Subject]);

        return $dataProvider;
    }
}
