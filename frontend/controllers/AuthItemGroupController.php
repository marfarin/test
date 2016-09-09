<?php

namespace frontend\controllers;

use Yii;
use yii\filters\VerbFilter;
use common\models\rbacDB\AuthItemGroup;
use common\components\GhostAccessControl;
use webvimark\components\AdminDefaultController;
use common\models\rbacDB\search\AuthItemGroupSearch;

/**
 * AuthItemGroupController implements the CRUD actions for AuthItemGroup model.
 */
class AuthItemGroupController extends AdminDefaultController
{
    /**
     * @var AuthItemGroup
     */
    public $modelClass = 'common\models\rbacDB\AuthItemGroup';

    /**
     * @var AuthItemGroupSearch
     */
    public $modelSearchClass = 'common\models\rbacDB\search\AuthItemGroupSearch';

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
     * Define redirect page after update, create, delete, etc
     *
     * @param string $action
     * @param AuthItemGroup $model
     *
     * @return string|array
     */
    protected function getRedirectPage($action, $model = null)
    {
        switch ($action) {
            case 'delete':
                return ['index'];
                break;
            case 'update':
                return ['view', 'id' => $model->code];
                break;
            case 'create':
                return ['view', 'id' => $model->code];
                break;
            default:
                return ['index'];
        }
    }
}
