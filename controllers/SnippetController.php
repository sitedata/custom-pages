<?php

namespace humhub\modules\custom_pages\controllers;

use Yii;
use humhub\modules\custom_pages\models\ContainerSnippet;
use humhub\modules\custom_pages\models\PageType;
use humhub\modules\custom_pages\models\Snippet;
use yii\web\HttpException;

/**
 * Controller for managing Snippets.
 *
 * @author buddha
 */
class SnippetController extends PageController
{
    /**
     * @inhritdoc
     */
    /*public function behaviors()
    {
        $result = parent::behaviors();
        $result[] = ['class' => TemplateViewBehavior::class];
        return $result;
    }*/

    /**
     * Action for viewing the snippet inline edit view.
     * 
     * @return string
     * @throws HttpException if snippet could not be found.
     */
    public function actionEditSnippet()
    {   
        $snippet = $this->findById(Yii::$app->request->get('id'));
        
        if($snippet == null) {
            throw new HttpException(404, 'Snippet not found!');
        }
        
        return $this->render('edit_snippet', [
            'snippet' => $snippet,
            'html' => $this->renderTemplate($snippet, true)
        ]);
    }

    /**
     * @param int $id integer
     * @return Snippet
     */
    protected function findById($id)
    {
        return Snippet::findOne(['id' => $id]);
    }

    protected function getPageClassName()
    {
        return $this->contentContainer ? ContainerSnippet::class : Snippet::class;
    }

    protected function getPageType()
    {
        return PageType::Snippet;
    }
}
