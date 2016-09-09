<?php

namespace frontend\controllers;

use Yii;
use yii\filters\VerbFilter;
use common\models\UserVisitLog;
use common\components\GhostAccessControl;
use common\models\search\UserVisitLogSearch;
use webvimark\components\AdminDefaultController;

/**
 * UserVisitLogController implements the CRUD actions for UserVisitLog model.
 */
class UserVisitLogController extends AdminDefaultController
{
    /**
     * @var UserVisitLog
     */
    public $modelClass = 'common\models\UserVisitLog';

    /**
     * @var UserVisitLogSearch
     */
    public $modelSearchClass = 'common\models\search\UserVisitLogSearch';

    public $enableOnlyActions = ['index', 'view', 'grid-page-size'];

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
}
