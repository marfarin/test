<?php
/**
 * Created by PhpStorm.
 * User: panik
 * Date: 20.04.16
 * Time: 16:41
 */

namespace common\helpers;

use Yii;

class AttemptHelper
{
    const SESSION_LAST_ATTEMPT = '_um_last_attempt';
    const SESSION_ATTEMPT_COUNT = '_um_attempt_count';

    /**
     * How much attempts user can made to login or recover password in $attemptsTimeout seconds interval
     *
     * @var int
     */
    public static $maxAttempts = 10000;

    /**
     * Number of seconds after attempt counter to login or recover password will reset
     *
     * @var int
     */
    public static $attemptsTimeout = 0;

    /**
     * Check how much attempts user has been made in X seconds
     *
     * @return bool
     */
    public static function checkAttempts()
    {
        $lastAttempt = Yii::$app->session->get(static::SESSION_LAST_ATTEMPT);
        if ($lastAttempt) {
            $attemptsCount = Yii::$app->session->get(static::SESSION_ATTEMPT_COUNT, 0);
            Yii::$app->session->set(static::SESSION_ATTEMPT_COUNT, ++$attemptsCount);
            // If last attempt was made more than X seconds ago then reset counters
            if (($lastAttempt + self::$attemptsTimeout) < time()) {
                Yii::$app->session->set(static::SESSION_LAST_ATTEMPT, time());
                Yii::$app->session->set(static::SESSION_ATTEMPT_COUNT, 1);

                return true;
            } elseif ($attemptsCount > self::$maxAttempts) {
                return false;
            }

            return true;
        }
        Yii::$app->session->set(static::SESSION_LAST_ATTEMPT, time());
        Yii::$app->session->set(static::SESSION_ATTEMPT_COUNT, 1);

        return true;
    }

}