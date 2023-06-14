<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = cache()->remember('users',now()->addHour(), function ()
        {
            return User::all();
        });
        return view('users', compact('users'));
    }
    public function edit(User $user = null)
    {
        return view('edit', [
            'user'=> $user
        ]);
    }

    public function update(StoreUserRequest $request)
    {
        $attributes = $request->validated();

        $user = auth()->user();

        if ($request->get('user_id')){
            $this->authorize('before', $user);
            User::where('id',$request->get('user_id'))->update($attributes);
            //clear cache
            cache()->forget('users');
            return redirect('/users');
        } else {

            /* alternative ways
                 1)-> $attributes['password'] = bcrypt(  $attributes['password'] );
                2)-> $attributes['password'] = Hash::make($attributes['password']);
            */

            /* way of update the user
                User::where('id', auth()->user()->id)->update($attributes);
            */

            auth()->user()->update($attributes);
            cache()->forget('users');
            return redirect('/posts');
        }
    }
    public function destroy(User $user)
    {
        $user->posts()->delete();
        $user->comments()->delete();

        $user->delete();
        //clear cache
        cache()->forget('users');
        cache()->forget('posts');
        cache()->forget('comments');
        return redirect('users');
    }
    public function promote(User $user)
    {
        $user->is_Admin = true;
        $user->save();

        cache()->forget('users');
        return redirect()->back();
    }

    public function demote(User $user)
    {
        $user->is_Admin = false;
        $user->save();

        cache()->forget('users');
        return redirect()->back();
    }

}
