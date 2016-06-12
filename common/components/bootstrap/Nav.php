<?php

namespace common\components\bootstrap;

use Yii;
use yii\bootstrap\Nav as YiiBootstrapNav;

/**
 * @inheritdoc
 */
class Nav extends YiiBootstrapNav
{
    /**
     * Adds additional check - directly compare item URL and request URL.
     * Used to make an item active when item URL is handled by module routing
     *
     * @inheritdoc
     */
    protected function isItemActive($item)
    {
        if (parent::isItemActive($item)) {
            return true;
        }

        if (!isset($item['url'])) {
            return false;
        }

        $route = null;
        $itemUrl = $item['url'];

        if (is_array($itemUrl) && isset($itemUrl[0])) {
            $route = $itemUrl[0];
            if ($route[0] !== '/' && Yii::$app->controller) {
                $route = Yii::$app->controller->module->getUniqueId() . '/' . $route;
            }
        } else {
            $route = $itemUrl;
        }

        $requestUrl = Yii::$app->request->getUrl();
        $isActive = ($route === $requestUrl || (Yii::$app->homeUrl . $route) === '/' . $requestUrl);

        return $isActive;
    }
}
