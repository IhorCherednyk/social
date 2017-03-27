<?php

namespace app\modules\message\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Message;

/**
 * MessagerSearch represents the model behind the search form about `app\models\Message`.
 */
class MessagerSearch extends Message {

    /**
     * @inheritdoc
     */
    public $sendername;
    public $recipientname;

    public function rules() {
        return [
                [['id', 'status', 'sender_id', 'recipient_id', 'created_at', 'updated_at'], 'integer'],
                [['text', 'sendername', 'recipientname'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
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
    public function search($params) {
        $query = Message::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);
        

        
        $this->load($params);

        $query->joinWith('sender s');
//        $query->joinWith('recipient r');

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'sender_id' => $this->sender_id,
            'recipient_id' => $this->recipient_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);
//        D($this->username);
        $query->andFilterWhere(['like', 'text', $this->text])
                ->andFilterWhere(['like', 's.username', $this->sendername])
                ->andFilterWhere(['like', 's.username', $this->recipientname]);
//        D($query->createCommand()->getRawSql())
//        D($dataProvider->getModels());

        return $dataProvider;
    }

}
