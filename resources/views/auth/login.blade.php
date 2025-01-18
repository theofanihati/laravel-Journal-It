@vite('resources/css/app.css')
    <div class="flex h-full">
        <div class="w-1/2 bg-cover" style="background-image: url('img/cover.jpeg')"></div>
        <div class="w-1/2 p-8">
            <div class="img-fluid" style="height:116px;"></div>
            <div class="flex items-center justify-center">
                <img src="img/logo_Journalit_landscape.png" class="w-36" alt="Journal It Logo"/>
            </div>

            <h3 class="text-4xl font-bold mb-4">Login</h3>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm" for="email">Email</label>
                    <input id="email" type="email" name="email" 
                        class="shadow-md appearance-none border-none rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                        placeholder="Type your email here" :value="{{ old('email') }}" required autofocus autocomplete="username">
                    @if ($errors->has('email'))
                        <p class="text-red-500 text-xs mt-2">{{ $errors->first('email') }}</p>
                    @endif
                </div>

                <div class="mb-4">
                    <label class="block text-sm" for="password">Password</label>
                    <input id="password" type="password" name="password" 
                        class="shadow-md appearance-none border-none rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                        placeholder="Type your password here" required autocomplete="current-password">
                    @if ($errors->has('password'))
                        <p class="text-red-500 text-xs mt-2">{{ $errors->first('password') }}</p>
                    @endif
                </div>

                <div class="block mb-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                        <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <div class="flex items-center justify-center">
                    <button type="submit" class="bg-customPink2 hover:bg-customPink3 text-white w-80 py-2 px-4 rounded-full focus:outline-none focus:shadow-outline">
                        {{ __('Login') }}
                    </button>
                </div>

                <div class="text-center mt-4">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-customPurple1 hover:text-black text-sm">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif
                </div>

                <p class="text-center text-gray-500 text-xs mt-4">
                    Don\'t have an account yet? <a href="/register" class="text-customPurple1 hover:text-black"><u>Sign Up</u></a>
                </p>
            </form>
            <div class="img-fluid" style="height:188px; width: 720px;"></div>
        </div>
    </div>
