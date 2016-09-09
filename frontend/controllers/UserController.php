<?php

namespace frontend\controllers;

use frontend\models\NotificationType;
use Yii;
use common\models\User;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use common\models\search\UserSearch;
use common\components\GhostAccessControl;
use webvimark\components\AdminDefaultController;
use yii\db\Query;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends AdminDefaultController
{

    /**
     * @var User
     */
    public $modelClass = 'common\models\User';

    /**
     * @var UserSearch
     */
    public $modelSearchClass = 'common\models\search\UserSearch';

    public function behaviors()
    {
        return [
            'ghost-access' => [
                'class' => GhostAccessControl::className(),
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @return mixed|string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new User(['scenario' => 'newUser']);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->renderIsAjax('create', compact('model'));
    }

    /**
     * @param int $id User ID
     *
     * @throws \yii\web\NotFoundHttpException
     * @return string
     */
    public function actionChangePassword($id)
    {
        $model = User::findOne($id);

        if (!$model) {
            throw new NotFoundHttpException('User not found');
        }

        $model->scenario = 'changePassword';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->renderIsAjax('changePassword', compact('model'));
    }

    /**
     * @param null $q
     * @param null $id
     * @return User[]
     */
    public function actionUserList($q = null, $id = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query;
            $query->select('id, username AS text')
                ->from('user')
                ->where(['like', 'username', $q])
                ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        }
        elseif ($id > 0) {
            $user = User::findIdentity($id);
            $out['results'] = ['id' => $id, 'text' => $user->username];
        }
        return $out;
    }

    public function actionSetNotificationType()
    {
        $id = Yii::$app->user->id;
        $model = User::find()->where(['id' => $id])->one();

        $data = ArrayHelper::map(NotificationType::find()->all(), 'id', 'name');
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->unlinkAll('notificationTypes');
            foreach ($model->notificationTypeId as $item) {
                $notificationType = NotificationType::find()->where(['id' => $item])->one();
                $model->link('notificationTypes', $notificationType);
            }
            return $this->redirect('/site/index');
        }

        return $this->render('setNotificationType', ['model' => $model, 'data' => $data]);
    }

}
