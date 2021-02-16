<?php

namespace App\Traits;

trait GetModelPropertiesTrait
{
    private function getProperties($model, $properties)
    {
        $finalProperties = array();
        foreach ($properties as $property)
        {
            if(isset($model->{$property})) {
                $finalProperties[$property] = $model->{$property};
            }
        }
        return $finalProperties;
    }
}
