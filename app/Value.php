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
            default:
                $tablename = 'bool_values';
                break;
        }

        $value = DB::table($tablename)->where([
            'attribute_id' => $attribute->id,
            'instance_id' => $instance_id
        ])->value('value');

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
            default:
                $tablename = 'bool_values';
                break;
        }

        return DB::table($tablename)->updateOrInsert(
            [
               'attribute_id' => $attribute->id,
               'instance_id' => $instance_id
            ],
            [
                'value' => $value
            ]);
    }


}
