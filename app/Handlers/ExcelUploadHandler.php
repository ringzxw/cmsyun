<?php

namespace App\Handlers;

class ExcelUploadHandler
{
    protected $allowed_ext = ["xlsx", "xls"];

    public function save($file, $folder)
    {
        $extension = strtolower($file->getClientOriginalExtension()) ?: 'xlsx';
        if ( ! in_array($extension, $this->allowed_ext)) {
            return false;
        }
        $filename = time() . '_' . str_random(10) . '.' . $extension;
        $path = $file->storeAs(
            $folder, $filename, 'admin'
        );
        $upload_path = public_path() . '/uploads/'.$path;
        return $upload_path;
    }
}
