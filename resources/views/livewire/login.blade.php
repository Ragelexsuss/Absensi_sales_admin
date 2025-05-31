<div>
    <div class="min-h-screen flex items-center justify-center  px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-lg shadow-md">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    Login
                </h2>
            </div>
            @error('error')
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded my-4">
                {{ $message }}
            </div>
            @enderror

            <form class="mt-8 space-y-6" method="POST" wire:submit.prevent="login">
                @csrf
                <input type="hidden" name="remember" value="true">


                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                        <input id="username" name="username" type="text" required
                               wire:model="email"
                               class="mt-1 w-full border rounded-lg px-3 py-2 focus:outline-none shadow-md"
                               placeholder="Username">
                        @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input
                            @if($showPassword)
                                type="text"
                            @else
                                type="password"
                            @endif
                            id="show_password" placeholder="Masukan Password" name="password" class="w-full border rounded-lg px-3 py-2 focus:outline-none " wire:model="password"
                            >

                        </div>
                        @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <input data-toggle-password='{"target": "#show_password"}'  type="checkbox" name="remember"  id="hs-toggle-password-checkbox" class="mr-1 checkbox checkbox-xs" wire:model.live="showPassword" value="show">
                        {{--                        <input type="checkbox" wire:model="show_password" value="show">--}}
                        <label for="remember" class="text-gray-700">Show Password</label>
                    </div>
                <div>
                    <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <i class="fas fa-sign-in-alt"></i>
                    </span>
                        Masuk
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
