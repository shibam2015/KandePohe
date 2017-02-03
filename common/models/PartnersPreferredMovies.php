<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "partners_preferred_movies".
 *
 * @property integer $ID
 * @property integer $user_id
 * @property integer $movie_id
 * @property string $is_partner_preference
 * @property string $created_on
 * @property string $modified_on
 */
class PartnersPreferredMovies extends \common\models\base\basePartnersPreferredMovies
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partners_preferred_movies';
    }

    public static function findAllByUserId($UserId)
    {

        return static::findAll(['user_id' => $UserId]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'movie_id'], 'required'],
            [['user_id', 'movie_id'], 'integer'],
            [['is_partner_preference'], 'string'],
            [['created_on', 'modified_on'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'user_id' => 'User ID',
            'movie_id' => 'Movie ID',
            'is_partner_preference' => 'Partner Preference',
            'created_on' => 'Created On',
            'modified_on' => 'Modified On',
        ];
    }

    public function getMoviesName()
    {
        return $this->hasOne(PreferredMovies::className(), ['ID' => 'movie_id']);
    }
}
