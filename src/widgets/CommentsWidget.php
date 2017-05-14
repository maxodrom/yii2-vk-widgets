<?php
/**
 * @author Max Alexandrov <max@maxodrom.ru>
 * @since 1.0
 * @license MIT
 */

namespace maxodrom\vk\widgets;

use Yii;
use yii\base\DynamicModel;
use yii\base\Exception;
use yii\helpers\Html;
use yii\helpers\Json;

/**
 * Class CommentsWidget
 *
 * @package maxodrom\vk\widgets
 */
class CommentsWidget extends BaseWidget
{
    const WIDGET_NAME = 'vk_comments';

    /**
     * @var int Comments limit (valid between 5 and 100). Default is 25comments on page.
     */
    public $limit = 25;
    /**
     * @var int Widget width in pixels.
     */
    public $width;
    /**
     * @var int Widget height in pixels.
     */
    public $height = 0;
    /**
     * @var string Possible values: graffiti, photo, audio, video, link (or '*' for all types).
     */
    public $attach = '*';
    /**
     * @var int|bool
     */
    public $autoPublish = 1;
    /**
     * @var int|bool
     */
    public $norealtime = 0;
    /**
     * @var string
     */
    public $pageUrl;
    /**
     * @var string Inner identifier of page.
     */
    public $page_id;
    /**
     * @var string
     */
    protected $containerId;
    /**
     * @var array
     */
    protected $widgetOptions = [];


    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->containerId = self::WIDGET_NAME . '_' . $this->getId();

        $model = DynamicModel::validateData(
            [
                'width' => $this->width,
                'height' => $this->height,
                'limit' => $this->limit,
                'attach' => $this->attach,
                'autoPublish' => $this->autoPublish,
                'norealtime' => $this->norealtime,
                'pageUrl' => $this->pageUrl,
                'page_id' => $this->page_id,
            ],
            [
                [['width', 'pageUrl'], 'default', 'value' => null],
                ['height', 'default', 'value' => 0],
                ['limit', 'default', 'value' => 25],
                ['attach', 'default', 'value' => '*'],
                ['autoPublish', 'default', 'value' => 1],
                ['norealtime', 'default', 'value' => 0],
                ['pageUrl', 'default', 'value' => Yii::$app->getRequest()->getAbsoluteUrl()],
                [
                    ['width', 'height', 'limit', 'autoPublish', 'norealtime'],
                    'integer',
                ],
                [
                    ['pageUrl', 'page_id', 'attach'],
                    'string',
                ],
                [
                    ['norealtime', 'autoPublish'],
                    'default',
                    'value' => function ($model, $attribute) {
                        return $model->{$attribute} = intval($attribute);
                    }
                ],
                [
                    ['norealtime', 'autoPublish'],
                    'in',
                    'range' => [0, 1]
                ],
                [
                    'page_id',
                    'default',
                    'value' => function ($model, $attribute) {
                        if (is_string($model->pageUrl)) {
                            return md5($model->pageUrl);
                        }

                        return null;
                    }
                ]
            ]
        );

        if ($model->hasErrors()) {
            throw new Exception(
                "Validation errors in " . get_called_class() . ". "  .
                "Errors description: " . Html::errorSummary($model)
            );
        }

        $this->widgetOptions = $model->attributes;

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
            "VK.Widgets.Comments('" . $this->containerId . "', " . Json::encode($this->widgetOptions) . ");",
            [
                'type' => 'text/javascript'
            ]
        );

        parent::run();
    }
}