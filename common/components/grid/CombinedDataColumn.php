<?php

namespace common\components\grid;

use yii\grid\DataColumn;

/**
 * Renders several attributes in one grid column
 */
class CombinedDataColumn extends DataColumn
{
    /* @var $labelTemplate string */
    public $labelTemplate = null;

    /* @var $valueTemplate string */
    public $valueTemplate = null;

    /* @var $attributes string[] | null */
    public $attributes = null;

    /* @var $formats string[] | null */
    public $formats = null;

    /* @var $values string[] | null */
    public $values = null;

    /* @var $labels string[] | null */
    public $labels = null;

    /* @var $sortLinksOptions string[] | null */
    public $sortLinksOptions = null;


    /**
     * Sets parent object parameters for current attribute
     * @param $key string Key of current attribute
     * @param $attribute string Current attribute
     */
    protected function setParameters($key, $attribute)
    {
        list($attribute, $format) = array_pad(explode(':', $attribute), 2, null);

        $this->attribute = $attribute;

        if (isset($format)) {
            $this->format = $format;
        } else if (isset($this->formats[$key])) {
            $this->format = $this->formats[$key];
        } else {
            $this->format = null;
        }

        if (isset($this->labels[$key])) {
            $this->label = $this->labels[$key];
        } else {
            $this->label = null;
        }

        if (isset($this->sortLinksOptions[$key])) {
            $this->sortLinkOptions = $this->sortLinksOptions[$key];
        } else {
            $this->sortLinkOptions = [];
        }

        if (isset($this->values[$key])) {
            $this->value = $this->values[$key];
        } else {
            $this->value = null;
        }
    }

    /**
     * Sets parent object parameters and calls parent method for each attribute, then renders combined cell content
     * @inheritdoc
     */
    protected function renderHeaderCellContent()
    {
        if (!is_array($this->attributes)) {
            return parent::renderHeaderCellContent();
        }

        $labels = [];
        foreach ($this->attributes as $i => $attribute) {
            $this->setParameters($i, $attribute);
            $labels['{'.$i.'}'] = parent::renderHeaderCellContent();
        }

        if ($this->labelTemplate === null) {
            return implode('<br>', $labels);
        } else {
            return strtr($this->labelTemplate, $labels);
        }
    }

    /**
     * Sets parent object parameters and calls parent method for each attribute, then renders combined cell content
     * @inheritdoc
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        if (!is_array($this->attributes)) {
            return parent::renderDataCellContent($model, $key, $index);
        }

        $values = [];
        foreach ($this->attributes as $i => $attribute) {
            $this->setParameters($i, $attribute);
            $values['{'.$i.'}'] = parent::renderDataCellContent($model, $key, $index);
        }

        if ($this->valueTemplate === null) {
            return implode('<br>', $values);
        } else {
            return strtr($this->valueTemplate, $values);
        }
    }
}
