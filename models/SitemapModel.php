<?php
namespace Craft;

class SitemapModel extends BaseModel
{
    protected function defineAttributes()
    {
        return array(
            'id'    => AttributeType::Number,
            'sectionId' => array(AttributeType::Number, 'required' => true),
            'included'  => AttributeType::Bool,
            'frequency' => array(AttributeType::Enum, 'values' => 'always,hourly,daily,weekly,monthly,yearly,never'),
            'priority'  => array(AttributeType::Number, 'decimals' => 1),
            'ping_date' => AttributeType::DateTime
        );
    }
}