
<header class="max-w-xl mx-auto mt-20 text-center">
    <h1 class="text-4xl">
        Latest <span class="text-blue-500">Laravel From Scratch</span> Blog
    </h1>
    <h2 class="inline-flex mt-2">{{ isset($user->name)  ? 'By ' . $user->name : 'All Posts' }} <img src="{{$user->getAvatar()}}" width="33" length="20" class="px-1"/> </h2><br/>


        <!-- Other Filters -->
{{--        <div class="relative flex lg:inline-flex items-center bg-gray-100 rounded-xl">--}}
{{--            <select class="flex-1 appearance-none bg-transparent py-2 pl-3 pr-9 text-sm font-semibold">--}}
{{--                <option value="category" disabled selected>Other Filters--}}
{{--                </option>--}}
{{--                <option value="foo">Foo--}}
{{--                </option>--}}
{{--                <option value="bar">Bar--}}
{{--                </option>--}}
{{--            </select>--}}

{{--            <svg class="transform -rotate-90 absolute pointer-events-none" style="right: 12px;" width="22"--}}
{{--                 height="22" viewBox="0 0 22 22">--}}
{{--                <g fill="none" fill-rule="evenodd">--}}
{{--                    <path stroke="#000" stroke-opacity=".012" stroke-width=".5" d="M21 1v20.16H.84V1z">--}}
{{--                    </path>--}}
{{--                    <path fill="#222"--}}
{{--                          d="M13.854 7.224l-3.847 3.856 3.847 3.856-1.184 1.184-5.04-5.04 5.04-5.04z"></path>--}}
{{--                </g>--}}
{{--            </svg>--}}
{{--        </div>--}}

    <!-- Categories -->
        <div class="relative flex lg:inline-flex items-center bg-gray-100 rounded-xl px-3 py-2">
            <form method="GET" action="#">

                <select name="category_id" class="flex-1  bg-transparent py-2 pl-3 pr-9 text-sm font-semibold">

                    <option value="">All</option>
                    @foreach($categories as $category)
                        <option value="{{$category->id}}" @if(isset($selectedCategory) && $selectedCategory->id == $category->id) selected="selected" @endif>{{$category->name}}</option>
                    @endforeach
                </select>

                <input type="text" name="search" placeholder="Find something"
                       class="bg-transparent placeholder-black font-semibold text-sm"
                       value="{{request('search')}}"
                >
                <input type="submit" value="submit">
            </form>
        </div>
    <br><a href="{{route('posts.create')}}" class="text-blue-500">Create a New Post</a><br>
    <a href="{{route('users.posts.index',['user' => auth()->user()->id])}}" class="text-blue-500">View Your Posts</a>
    <br><a href="{{route('users.drafts')}}" class="text-red-500">Drafts</a>


</header>
