<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Value extends Model
{
    public static function get($instance_id, Attribute $attribute) {
        switch($attribute->type) {
            case 'text':
                $tablename = 'text_values';
                break;
            case 'varchar':
                $tablename = 'varchar_values';
                break;
            case 'integer':
                $tablename = 'integer_values';
                break;
            case 'double':
                $tablename = 'double_values';
                break;
            case 'datetime':
                $tablename = 'datetime_values';
                break;
            case 'select':
                $tablename = 'select_values';
                break;
            case 'file':
                $tablename = 'file_values';
                break;
            case 'bool':
                $tablename = 'bool_values';
                break;
            default:
                break;
        }

        $query = DB::table($tablename)->where([
            'attribute_id' => $attribute->id,
            'instance_id' => $instance_id
        ]);

        if($attribute->type === 'select') {
            $value = $query->get('value')->map(function($item) {
                return $item->value;
            })->toArray();

            if(count($value) === 1) {
                $value = $value[0];
            }

            return $value;
        }

        $value = $query->value('value');
        if($attribute->type === 'bool') {
            $value = $value === 0 ? false : true;
        }

        return $value;

    }

    public static function put($instance_id, Attribute $attribute, $value) {
        switch($attribute->type) {
            case 'text':
                $tablename = 'text_values';
                break;
            case 'varchar':
                $tablename = 'varchar_values';
                break;
            case 'integer':
                $tablename = 'integer_values';
                break;
            case 'double':
                $tablename = 'double_values';
                break;
            case 'datetime':
                $tablename = 'datetime_values';
                break;
            case 'select':
                $tablename = 'select_values';
                break;
            case 'file':
                $tablename = 'file_values';
                break;
            default:
                $tablename = 'bool_values';
                break;
        }

        $query = DB::table($tablename)->where([
            'attribute_id' => $attribute->id,
            'instance_id' => $instance_id
        ]);

        if($query->count() > 1) {
            $query->delete();
        }

        if(!is_array($value)) {
            return DB::table($tablename)->updateOrInsert(
                [
                    'attribute_id' => $attribute->id,
                    'instance_id' => $instance_id
                ],
                [
                    'value' => $value
                ]);
        } else {
            $query->delete();
            foreach ($value as $item) {
                DB::table($tablename)->insert([
                    'attribute_id' => $attribute->id,
                    'instance_id' => $instance_id,
                    'value' => $item]);
            }
        }

    }


}
