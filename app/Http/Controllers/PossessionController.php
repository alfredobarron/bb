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
            'favorite' => 'boolean'
        ]);

        $poss = Possession::create([
            'title' => $request->title,
            'description' => $request->description,
            'favorite' => $request->favorite,
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

    public function removeTag($id,$tagId)
    {
        $poss = Possession::find($id);
        $poss->tags()->detach($tagId);
        return 'OK';
    }

    public function addShare(Request $request, $id)
    {
        $this->validate($request, [
            'userId' => 'required'
        ]);

        $poss = Possession::find($id);

        if (!$poss->share->contains($request->userId)) {
            $poss->share()->attach($request->userId);
        }

        return 'OK';
    }

    public function removeShare($id,$shareId)
    {
        $poss = Possession::find($id);
        $poss->share()->detach($shareId);
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
