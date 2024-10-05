<x-layout>
    @section('title', 'Modifier le mot de passe')

    @section('content')
    <x-header />
    <x-menu />

    <div class="max-w-4xl mx-auto p-8 bg-slate-500 rounded-lg shadow-lg mt-10">
        <div class="bg-orange-500 p-4 rounded-t-lg text-white text-center">
            <h1 class="text-2xl font-bold">Modifier le Mot de Passe</h1>
        </div>

        <!-- Formulaire de modification de mot de passe -->
        <form action="{{ route('password.update') }}" method="POST" class="mt-6 bg-gray-100 p-4 rounded-lg">
            @csrf
            @method('put')

            <!-- Mot de passe actuel -->
            <div class="mb-4">
                <label for="current_password" class="block text-gray-700">Mot de passe actuel</label>
                <input id="current_password" type="password" name="current_password" required
                       class="w-full px-2 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                <!-- Affichage de l'erreur pour le champ mot de passe actuel -->
                @error('current_password')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Nouveau mot de passe -->
            <div class="mb-4">
                <label for="new_password" class="block text-gray-700">Nouveau mot de passe</label>
                <input id="new_password" type="password" name="new_password" required
                       class="w-full px-2 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                <!-- Affichage de l'erreur pour le champ nouveau mot de passe -->
                @error('new_password')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Confirmation du nouveau mot de passe -->
            <div class="mb-4">
                <label for="new_password_confirmation" class="block text-gray-700">Confirmer le nouveau mot de passe</label>
                <input id="new_password_confirmation" type="password" name="new_password_confirmation" required
                       class="w-full px-2 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                <!-- Affichage de l'erreur pour la confirmation du nouveau mot de passe -->
                @error('new_password_confirmation')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="text-center">
                <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded-lg">Modifier le mot de passe</button>
            </div>
        </form>
    </div>

    @endsection
</x-layout>
