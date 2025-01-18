@vite('resources/css/app.css')
    <div class="flex h-full">
        <div class="w-1/2 bg-cover" style="background-image: url('img/cover.jpeg')"></div>
        <div class="w-1/2 p-8">
            <div class="flex items-center justify-center mb-6">
                <img src="img/logo_Journalit_landscape.png" class="w-36" alt="Journal It Logo"/>
            </div>

            <h3 class="text-4xl font-bold mb-4">Register</h3>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm" for="email">Email</label>
                    <input id="email" name="email" type="email" 
                        class="shadow-md appearance-none border-none rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                        placeholder="Type your email here" value="{{ old('email') }}" required />
                    @error('email')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-sm" for="name">User Name</label>
                    <input id="name" name="name" type="text" 
                        class="shadow-md appearance-none border-none rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                        placeholder="Type your username here" value="{{ old('name') }}" required />
                    @error('name')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-sm" for="password">Password</label>
                    <input id="password" name="password" type="password" 
                        class="shadow-md appearance-none border-none rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" 
                        placeholder="Type your password here" required />
                    @error('password')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-sm" for="password_confirmation">Confirm Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" 
                        class="shadow-md appearance-none border-none rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline" 
                        placeholder="Confirm your password" required />
                    @error('password_confirmation')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-center">
                    <button type="submit" class="bg-customPink2 hover:bg-customPink3 text-white w-80 py-2 px-4 rounded-full focus:outline-none focus:shadow-outline">
                        Register
                    </button>
                </div>

                <p class="text-center text-gray-500 text-xs mt-4">
                    Already have an account? <a href="{{ route('login') }}" class="text-customPurple1 hover:text-black"><u>Log In</u></a>
                </p>
            </form>
        </div>
    </div>

    {{-- TODO BUAT JADI COMPONENT --}}
    <div id="popup-registered" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
        <div class="bg-white p-4 rounded-2xl shadow-lg w-1/2 text-center">
            <p class="text-xl font-semibold">Register Success!</p>
            <p class="text-lg text-customPink3">Please log in</p>
            <button id="ok-button" class="bg-customPink2 hover:bg-customPink3 text-white w-3/4 py-2 px-4 rounded-full focus:outline-none focus:shadow-outline" style="margin-top: 16px">
                OK
            </button>
        </div>
    </div>

    <script>
        document.getElementById('ok-button')?.addEventListener('click', () => {
            window.location.href = '/home';
        });
    </script>
