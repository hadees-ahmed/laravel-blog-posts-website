<x-layout>
    <form method="POST" action="{{isset($verification_code) ? route('verify.code') : route('update.password')}}">
        @csrf
        @if(isset($verification_code))
            <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="email">Enter Verification Code</label>
            <input class="border border-gray-400 p-2 w-full mb-2"  type="text" name="code" required><br>
        @else
            <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="">New Password</label>
            <input class="border border-gray-400 p-2 w-full"  type="password" name="password"  required><br><br>
        @endif

        @if ($errors->any())
            <div class="text-red-500 text-xs mt-1">
                {{ $errors->first() }}
            </div>
        @endif
        <input class="border border-gray-400 p-2 w-full mb-2" type="submit" value="{{isset($verification_code) ? 'Verify' : 'Change Password'}}"><br>
        </form>
    @if(isset($verification_code))
        <div id="resend-code-container" style="display: none;">
    <form method="POST" action="{{route('verification.code')}}">
        @csrf
        <input type="hidden" value="{{$user->email}}" name="email">
        <input class="border border-gray-400 p-2 w-full" type="submit" value="Resend-Code"><br>
    </form>
        </div>
        <script>
            setTimeout(function () {
                document.getElementById('resend-code-container').style.display = 'block';
            }, 3000); // Delay execution for 3 seconds (3000 milliseconds)
        </script>
    @endif
</x-layout>
