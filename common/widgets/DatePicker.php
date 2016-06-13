<?php

namespace common\widgets;

use Yii;
use yii\helpers\Html;
use yii\helpers\FormatConverter;
use yii\base\InvalidParamException;

/**
 * Extended DatePicker, allows to set different formats for sending and displaying value
 */
class DatePicker extends \kartik\date\DatePicker
{
    public $saveDateFormat = 'php:Y-m-d';

    private $savedValueInputID = '';
    private $attributeValue = null;


    public function __construct($config = [])
    {
        $defaultOptions = [
            'type' => static::TYPE_COMPONENT_APPEND,
            'convertFormat' => true,
            'pluginOptions' => [
                'autoclose' => true,
                'format' => Yii::$app->formatter->dateFormat,
            ],
        ];
        $config = array_replace_recursive($defaultOptions, $config);

        parent::__construct($config);
    }

    public function init()
    {
        if ($this->hasModel()) {
            $model = $this->model;
            $attribute = $this->attribute;
            $value = $model->$attribute;

            $this->model = null;
            $this->attribute = null;
            $this->name = Html::getInputName($model, $attribute);
            $this->attributeValue = $value;

            if ($value) {
                try {
                    $this->value = Yii::$app->formatter->asDateTime($value, $this->pluginOptions['format']);
                } catch (InvalidParamException $e) {
                    $this->value = null;
                }
            }
        }

        return parent::init();
    }

    protected function parseMarkup($input)
    {
        $res = parent::parseMarkup($input);

        $res .= $this->renderSavedValueInput();
        $this->registerScript();

        return $res;
    }

    protected function renderSavedValueInput()
    {
        $value = $this->attributeValue;

        if ($value !== null && $value !== '') {
            // format value according to saveDateFormat
            try {
                $value = Yii::$app->formatter->asDate($value, $this->saveDateFormat);
            } catch(InvalidParamException $e) {
                // ignore exception and keep original value if it is not a valid date
            }
        }

        $this->savedValueInputID = $this->options['id'].'-saved-value';

        $options = $this->options;
        $options['id'] = $this->savedValueInputID;
        $options['value'] = $value;

        // render hidden input
        if ($this->hasModel()) {
            $contents = Html::activeHiddenInput($this->model, $this->attribute, $options);
        } else {
            $contents = Html::hiddenInput($this->name, $value, $options);
        }

        return $contents;
    }

    protected function registerScript()
    {
        $language = $this->language ? $this->language : Yii::$app->language;

        $format = $this->saveDateFormat;
        $format = strncmp($format, 'php:', 4) === 0 ? substr($format, 4) :
            FormatConverter::convertDateIcuToPhp($format, $type);
        $saveDateFormatJs = static::convertDateFormat($format);


        $containerID = $this->options['data-datepicker-source'];
        $hiddenInputID = $this->savedValueInputID;
        $script = "
            $('#{$containerID}').on('changeDate', function(e) {
                var savedValue = e.format(0, '{$saveDateFormatJs}');
                $('#{$hiddenInputID}').val(savedValue).trigger('change');
            }).on('clearDate', function(e) {
                var savedValue = e.format(0, '{$saveDateFormatJs}');
                $('#{$hiddenInputID}').val(savedValue).trigger('change');
            });

            $('#{$containerID}').data('datepicker').update();
            $('#{$containerID}').data('datepicker')._trigger('changeDate');
        ";
        $view = $this->getView();
        $view->registerJs($script);
    }
}
