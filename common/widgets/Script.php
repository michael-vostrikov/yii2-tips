<?php

namespace common\widgets;

use Yii;
use yii\web\View;

/**
 * Allows to write javascript in view inside '<script></script>' tags and render it at the end of body together with other scripts
 * '<script></script>' tags are removed from result output
 */
class Script extends \yii\base\Widget
{
    /** @var string Script position, used in registerJs() function */
    public $position = View::POS_READY;


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        ob_start();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $script = ob_get_clean();
        $script = preg_replace('|^\s*<script>|ui', '', $script);
        $script = preg_replace('|</script>\s*$|ui', '', $script);
        $this->getView()->registerJs($script, $this->position);
    }
}
