<?php

namespace App;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
            case 'timestamp':
                $tablename = 'timestamp_values';
                break;
            default:
                break;
        }

        $query = DB::table($tablename)->where([
            'attribute_id' => $attribute->id,
            'instance_id' => $instance_id
        ]);

        if($attribute->type === 'file') {
            $file = $query->get(['value', 'link'])->first();
            $value = [];
            $value['filename'] = isset($file->value) ? $file->value : '';
            $value['filelink'] = isset($file->link) ? $file->link: '';
            return $value;
        }

        if($attribute->type === 'select') {
            $value = $query->get('value')->map(function($item) {
                return $item->value;
            })->toArray();

            if(count($value) === 1) {
                $value = $value[0];
            } else {
                $value = __("Not Selected");
            }

            return $value;
        }

        $value = $query->value('value');
        if($attribute->type === 'bool') {
            $value = $value === null || $value === 0 ? false : true;
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
                $value = new DateTime($value);
                break;
            case 'timestamp':
                $tablename = 'timestamp_values';
                $value = new DateTime($value);
                break;
            case 'select':
                $tablename = 'select_values';
                break;
            case 'file':
                $filename = $value['filename'];
                $filelink = $value['filelink'];

                return DB::table('file_values')->updateOrInsert(
                    [
                        'attribute_id' => $attribute->id,
                        'instance_id' => $instance_id
                    ],
                    [
                        'value' => $filename,
                        'link' => $filelink,
                    ]);
            default:
                $tablename = 'bool_values';
                if($value === 'on') $value = true;
                if($value === 'off') $value = false;
                break;
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
            $query = DB::table($tablename)->where([
                'attribute_id' => $attribute->id,
                'instance_id' => $instance_id
            ]);

            if($query->count() > 1) {
                $query->delete();
            }

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
