<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Possession;
use App\Tag;

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

        $poss = Possession::create([
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => Auth::id()
        ]);

        return Possession::with('tags', 'share')->find($poss->id);
    }

    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {
        return Possession::destroy($id);
    }

    public function addTag(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|max:255'
        ]);

        $tag = Tag::firstOrCreate([
            'title' => $request->title
        ]);

        $poss = Possession::find($id);

        if (!$poss->tags->contains($tag->id)) {
            $poss->tags()->attach($tag->id);
        }

        return $tag;
    }

    public function addShare(Request $request, $id, $userId)
    {
        $poss = Possession::find($id);

        if (!$poss->share->contains($userId)) {
            $poss->share()->attach($userId);
        }

        return 'OK';
    }

    public function favorite(Request $request, $id)
    {
        $poss = Possession::find($id);
        $poss->favorite = !$poss->favorite;
        $poss->save();

        return $poss;
    }
}
