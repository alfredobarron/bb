<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Notifications\UpdatePassword;
use App\Notifications\EmailChange as EmailChangeNotification;
use Validator;
use Storage;
use Image;
use Carbon\Carbon;
use App\User;
use App\EmailChange;


class UserController extends Controller
{
    public function profile()
    {
        $user = User::with('emailChange')->find(Auth::id());
        return view('profile', ['user' => $user]);
    }

    public function updateProfile(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email'
        ]);

        $user = User::find($id);
        $user->name = $request->name;
        $user->save();

        if ($request->email != $user->email) {
            $emailChange = EmailChange::updateOrCreate(
                ['user_id' => Auth::id()],
                [
                    'user_id' => Auth::id(),
                    'email' => $request->email,
                    'token' => $this->createToken() // str_random(10)
                ]
            );

            $user->notify(new EmailChangeNotification($emailChange));

            $user->email_change = $user->emailChange;

            return response()->json([
                'user' => $user,
                'emailChange' => 'We send a confirmation mail to email account '.$user->email.', for change email'
            ]);
        }

        return compact('user');
    }

    public function updatePassword(Request $request, $id)
    {
        $this->validate($request, [
            'current' => 'required',
            'password' => 'required',
            'password_confirmation' => 'required|same:password'
        ]);

        $user = User::find($id);

        if (!Hash::check($request->current, $user->password)) {
            return response()->json(['current' => ['Current password does not match']], 422);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        $user->notify(new UpdatePassword($user));

        return compact('user');
    }

    public function uploadAvatar(Request $request, $id)
    {
        $pathFile = $request->file('files')->store('avatars/'.$id, 'public');
        $infoFile = pathinfo($pathFile);
        $file = Storage::disk('public')->get('avatars/'.$id.'/'.$infoFile['basename']);

        $image = Image::make($file)
            ->resize(100, 100)
            ->save(storage_path('app/public/avatars/'.$id.'/'.$infoFile['basename']));

        $user = User::find($id);
        $user->avatar = $infoFile['basename'];
        $user->save();

        return response()->json([
            'data' => ['avatar' => $user->avatar, 'avatar_url' => $user->avatar_url]
        ]);
    }

    public function emailChange($token)
    {
        $emailChange = EmailChange::where('token', $token)->first();

        $messages = [
            'error' => 'Email change request is expired.',
            'sujest' => 'If still do you want change email, generate a new request.'
        ];

        if ($emailChange) {
            if (Carbon::parse($emailChange->updated_at)->addMinute()->isPast()) {
                $emailChange->delete();
                return view('emailchange.expiredtoken', ['messages' => $messages]);
            } else {
                return view('emailchange.emailchange', ['token' => $token]);
            }
        } else {
            return view('emailchange.expiredtoken', ['messages' => $messages]);
        }

        return view('emailchange.emailchange', ['token' => $token]);
    }

    public function emailUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'token' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect('email/change/'.$request->token)
                    ->withErrors($validator)
                    ->withInput();
        }

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {

            $emailChange = EmailChange::where('token', $request->token)->first();

            if ($emailChange) {
                $user->email = $emailChange->email;
                $user->save();

                $emailChange->delete();
            }
        } else {
            $validator->errors()->add('email', 'Invalid Credentials');
            return redirect('email/change/'.$request->token)
                    ->withErrors($validator)
                    ->withInput();
        }

        $messages = [
            'success' => 'Email has change success.',
            'sujest' => 'Now you can acces with new email.'
        ];

        return view('emailchange.success', ['messages' => $messages]);
    }

    private function createToken()
    {
        $key = env('APP_KEY', 'secret');

        if (Str::startsWith($key, 'base64:')) {
            $key = base64_decode(substr($key, 7));
        }

        return hash_hmac('sha256', Str::random(40), $key);
    }

    // public function byNameOrEmail($name)
    // {
    //     return User::where('id', '<>', Auth::id())
    //         ->where(function ($query) use ($name) {
    //             $query->where('name', 'like', '%'.$name.'%')
    //                   ->orWhere('email', 'like', '%'.$name.'%');
    //         })->get();
    // }
}
