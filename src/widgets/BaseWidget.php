<?php
/**
 * @author Max Alexandrov <max@maxodrom.ru>
 * @since 1.0
 * @license MIT
 */

namespace maxodrom\vk\widgets;

use yii\base\Widget;
use maxodrom\vk\widgets\assets\OpenApiAsset;

/**
 * Class BaseWidget
 *
 * @package maxodrom\vk\widgets
 */
abstract class BaseWidget extends Widget
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        OpenApiAsset::register($this->view);
        parent::init();
    }
}