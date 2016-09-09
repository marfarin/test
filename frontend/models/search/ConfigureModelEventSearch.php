<?php

namespace frontend\models\search;

use frontend\models\EventClass;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\ConfigureModelEvent;

/**
 * ConfigureModelEventSearch represents the model behind the search form about `frontend\models\ConfigureModelEvent`.
 */
class ConfigureModelEventSearch extends ConfigureModelEvent
{
    public $classNameEventName = [];
    public $sender;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['event_class_id'], 'integer'],
            [['name', 'description', 'message_text', 'message_header', 'id', 'sender', 'from'], 'safe'],
            [['for_all'], 'boolean'],
            ['classNameEventName', 'each', 'rule' => ['string']],
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
        $query = ConfigureModelEvent::find();

        $query->joinWith(['eventClass', 'sender']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['classNameEventName'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['tbl_event_class.class_name' => SORT_ASC, 'tbl_event_class.event_name' => SORT_ASC],
            'desc' => ['tbl_event_class.class_name' => SORT_DESC, 'tbl_event_class.event_name' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['sender'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['user.email' => SORT_ASC],
            'desc' => ['user.email' => SORT_DESC],
        ];

        if (isset($params['ConfigureModelEventSearch']) && !is_array($params['ConfigureModelEventSearch']['classNameEventName'])) {
            $params['ConfigureModelEventSearch']['classNameEventName'] = [];
        }
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            $qqq = $this->getErrors();
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'event_class_id' => $this->classNameEventName,
            'from' => $this->sender,
            'for_all' => $this->for_all,
        ]);

        //$query->andFilterWhere(['in', 'event_class_id', $this->eventClass]);
        //$query->andFilterWhere(['in', 'from', $this->sender]);



        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'message_text', $this->message_text])
            ->andFilterWhere(['like', 'message_header', $this->message_header]);

        /*foreach ($this->classNameEventName as $index => $classNameEventName) {
            if (!is_array($classNameEventName)) {
                $trueEvent = EventClass::findOne($classNameEventName);
                $this->classNameEventName[$index] = [$trueEvent->id => $trueEvent->classNameEventName];
            }
        }*/
        
        return $dataProvider;
    }
}
