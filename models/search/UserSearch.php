<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;

/**
* UserSearch represents the model behind the search form about `app\models\User`.
*/
class UserSearch extends User
{
/**
* @inheritdoc
*/
public function rules()
{
return [
[['id', 'role_id'], 'integer'],
            [['username', 'password', 'name', 'photo_url', 'last_login', 'last_logout'], 'safe'],
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
$query = User::find();

$dataProvider = new ActiveDataProvider([
'query' => $query,
]);

$this->load($params);

if (!$this->validate()) {
// uncomment the following line if you do not want to any records when validation fails
// $query->where('0=1');
return $dataProvider;
}

$query->andFilterWhere([
            'id' => $this->id,
            'role_id' => $this->role_id,
            'last_login' => $this->last_login,
            'last_logout' => $this->last_logout,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'photo_url', $this->photo_url]);

return $dataProvider;
}
}