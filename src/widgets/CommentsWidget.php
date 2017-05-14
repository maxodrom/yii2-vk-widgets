<?php
/**
 * @author Max Alexandrov <max@maxodrom.ru>
 * @since 1.0
 * @license MIT
 */

namespace maxodrom\vk\widgets;

use yii\helpers\Html;

/**
 * Class CommentsWidget
 *
 * @package maxodrom\vk\widgets
 */
class CommentsWidget extends BaseWidget
{
    const WIDGET_NAME = 'vk_comments';

    /**
     * @var array
     */
    public static $commentLimits = [5, 10, 15, 20];
    /**
     * @var int
     */
    public $commentsLimit = 10;
    /**
     * @var string
     */
    public $width = '';
    /**
     * @var string
     */
    private $containerId;


    /**
     * @inheritdoc
     */
    public function init()
    {
        if (!is_int($this->commentsLimit) || !in_array($this->commentsLimit, self::$commentLimits)) {
            $this->commentsLimit = 10;
        }
        $this->containerId = self::WIDGET_NAME . '_' . $this->getId();

        parent::init();
    }


    /**
     * @inheritdoc
     */
    public function run()
    {
        echo Html::tag(
            'div',
            '',
            [
                'id' => $this->containerId,
            ]
        );
        echo Html::tag(
            'script',
            "VK.Widgets.Comments('" . $this->containerId . "', {limit:{$this->commentsLimit}, attach: '*'});",
            [
                'type' => 'text/javascript'
            ]
        );

        parent::run();
    }
}