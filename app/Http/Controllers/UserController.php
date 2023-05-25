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
        return view('users', [
            'users'=> User::all()
        ]);
    }
    public function edit(User $user = null)
    {


        return view('edit',[
            'user'=> $user
        ]);
    }

    public function update(StoreUserRequest $request)
    {
        $attributes = array_filter($request->validated());
        $user = auth()->user();

        if ($request->get('user_id')){
            $this->authorize('before', $user);
            User::where('id',$request->get('user_id'))->update($attributes);
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
            return redirect('/posts');
        }
    }
    public function destroy(User $user)
    {
        $user->posts()->delete();

        $user->delete();

        return redirect('users');
    }
}
