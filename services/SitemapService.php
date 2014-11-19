<?php
namespace Craft;

class SitemapService extends BaseApplicationComponent
{
    protected $sectionRecord;

    public function __construct($sectionRecord = null)
    {
        $this->sectionRecord = $sectionRecord;
        if (is_null($this->sectionRecord)) {
            $this->sectionRecord = SitemapRecord::model();
        }
    }

    public function getAllIncludedSections()
    {
        $sections = $this->sectionRecord->findAll('included=:inc', array('inc' => true));

        return SitemapModel::populateModels($sections, 'id');
    }

    public function getAllSections()
    {
        $sections = $this->sectionRecord->findAll();

        return SitemapModel::populateModels($sections, 'id');
    }

    public function getSectionById($id)
    {
        $section = $this->sectionRecord->find('sectionId=:id', array('id' => $id));

        return SitemapModel::populateModel($section);
    }

    public function saveSections(SitemapModel &$model)
    {
            if($id = $model->getAttribute('id')) {
                if(null === ($record = $this->sectionRecord->find('id=:id', array('id' => $id)))) {
                    throw new Exception(Craft::t('Can\'t find Section with ID "{id}"', array('id' => $id)));
                }
            } else {
                $record = new SitemapRecord;
            }

            $record->setAttributes($model->getAttributes());
            if($record->save()) {
                // update id on model (for new records)
                $model->setAttribute('id', $record->getAttribute('id'));
                return true;
            } else {
                $model->addErrors($record->getErrors());
                return false;
            }
    }


    public function generateSitemap()
    {
        $sections = craft()->sitemap->getAllIncludedSections();
        $entRec = EntryRecord::model();
        $base_url = UrlHelper::getSiteUrl();
        $content = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        $content .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";

        foreach($sections as $section) {
            $entries = $entRec->findAll('sectionId=:id', array('id' => $section->sectionId));
            $models = EntryModel::populateModels($entries);
            foreach($models as $entry) {
                $element = ElementRecord::model()->find('id=:id', array('id' => $entry->id));
                if($element->enabled == 1) {
                    $elementLoc = ElementLocaleRecord::model()->find('elementId=:id', array('id' => $entry->id));
                    $content .= "\t<url>\n";
                    $content .= "\t\t<loc>" . $base_url . ($elementLoc->uri == '__home__' ? '' : $elementLoc->uri) . "</loc>\n";
                    $content .= "\t\t<lastmod>" . $entry->dateUpdated . "</lastmod>\n";
                    $content .= "\t\t<changefreq>" . $section->frequency . "</changefreq>\n";
                    $content .= "\t\t<priority>" . $section->priority . "</priority>\n";
                    $content .= "\t</url>\n";
                }
            }
        }
        $content .= "</urlset>";

        $fp = fopen($_SERVER['DOCUMENT_ROOT'] . '/sitemap.xml', 'w');
        fwrite($fp, $content);
        fclose($fp);

    }

    public function pingSearchEngines()
    {
        $rtn_str = '';
        $base_url = UrlHelper::getSiteUrl();

        $engines = array(
            'Google'        => 'http://www.google.com/webmasters/tools/ping?sitemap='.urlencode($base_url.'sitemap.xml'),
            'Bing / MSN'    => 'http://www.bing.com/webmaster/ping.aspx?siteMap='.$base_url.'sitemap.xml'
        );

        foreach($engines as $site => $url) {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            $rtn_str .= $site.': '.$httpCode."\n";
        }
//        return $rtn_str.' | '.urlencode($base_url.'sitemap.xml');
    }

    public function getLastPingDate()
    {
        $sections = $this->sectionRecord->find(array(
            'select' => '*',
            'condition' => 'ping_date IS NOT NULL',
            'order' => 'ping_date DESC',
            'limit' => 1
        ));

        return SitemapModel::populateModel($sections);
    }
}