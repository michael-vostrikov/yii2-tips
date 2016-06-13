<?php

namespace common\components;

use Yii;
use yii\i18n\Formatter;

/**
 * Allows to convert time values in user timezone (usually from input fields)
 * into appplication timezone which is used in models
 * Conversion from application timezone into user timezone
 * is usulally done by Yii::$app->formatter->asDatetime()
 */
class InputTimezoneConverter
{
    /** @var Formatter */
    private $formatter = null;


    public function __construct($formatter = null)
    {
        if ($formatter === null) {
            // we change formatter configuration so we need to clone it
            $formatter = clone(Yii::$app->formatter);
        }
        $this->formatter = $formatter;
        $this->formatter->datetimeFormat = 'php:Y-m-d H:i:s';

        // swap timeZone and defaultTimeZone of default formatter configuration
        // to perform conversion back to default timezone

        $timeZone = $this->formatter->timeZone;
        $this->formatter->timeZone = $this->formatter->defaultTimeZone;
        $this->formatter->defaultTimeZone = $timeZone;
    }

    /**
     * @param $value string
     */
    public function convertValue($value)
    {
        if ($value === null || $value === '') {
            return $value;
        }

        return $this->formatter->asDatetime($value);
    }
}
