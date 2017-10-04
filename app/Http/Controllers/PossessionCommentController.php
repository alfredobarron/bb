<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\PossessionComment;

class PossessionCommentController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'comment' => 'required|string',
            'possession_id' => 'integer'
        ]);

        return PossessionComment::create([
            'comment' => $request->comment,
            'possession_id' => $request->possession_id
        ]);
    }
}
