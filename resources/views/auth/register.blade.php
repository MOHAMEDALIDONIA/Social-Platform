<x-guest-layout>
    <h3 class="text-center text-2xl font-semibold mb-6">Register</h3>
    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <!-- Image-->
        <div class="mt-4">
        <x-input-label for="email" :value="__('Image')" />
        <x-text-input id="image" class="block mt-1 w-full" type="file" name="image" />
        <x-input-error :messages="$errors->get('image')" class="mt-2" />
    </div>
    <div class="mt-4">
        <x-input-label for="bio" :value="__('About')" />
        <x-text-input id="bio" class="block mt-1 w-full" type="text" name="bio" :value="old('email')" required autocomplete="username" />
        <x-input-error :messages="$errors->get('bio')" class="mt-2" />
    </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
         

            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 w-full rounded">
                Register
            </button>
        </div>
        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
            {{ __('Already registered?') }}
        </a>
    </form>
</x-guest-layout>
