<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Possession;

class PossessionController extends Controller
{
    public function index()
    {
        return view('possessions');
    }

    public function byUser()
    {
        return Possession::with('tags', 'share')->where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'required',
        ]);

        $q = Possession::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => Auth::id()
        ]);

        return Possession::with('tags', 'share')->find($q->id);
    }

    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {
        $q = Possession::destroy($id);
    }
}
