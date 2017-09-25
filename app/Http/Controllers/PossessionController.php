<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Storage;

use App\Possession;
use App\PossessionFile;
use App\PossessionShare;
use App\Tag;

use App\Http\Controllers\PossessionFileController;

class PossessionController extends Controller
{
    public function index()
    {
        return view('possessions');
    }

    public function viewPossession(Request $request, $possessionId)
    {
        $possession = Possession::with('files', 'tags', 'share', 'parent')->find($possessionId);

        return view('possession', ['possession' => $possession]);
    }

    public function byUser(Request $request, $parentId = 0)
    {
        // $possShare = PossessionShare::where('user_id', Auth::id())->get();
        // $possShare->implode('possession_id', ', ');
        //
        // return Possession::with('tags', 'share', 'user')
        // ->where('user_id', Auth::id())
        // ->OrwhereIn('id', $possShare)
        // ->orderBy('created_at', 'desc')->get();

        $query = Possession::with('files', 'tags', 'share', 'user')
        ->orderBy('type', 'desc')
        ->where('user_id', Auth::id());

        // if ($parentId) {
            $query->where('parent_id', $parentId);
        // } else {
        //     $query->where('parent_id', 0);
        // }

        $possessions = $query->get();

        $parent = Possession::find($parentId);

        return ['possessions' => $possessions, 'parent' => $parent];
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            // 'description' => 'required',
            // 'favorite' => 'boolean'
        ]);

        $poss = Possession::create([
            'title' => $request->title,
            // 'description' => $request->description,
            // 'favorite' => $request->favorite,
            'user_id' => Auth::id(),
            'parent_id' => $request->parent_id,
            'type' => $request->type
        ]);

        if (count($request['files'])) {
            foreach ($request['files'] as $key => $value) {
                $fileCtrl = new PossessionFileController();
                $fileCtrl->moveFromTemp($value['pathFile'], $poss->id);
                PossessionFile::create([
                    'basename' => $value['infoFile']['basename'],
                    'extension' => $value['infoFile']['extension'],
                    'possession_id' => $poss->id
                ]);
            }
        }

        if (count($request->tags)) {
            $collection = collect($request->tags);
            $unique = $collection->unique();
            $unique->values()->all();

            foreach ($unique as $key => $value) {
                $tag = Tag::firstOrCreate([
                    'title' => $value
                ]);

                if (!$poss->tags->contains($tag->id)) {
                    $poss->tags()->attach($tag->id);
                }
            }
        }

        if (count($request->share)) {
            $collection = collect($request->share);
            $unique = $collection->unique();
            $unique->values()->all();

            foreach ($unique as $key => $value) {
                if (!$poss->share->contains($value['id'])) {
                    $poss->share()->attach($value['id']);
                }
            }
        }

        return Possession::with('files', 'tags', 'share')->find($poss->id);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'required'
        ]);

        $poss = Possession::find($id);
        $poss->title = $request->title;
        $poss->description = $request->description;
        $poss->save();

        return $poss;
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
