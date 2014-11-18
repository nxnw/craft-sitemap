<?php

namespace Craft;

class SitemapVariable
{
    public function getAllSections()
    {
        return craft()->sitemap->getAllSections();
    }
}