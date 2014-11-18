<?php

namespace Craft;

class SitemapController extends BaseController
{
    public function actionSaveSections()
    {
        $this->requirePostRequest();

        $model = new SitemapModel;

        $sections = craft()->request->getPost('sections');

        craft()->sitemap->saveSections($model::populateModels($sections));

    }

    public function actionPingSections()
    {
        $this->actionSaveSections();

    }
}