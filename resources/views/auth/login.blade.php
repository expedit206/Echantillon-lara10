<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}"
        class="bg-white shadow-md shadow-red-500 rounded-lg px-8 pt-6 pb-8 mb-4 z-10" style="
        border-top-left-radius:4rem;
        border-top-right-radius:4rem;
        ">
        @csrf

        <!-- Sélection du type d'utilisateur -->
        <div class="mb-6">
            <label class="text-gray-900" for="user_type">Je suis</label>
            <div class="flex items-center mt-1">
                <label class="flex items-center me-4">
                    <input type="radio" id="student" name="user_type" value="student"
                        class="text-blue-600 focus:ring-blue-500">
                    <span class="ms-2 text-sm text-gray-900">{{ __('Etudiant') }}</span>
                </label>
                <label class="flex items-center">
                    <input type="radio" id="teacher" name="user_type" value="teacher"
                        class="text-blue-600 focus:ring-blue-500">
                    <span class="ms-2 text-sm text-gray-900">{{ __('Enseignant') }}</span>
                </label>
            </div>
            <x-input-error :messages="$errors->get('user_type')" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="mb-6">
            <label class="text-gray-900" for="email">Adresse email</label>
            <x-text-input id="email"
                class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Mot de passe -->
        <div class="mb-6">
            <label class="text-gray-900" for="password">Mot de passe</label>
            <x-text-input id="password"
                class="block mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Se souvenir de moi -->
        <div class="block mb-6">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-600 text-blue-600 shadow-md focus:ring-blue-500" name="remember">
                <span class="ms-2 text-sm text-gray-900">{{ __('Se souvenir de moi') }}</span>
            </label>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-between">
            @if (Route::has('password.request'))
                <a class="text-sm text-blue-600 hover:text-blue-800 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                    href="{{ route('password.request') }}">
                    {{ __('Mot de passe oublié?') }}
                </a>
            @endif

            <button
                class="hover:bg-red-500 bg-red-800  text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline">
                {{ __('Se connecter') }}
            </button>
        </div>
    </form>

    <!-- Section des particules -->
    <div id="particles-js" style="
            /* background: linear-gradient(180deg, #001f3f, #000); */
            background: url('/img/bglogin.webp') center/cover no-repeat  ;"
            ></div>

    <!-- Script pour particles.js -->
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script>
        particlesJS.load('particles-js', '{{ asset('particles.json') }}', function() {
            console.log('particles.js loaded - callback');
        });
    </script>
</x-guest-layout>
