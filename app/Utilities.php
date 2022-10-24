<?php

namespace App;

class Utilities {
    public static function deleteInstance(Instance $instance) {
        $childInstances = $instance->instances;
        if($childInstances->count() > 0) {
            foreach($childInstances as $childInstance) {
                $instance->instances()->detach($childInstance->id);
                self::deleteInstance($childInstance);
            }
        }

        $attributes = $instance->attributes;
        foreach($attributes as $attribute) {
            $attribute->removeValue();
        }

        $instance->delete();
    }
}
