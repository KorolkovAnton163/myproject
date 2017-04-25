<?php

namespace App\Http\Controllers;


use App\Http\Requests\RequestImageUpload;
use App\Image;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    const DISK = 'public';
    const SUB_FOLDER = 'images';

    public function upload(RequestImageUpload $request)
    {
        $file = $request->file('image');
        $date = Carbon::now();
        $path = self::SUB_FOLDER . '/' . $date->format('Y') . '/' . $date->format('m') . '/' . $date->format('d');

        $image = new Image([
            'path' => $path,
            'name' => $file->getClientOriginalName(),
            'extension' => $file->getClientOriginalExtension(),
        ]);

        $image->save();

        Storage::disk(self::DISK)->makeDirectory($path);

        $file->move(public_path($path), $file->getClientOriginalName());

        return [
            'id' => $image->id,
            'path' => url('/') . '/' . $image->path . '/' . $image->name,
        ];
    }
}