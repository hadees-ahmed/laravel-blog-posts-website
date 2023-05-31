@csrf

<div class="mb-6">

    <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="name">Name</label>
    <input class="border border-gray-400 p-2 w-full" type="text" name="name"
           value="@if(isset($user)) {{old('name',$user->name)}} @else {{old('name',auth()->user())}} @endif"
           maxlength="20"
           @guest()
                required
            @endguest
    >
    @error('name')
    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
    @enderror

    <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="email">Email</label>
    <input class="border border-gray-400 p-2 w-full" type="email" name="email" value="@if(isset($user)) {{old('email',$user->email)}} @else {{old('email',auth()->user())}} @endif" maxlength="100"
           @guest()
                required
            @endguest
    >

    @error('email')
    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
    @enderror
    @auth()
        @if(!$user)
        <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="current_password"> Current Password </label>
        <input class="border border-gray-400 p-2 w-full" type="password" name="current_password" value="" maxlength="50" minlength="3">
        @error('current_password')
        <p class="text-red-500 text-xs mt-1">{{"The provided password do not matches with current password"}}</p>
        @enderror
        @endif
    @endauth


        <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="password">New Password </label>
    <input class="border border-gray-400 p-2 w-full" type="password" name="password" value="" maxlength="50" minlength="3"
           @guest()
                 required
            @endguest
    ><br>
    @error('password')
    <p class="text-red-500 text-xs mt-1">{{$message}}</p>
    @enderror
    @if(isset($user))
    <input type="hidden" value="{{$user->id}}" name="user_id">
        @error('user_id')
        <p class="text-red-500 text-xs mt-1">{{$message}}</p>
        @enderror
    @endif

    @if(!isset($user))
    <label class="block mb-2 uppercase font-bold text-xs text-gray-700"
           for="profile">
        Profile Picture (optional)
    </label>

    <input class="border border-gray-400 p-2 w-full" type="file" name="avatar">
        @error('thumbnail')
        <p class="text-red-500 text-xs mt-1">{{$message}}</p>
        @enderror
    @endif

    <br><br><input class="border border-gray-400 p-2 w-full" type="submit" value="Submit">
</div>
