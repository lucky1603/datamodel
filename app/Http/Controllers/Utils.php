<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Utils
{
    public static function getFilesFromRequest(Request $request, $filename): ?array
    {
        if (!$request->hasFile($filename)) {
            return [
                'filelink' => '',
                'filename' => ''
            ];
        }

        if(is_array($request->file($filename))) {
            $files = [];
            $fileEntries = $request->file($filename);
            foreach($fileEntries as $file) {
                $originalFileName = $file->getClientOriginalName();
                $path = $file->store('documents');
                $path = asset($path);
                $files[] = [
                    'filelink' => $path,
                    'filename' => $originalFileName
                ];
            }
            return $files;
        }


        $file = $request->file($filename);
        $originalFileName = $file->getClientOriginalName();
        $path = $file->store('documents');
        $path = asset($path);
        return [
            'filelink' => $path,
            'filename' => $originalFileName
        ];

    }

    public static function updateProfileStates() {

    }
}
