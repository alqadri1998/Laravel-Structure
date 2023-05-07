<?php
namespace App\Traits;

use Illuminate\Database\Eloquent\Collection;

trait TranslationFallBackApi {


    public function setTranslations($collection, $relationName = 'languages', $nestedRelations = [], $unsetOrignal = true) {
        if (count($collection) > 0) {
            foreach ($collection as $key => $model) {
                if (!is_array($relationName)) {
                    if (strlen($relationName) > 0) {
                        $translation = $this->translateRelation($model, $relationName);
                        if ($unsetOrignal) {
                            unset($collection[$key]->$relationName);
                        }
                        $collection[$key]->{'translation'} = $translation;
                    }
                }
                // loop through nested relations
                if (count($nestedRelations) > 0) {
                    foreach ($nestedRelations as $nestedKey => $value) {
                        if (isset($model->$nestedKey)) {
                            // check if model has collection of related models
                            if ($model->$nestedKey instanceof Collection) {
                                if (!is_array($value)) {
                                    $nestedRelationCollection = $this->setTranslations($model->$nestedKey, $value);
                                } else {
                                    $nestedRelationCollection = $this->setTranslations($model->$nestedKey, '', $value);
                                }
                                unset($collection[$key]->$nestedKey);
                                $collection[$key]->$nestedKey = $nestedRelationCollection;
                            } else {
                                if (!is_array($value)) {
                                    $nestedRelationTranslation = $this->translateRelation($model->$nestedKey, $value);
                                } else {
                                    $nestedRelationTranslation = $this->translateRelation($model->$nestedKey, '', $value);
                                }
                                unset($collection[$key]->$nestedKey->$value);
                                $collection[$key]->$nestedKey->{'translation'} = $nestedRelationTranslation;
                            }
                        }
                    }
                }
            }
        }
        return $collection;
    }

    public function translateRelation($model, $relationName = 'languages') {

        $languageId = config('app.locales.' . config('app.locale'));
        foreach ($model->$relationName as $language) {
            if ($language->id == $languageId) {
                return $language->pivot;
            }
        }
        if (count($model->{$relationName}) > 0){
            return $model->{$relationName}[0]->pivot;
        }
        else{
            return new \stdClass();
        }
    }

}