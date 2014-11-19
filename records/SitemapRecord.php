<?php
namespace Craft;

class SitemapRecord extends BaseRecord
{
    public function getTableName()
    {
        return 'sitemap';
    }

    protected function defineAttributes()
    {
        return array(
            'sectionId' => array(AttributeType::Number, 'required' => true),
            'included'  => AttributeType::Bool,
            'frequency' => array(AttributeType::Enum, 'values' => 'always,hourly,daily,weekly,monthly,yearly,never'),
            'priority'  => array(AttributeType::Number, 'decimals' => 1),
            'ping_date' => AttributeType::DateTime
        );
    }
}