<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;

class FrontController extends Controller
{
    protected $data = [];

    protected function deleteFile($path)
    {
        if (File::exists($path)) {
            File::delete($path);
        }
    }
}
