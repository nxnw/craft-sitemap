<?php

namespace Craft;

class SitemapVariable
{
    public function getAllSections()
    {
        return craft()->sitemap->getAllSections();
    }

    public function getSectionById($id)
    {
        return craft()->sitemap->getSectionById($id);
    }

    public function getLastPingDate()
    {
        $ping_date = craft()->sitemap->getLastPingDate()->ping_date;
        if(!empty($ping_date)) {
            $arr = array(
                'date' => date_format($ping_date, 'F j, Y'),
                'time' => date_format($ping_date, 'g:ia')
            );
            return $arr;
        }
        return null;

    }
}