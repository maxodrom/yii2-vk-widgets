<?php
/**
 * @author Max Alexandrov <max@maxodrom.ru>
 * @since 1.0
 * @license MIT
 */

namespace maxodrom\vk\widgets\assets;

use yii\web\AssetBundle;

/**
 * Class OpenApiAsset
 *
 * @package maxodrom\vk\widgets
 */
class OpenApiAsset extends AssetBundle
{
    public $baseUrl = '//vk.com/js/api';
    public $sourcePath = '@vendor/maxodrom/yii2-vk-widgets/src/assets/src/js';
    public $js = [
        'openapi.js',
    ];
}