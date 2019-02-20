<?php

namespace humhub\modules\custom_pages\models;

use Yii;
use humhub\modules\custom_pages\helpers\Url;
use humhub\modules\custom_pages\models\forms\SettingsForm;
use humhub\modules\custom_pages\components\Container;
use humhub\modules\custom_pages\modules\template\models\Template;

/**
 * This is the model class for table "custom_pages_container_snipped".
 *
 * Snippets are custom sidebar panels which can be added to the directory/dashboard sidebar.
 * 
 * The followings are the available columns in table 'custom_pages_container_page':
 * @property integer $id
 * @property integer $type
 * @property string $title
 * @property string $icon
 * @property string $page_content
 * @property integer $sort_order
 * @property integer $admin_only
 * @property string $cssClass
 */
class Snippet extends CustomContentContainer
{

    const SIDEBAR_DASHBOARD = 'Dasboard';
    const SIDEBAR_DIRECTORY = 'Directory';

    /**
     * @inhritdoc
     */
    public function behaviors()
    {
        return [
            ['class' => Container::class],
        ];
    }

    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
        return 'custom_pages_snippet';
    }

    /**
     * @inheritdoc
     * @return array
     */
    public function rules()
    {
        $rules = $this->defaultRules();
        $rules[] = ['page_content', 'safe'];
        $rules[] = ['target', 'required'];
        return $rules;
    }

    /**
     * @inerhitdoc
     * @return array
     */
    public function attributeLabels()
    {
        $result = $this->defaultAttributeLabels();
        $result['page_content'] = Yii::t('CustomPagesModule.models_Snippet', 'Content');
        $result['target'] = Yii::t('CustomPagesModule.models_Snippet', 'Sidebar');
        return $result;
    }

    /**
     * Returns a sidebar selection for all sidebars this page can be added.
     * @return array
     */
    public static function getSidebarSelection()
    {
        return [
            self::SIDEBAR_DASHBOARD => Yii::t('CustomPagesModule.base', 'Dashboard'),
            self::SIDEBAR_DIRECTORY => Yii::t('CustomPagesModule.base', 'Directory'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function getContentTypes()
    {
        return [
            Container::TYPE_MARKDOWN,
            Container::TYPE_IFRAME,
            Container::TYPE_TEMPLATE,
            Container::TYPE_PHP,
        ];
    }

    /**
     * @inheritdoc
     */
    public function getLabel()
    {
        return Yii::t('CustomPagesModule.models_Snippet', 'snippet');
    }

    /**
     * @inheritdoc
     */
    public function getAllowedTemplateSelection()
    {
        return Template::getSelection(['type' => Template::TYPE_SNIPPED_LAYOUT]);
    }

    /**
     * @inheritdoc
     */
    public function getPageContent()
    {
        return $this->page_content;
    }

    /**
     * @inheritdoc
     */
    public function getPhpViewPath()
    {
        $settings = new SettingsForm();
        return $settings->phpGlobalSnippetPath;
    }

    /**
     * @return string returns the title of this container
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @inheritdoc
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @return string
     */
    public function getEditUrl()
    {
        return Url::toEditSnippet($this->id);
    }

    /**
     * @return string
     */
    public function getPageType()
    {
       return PageType::Snippet;
    }
}
