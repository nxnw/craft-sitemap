<?php

namespace Craft;

class SitemapController extends BaseController
{
    public function actionSaveSections($ping = false)
    {
        $no_err = true;
        $this->requirePostRequest();


        $sections = craft()->request->getPost('sections');

        $models = SitemapModel::populateModels($sections);

        foreach( $models as $mod) {
            $mod->included = !empty($mod->included) ? 1 : 0;
            if($ping && $mod->included > 0) {
                $mod->ping_date = date("Y-m-d H:i:s");
            }
            $no_err = craft()->sitemap->saveSections($mod);
        }
        if($no_err) {
            craft()->userSession->setNotice(Craft::t('Sitemap Created'));
        } else {
            craft()->userSession->setNotice(Craft::t('Error'));
        }
        craft()->sitemap->generateSitemap();

    }

    public function actionPingSections()
    {
        $this->actionSaveSections(true);
        craft()->sitemap->pingSearchEngines();
        craft()->userSession->setNotice(Craft::t('Search Engines have been pinged'));
    }
}