<?php

namespace common\widgets;

use Yii;
use yii\helpers\Html;
use yii\helpers\FormatConverter;
use yii\base\InvalidParamException;

/**
 * Extended DateTimePicker, allows to set different formats for sending and displaying value
 */
class DateTimePicker extends \kartik\datetime\DateTimePicker
{
    public $saveDateFormat = 'php:Y-m-d H:i';
    public $removeButtonSelector = '.kv-date-remove';

    private $savedValueInputID = '';
    private $attributeValue = null;


    public function __construct($config = [])
    {
        $defaultOptions = [
            'type' => static::TYPE_COMPONENT_APPEND,
            'convertFormat' => true,
            'pluginOptions' => [
                'autoclose' => true,
                'format' => Yii::$app->formatter->datetimeFormat,
                'pickerPosition' => 'top-left',
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

    public function registerAssets()
    {
        $format = $this->saveDateFormat;
        $format = strncmp($format, 'php:', 4) === 0
            ? substr($format, 4)
            : FormatConverter::convertDateIcuToPhp($format, $type);
        $saveDateFormatJs = static::convertDateFormat($format);


        $this->savedValueInputID = $this->options['id'].'-saved-value';

        $this->pluginOptions['linkField'] = $this->savedValueInputID;
        $this->pluginOptions['linkFormat'] = $saveDateFormatJs;

        return parent::registerAssets();
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
                $value = Yii::$app->formatter->asDateTime($value, $this->saveDateFormat);
            } catch(InvalidParamException $e) {
                // ignore exception and keep original value if it is not a valid date
            }
        }

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
        $containerID = $this->options['id'] . '-datetime';
        $hiddenInputID = $this->savedValueInputID;

        if ($this->removeButtonSelector) {
            $script = "
                $('#{$containerID}').find('{$this->removeButtonSelector}').on('click', function(e) {
                    $('#{$containerID}').find('input').val('').trigger('change');
                    $('#{$containerID}').data('datetimepicker').reset();

                    $('#{$containerID}').trigger('changeDate', {
                        type: 'changeDate',
                        date: null,
                    });
                });

                $('#{$containerID}').trigger('changeDate', {
                    type: 'changeDate',
                    date: null,
                });
            ";

            $view = $this->getView();
            $view->registerJs($script);
        }
    }
}
