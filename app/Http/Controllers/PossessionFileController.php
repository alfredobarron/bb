<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Storage;
use Image;

use App\PossessionFile;

class PossessionFileController extends Controller
{
    public function uploadTemp(Request $request)
    {
        $pathFile = $request->file->store('files/temp/'.Auth::id(), 'public');

        $infoFile = pathinfo($pathFile);

        return ['pathFile' => $pathFile, 'infoFile' => $infoFile];
    }

    public function moveFromTemp($pathFile, $possessionId)
    {
        $infoFile = pathinfo($pathFile);

        Storage::disk('public')->move($pathFile, 'files/'.$possessionId.'/'.$infoFile['basename']);

        $file = Storage::disk('public')->get('files/'.$possessionId.'/'.$infoFile['basename']);

        if (in_array(strtolower($infoFile['extension']), ['jpg', 'jpeg', 'png']) ) {
            $this->resize($file, $possessionId, $infoFile);
            $this->createThumb($file, $possessionId, $infoFile);
        }
    }

    private function resize($file, $possessionId, $infoFile)
    {
        Image::make($file)->widen(1024)->save(storage_path('app/public/files/'.$possessionId.'/'.$infoFile['basename']));
    }

    private function createThumb($file, $possessionId, $infoFile)
    {
        Image::make($file)->widen(400)->crop(300, 200)->save(storage_path('app/public/files/'.$possessionId.'/thumb_'.$infoFile['basename']));
    }
}
