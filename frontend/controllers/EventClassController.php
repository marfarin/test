<?php

namespace frontend\controllers;

use frontend\models\AlertUserQuery;
use Yii;
use frontend\models\EventClass;
use frontend\models\search\EventClassSearch;
use yii\db\Expression;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use yii\helpers\Json;

/**
 * EventClassController implements the CRUD actions for EventClass model.
 */
class EventClassController extends Controller
{
    public $className;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all EventClass models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EventClassSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        EventClass::getClassList();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EventClass model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new EventClass model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new EventClass();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing EventClass model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->classNameEventName;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing EventClass model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * @param null $q
     * @param null $id
     * @return array
     */
    public function actionClassList($q = null, $id = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query;
            $query->select('class_name as id, class_name AS text')
                ->from('event_class')
                ->where(['like', 'class_name', $q])
                ->groupBy(['class_name'])
                ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        } elseif ($id > 0) {
            $result = EventClass::findOne($id)->class_name;
            $out['results'] = ['id' => $result, 'text' => $result];
        }
        return $out;
    }

    public function actionDepEvent()
    {
        $out = [];
        if (isset(\Yii::$app->request->post()['depdrop_parents'])) {
            $identity = end(\Yii::$app->request->post()['depdrop_parents']);
            $list = EventClass::find()->andWhere(['class_name'=>$identity])->asArray()->all();
            $selected  = null;
            if ($identity != null && count($list) > 0) {
                $selected = '';
                foreach ($list as $i => $account) {
                    $out[] = ['id' => $account['id'], 'name' => $account['event_name']];
                }
                // Shows how you can preselect a value
                echo Json::encode(['output' => $out, 'selected'=>$selected]);
                return;
            }
        }
        echo Json::encode(['output' => '', 'selected'=>'']);
    }

    public function actionEventClassList($q = null, $id = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query;
            $query->select('id, (class_name || \'::\' || event_name) AS text')
                ->from('event_class')
                ->where(['like', 'class_name', $q])
                ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        } elseif ($id > 0) {
            $result = EventClass::findOne($id);
            $out['results'] = ['id' => $result->id, 'text' => $result->class_name . '::' . $result->event_name];
        }
        return $out;
    }

    public function actionFieldNameClassList($id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = EventClass::findOne($id);
        $class = $model->class_name;
        $class = new $class;
        $attributes = $class->attributeLabels();
        $out = ['results' => $attributes];
        return $out;
    }

    /**
     * Finds the EventClass model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EventClass the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EventClass::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionSetAlertShowed($id)
    {
        $model = AlertUserQuery::find()->where(['id'=>$id])->one();
        if ($model->recipient_id != \Yii::$app->user->id) {
            throw new ForbiddenHttpException();
        }
        $model->readed_at = new Expression('NOW()');
        $model->save();
    }
}
