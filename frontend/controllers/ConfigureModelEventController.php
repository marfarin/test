<?php

namespace frontend\controllers;

use common\models\User;
use Yii;
use frontend\models\ConfigureModelEvent;
use frontend\models\search\ConfigureModelEventSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\models\EventClass;
use frontend\models\NotificationType;
use common\models\rbacDB\Role;
use common\components\GhostAccessControl;

/**
 * ConfigureModelEventController implements the CRUD actions for ConfigureModelEvent model.
 */
class ConfigureModelEventController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'ghost-access' => [
                'class' => GhostAccessControl::className(),
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all ConfigureModelEvent models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ConfigureModelEventSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $eventNames = EventClass::find()->where(['id' => $searchModel->classNameEventName])->all();
        $eventNamesArray = [];
        foreach ($eventNames as $event) {
            $eventNamesArray[] = [$event->id => $event->getClassNameEventName()];
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'eventInitValues' => $eventNamesArray,
        ]);
    }

    /**
     * Displays a single ConfigureModelEvent model.
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
     * Creates a new ConfigureModelEvent model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ConfigureModelEvent();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->unlinkAll('notificationTypes');
            $model->unlinkAll('roles');
            $model->unlinkAll('users');
            foreach ($model->notificationTypeId as $item) {
                $notificationType = NotificationType::find()->where(['id' => $item])->one();
                $model->link('notificationTypes', $notificationType);
            }
            foreach ($model->roleId as $item) {
                $role = Role::find()->where(['name' => $item])->one();
                $model->link('roles', $role);
            }
            foreach ($model->userId as $item) {
                $user = User::find()->where(['id' => $item])->one();
                $model->link('users', $user);
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ConfigureModelEvent model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $identity = $model->eventClass->class_name;
        $list = EventClass::find()->andWhere(['class_name'=>$identity])->asArray()->all();
        $out = [];
        if ($identity != null && count($list) > 0) {
            foreach ($list as $account) {
                $out[$account['id']] = $account['event_name'];
            }
        }

        $out_users = [];
        foreach ($model->users as $user) {
            $out_users[$user->id] = $user->username;
        }

        $out_roles = [];
        foreach ($model->roles as $role) {
            $out_roles[$role->name] = $role->description;
        }

        $out_notification = [];
        foreach ($model->notificationTypes as $notificationType) {
            $out_notification[$notificationType->id] = $notificationType->name;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->unlinkAll('notificationTypes', true);
            $model->unlinkAll('roles', true);
            $model->unlinkAll('users', true);
            foreach ($model->notificationTypeId as $item) {
                $notificationType = NotificationType::find()->where(['id' => $item])->one();
                $model->link('notificationTypes', $notificationType);
            }
            foreach ($model->roleId as $item) {
                $role = Role::find()->where(['name' => $item])->one();
                $model->link('roles', $role);
            }
            foreach ($model->userId as $item) {
                $user = User::find()->where(['id' => $item])->one();
                $model->link('users', $user);
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'default_data' => $out,
                'default_data_users' => $out_users,
                'default_data_roles' => $out_roles,
                'default_data_notification' => $out_notification
            ]);
        }
    }

    /**
     * Deletes an existing ConfigureModelEvent model.
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
     * Finds the ConfigureModelEvent model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ConfigureModelEvent the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ConfigureModelEvent::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
