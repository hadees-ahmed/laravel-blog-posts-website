
@props(['posts'])
@forelse($posts as $post)
<article
    class="transition-colors duration-300 hover:bg-gray-100 border border-black border-opacity-0 hover:border-opacity-5 rounded-xl">
    <div class="flex justify-between items-center mt-8">
        <div class=" flex items-center text-sm">
        <img src="/images/lary-avatar.svg" alt="Blog Post illustration" class="rounded-sm" width="50" height="100">
        <a href="users/{{$post->user->id}}/posts"> <h1 class="font-bold">{{$post->user->name}}</h1></a>
        </div>
    </div>
    <div class="py-6 px-5">
        <div>
            <img src="/images/illustration-3.png" alt="Blog Post illustration" class="rounded-xl" width="400" height="300">
        </div>

        <div class="mt-8 flex flex-col justify-between">
            <header>
                <div class="space-x-2">
                    <a href="#"
                       class="px-3 py-1 border border-blue-300 rounded-full text-blue-300 text-xs uppercase font-semibold"
                       style="font-size: 10px">{{$post->category->name}}</a>
{{--                    <a href="#"--}}
{{--                       class="px-3 py-1 border border-red-300 rounded-full text-red-300 text-xs uppercase font-semibold"--}}
{{--                       style="font-size: 10px">Updates</a>--}}
                </div>


                <div class="mt-4">
                    <h1 class="text-3xl">
                        {{$post->title}}</h1>
                    <span class="mt-2 block text-gray-400 text-xs">
                                        Published <time>{{$post->published_at->diffForHumans()}}</time>
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

            <footer class="flex justify-between  items-center mt-8">
                <div class=" flex items-center text-sm">
                    <div class="ml-3">
                        @foreach($post->comment as $comment)
                            <img src="/images/lary-avatar.svg" alt="Lary avatar">
                            <a href="/users/{{$comment->user->id}}/posts"><h5 class="font-bold">{{$comment->user?->name . " Commented:"}}</h5></a>
                            <h6>{{$comment->comments}}</h6>
                        @endforeach
                    </div>
{{--                    <br>--}}
{{--                    <h7 class="font-bold">Comments</h7>--}}
{{--                    @foreach($post->comment as $comment)--}}
{{--                        <p>{{$comment->comments}}</p>--}}
{{--                    @endforeach--}}

                </div>

                <div class="flex justify-between  items-center mt-8">
                    <form method="GET" action="/users/{{auth()->user()->id}}/comment/{{$post->id}}" class="flex items-center ">
                       <input type="text" class="transition-colors duration-300 text-xs font-semibold bg-gray-200 hover:bg-gray-300 rounded-full py-2 px-8" name="comment" placeholder="Type Comment..."
                    >
                    </form>
                </div>
            </footer>
        </div>
    </div>
</article>
@empty
    {{'User has not published any posts for this category yet'}}
@endforelse
{{ $posts->links() }}

