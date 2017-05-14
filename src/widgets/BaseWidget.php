<?php
/**
 * @author Max Alexandrov <max@maxodrom.ru>
 * @since 1.0
 * @license MIT
 */

namespace maxodrom\vk\widgets;

use yii\base\Widget;
use yii\web\View;
use maxodrom\vk\widgets\assets\OpenApiAsset;

/**
 * Class BaseWidget
 *
 * @package maxodrom\vk\widgets
 */
abstract class BaseWidget extends Widget
{
    /**
     * @var integer
     */
    public $apiId;


    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->view->registerAssetBundle(OpenApiAsset::className(), View::POS_HEAD);
        $this->registerOpenApiScript();

        parent::init();
    }

    /**
     * Register VK Open API script using apiId.
     */
    public function registerOpenApiScript()
    {
        $this->view->registerJs(<<<JS
            VK.init({
                apiId: {$this->apiId},
                onlyWidgets: true
            });
JS
        , View::POS_HEAD);
    }
}