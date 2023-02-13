<?php

namespace App;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
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
                $tablename = $attribute->type.'_values';
                break;
        }

        $query = DB::table($tablename)->where([
            'attribute_id' => $attribute->id,
            'instance_id' => $instance_id
        ]);

        if($attribute->type === 'file') {
            $files = $query->get(['value', 'link']);
            if($files->count() > 0) {
                if($attribute->extra != 'multiple') {
                    $file = $files->first();
                    $value = [];
                    $value['filename'] = $file->value ?? '';
                    $value['filelink'] = $file->link ?? '';
                    return $value;
                } else {
                    $values = [];
                    foreach($files as $file) {
                        $value = [];
                        $value['filename'] = $file->value;
                        $value['filelink'] = $file->link;
                        $values[] = $value;
                    }
                    return $values;
                }
            } else {
                return null;
            }

        }

        if($attribute->type === 'select' || $attribute->type === 'varchar') {
            $value = $query->get('value')->map(function($item) {
                return $item->value;
            })->toArray();

            if(count($value) === 1) {
                $value = $value[0];
            } elseif(count($value) == 0) {
                $value = /* __("Not Selected") */ null;
            }

            return $value;
        }

        $value = $query->value('value');
        if($attribute->type === 'bool') {
            $value = !($value === null || $value === 0);
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
                if($attribute->extra == 'multiple') {
                    $value = explode(';', $value);
                    $counter = 0;
                    foreach ($value as $val) {
                        $val = trim($val);
                        if($val == '')
                            unset($value[$counter]);
                        $value[$counter] = $val;
                        $counter++;
                    }
                }
                break;
            case 'integer':
                $tablename = 'integer_values';
                break;
            case 'double':
                $tablename = 'double_values';
                break;
            case 'datetime':
                $tablename = 'datetime_values';
                if($value != null)
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
                if($value != null && is_array($value) && !isset($value['filename'])) {
                    $query = DB::table('file_values')->where([
                        'attribute_id' => $attribute->id,
                        'instance_id' => $instance_id
                    ]);

                    $query->delete();

                    foreach($value as $fileitem) {
                        DB::table('file_values')->insert([
                            'attribute_id' => $attribute->id,
                            'instance_id' => $instance_id,
                            'value' => $fileitem['filename'],
                            'link' => $fileitem['filelink']
                        ]);
                    }

                    return count($value);
                } else if($value != null) {
                    // var_dump($value);
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
                } else {
                    $query = DB::table('file_values')->where([
                        'attribute_id' => $attribute->id,
                        'instance_id' => $instance_id
                    ]);

                    $query->delete();
                }

            default:
                $tablename = 'bool_values';
                if($value === 'on') $value = true;
                if($value === 'off') $value = false;
                break;
        }

        if(!is_array($value)) {
            if($attribute->type === 'select'  && ( $value === null ||  $value === 'null' )){
                return DB::table($tablename)->where([
                    'attribute_id' => $attribute->id,
                    'instance_id' => $instance_id
                ])->delete();
            }

            return DB::table($tablename)->updateOrInsert(
                [
                    'attribute_id' => $attribute->id,
                    'instance_id' => $instance_id,
                ],
                [
                    'value' => $value
                ]);
        } else {
            $query = DB::table($tablename)->where([
                'attribute_id' => $attribute->id,
                'instance_id' => $instance_id
            ]);

            $query->delete();

            try {
                foreach ($value as $item) {
                    DB::table($tablename)->insert([
                        'attribute_id' => $attribute->id,
                        'instance_id' => $instance_id,
                        'value' => $item]);
                }
            } catch (QueryException $ex) {
                echo $ex->getMessage().'<br />';
            }

        }

    }

    public static function remove($instance_id, Attribute $attribute) {
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
                $tablename = $attribute->type.'_values';
                break;
        }

        $query = DB::table($tablename)->where([
            'attribute_id' => $attribute->id,
            'instance_id' => $instance_id
        ]);

        $query->delete();
    }


}
