<?php

namespace Craft;

class SitemapWidget extends BaseWidget
{
    public function getName()
    {
        return Craft::t('Last Sitemap Ping Date');
    }

    public function getBodyHtml()
    {
        return craft()->templates->render('sitemap/widgetbody');
    }
}