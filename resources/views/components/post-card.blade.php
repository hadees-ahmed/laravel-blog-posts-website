

@forelse($posts as $post)
<article
    class="transition-colors duration-300 hover:bg-gray-100 border border-black border-opacity-0 hover:border-opacity-5 rounded-xl mt-5">

    <div class="flex justify-between items-center mt-8">
        <div class=" flex items-center text-sm">
        <img src="{{$post->user->getAvatar()}}"
            alt="Blog Post illustration" class="rounded-sm" width="50" height="100">
            <a href="{{route('users.posts.index',['user'=> $post->user])}}" > <h1 class="font-bold">{{$post->user->name}}</h1></a>
        </div>

        <div class="flex justify-between  items-center mt-0 mr-5">
            @can('delete', $post)
                <a href="{{route('posts.delete',['post' => $post->id])}}" style="color: orangered">{{ $post->published_at ? "Delete Post" : "Delete Draft" }}</a>
            @endcan
        </div>
    </div>
    <div class="py-6 px-5">
        <div>
            <img src="{{$post->getThumbnail()}}"
                 alt="Blog Post illustration" class="rounded-xl" width="400" height="300">
        </div>

        <div class="mt-8 flex flex-col justify-between">
            <header>
                <div class="space-x-2">
                    <a href="?category_id={{$post->category->id}}"
                       class="px-3 py-1 border border-blue-300 rounded-full text-blue-300 text-xs uppercase font-semibold"
                       style="font-size: 10px">{{$post->category->name}}</a>
                    @if($user->id || $post->user_id == auth()->user()->id)
                        <a href="{{route('posts.edit',['post' => $post->id])}}"
                           class="px-3 py-1 border border-red-300 rounded-full text-red-300 text-xs uppercase font-semibold"
                           style="font-size: 10px">Edit</a>
                    @endif
                </div>


                <div class="mt-4">
                    <h1 class="text-3xl">
                        {{$post->title}}</h1>
                    <span class="mt-2 block text-gray-400 text-xs">
                        @if($post->published_at)
                            Published <time>{{$post->published_at->diffForHumans()}}</time>
                        @endif
                    </span>
                </div>
            </header>

            <div class="text-sm mt-4">
                <p>
                    {{$post->body}}
                </p>

                <p class="mt-4">
                    Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                </p>
            </div>

            <footer class=" mt-8">
                <div class="flex justify-between  items-center mt-8">
                    @if($post->published_at)
                    <a href="{{ route('posts.comments.index', ['post' => $post->id]) }}" class="transition-colors duration-300 text-xs font-semibold bg-gray-200 hover:bg-gray-300 rounded-full py-2 px-8">{{'View Comments (' . $post->comments_count . ')'}}</a>
{{--                    <a href="https://example.com" target="_blank" style="color: orangered">Delete Post</a>--}}
                    @endif
                </div>
            </footer>
        </div>
    </div>
</article>
@empty
    {{'You do not has any posts in this section'}}
@endforelse
{{ $posts->links() }}

