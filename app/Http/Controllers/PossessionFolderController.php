<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\PossessionFolder;

class PossessionFolderController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'nullable|string',
            'possession_id' => 'integer'
        ]);

        return PossessionFolder::create([
            'title' => $request->title,
            'description' => $request->description,
            'possession_id' => $request->possession_id
        ]);
    }
}
