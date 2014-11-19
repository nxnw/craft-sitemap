<?php

namespace Craft;

class SitemapVariable
{
    public function getAllSections()
    {
        return craft()->sitemap->getAllSections();
    }

    public function getLastPingDate()
    {
        $model = craft()->sitemap->getLastPingDate()->ping_date;
        $arr = array(
            'date' => date_format($model, 'F j, Y'),
            'time' => date_format($model, 'g:ia')
        );

        return $arr;
    }
}