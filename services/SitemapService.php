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

    public function getAllSections()
    {
        $sections = $this->sectionRecord->findAll();

        return SitemapModel::populateModels($sections, 'id');
    }

    public function saveSections($models)
    {
        foreach($models as $model) {
            if($id = $model->getAttribute('id')) {
                if(null === ($record = $this->sectionRecord->find('id=:id', array('id' => $id)))) {
                    throw new Exception(Craft::t('Can\'t find Section with ID "{id}"', array('id' => $id)));
                }
            } else {
                $record = new SectionRecord;
            }

            $record->setAttributes($model->getAttributes());
            if($record->save()) {
                // update id on model (for new records)
                $model->setAttribute('id', $record->getAttribute('id'));
            } else {
                $model->addErrors($record->getErrors());

                return false;
            }
        }
        return true;
    }
}