<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Message;

/**
 * MessageSearch represents the model behind the search form about `app\models\Message`.
 */
class MessageSearch extends Message
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'created_at', 'updated_at', 'sender_id', 'recipient_id'], 'integer'],
            [['text'], 'safe'],
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
    public function search($params,$incomingMessage)
    {
        $query = Message::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        if($incomingMessage == Message::MESSAGE_INCOMING){
            $query->where(['=', 'recipient_id', Yii::$app->user->id]);
        }else {
           
            $query->where(['=', 'sender_id', Yii::$app->user->id]); 
        }
        if (!$this->validate()) {
            return $dataProvider;
        }
        
        
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'sender_id' => $this->sender_id,
            'recipient_id' => $this->recipient_id,
        ]);
//        D($query->createCommand()->sql);
//        D($this);
        $query->andFilterWhere(['like', 'text', $this->text]);
        
        return $dataProvider;
    }
}