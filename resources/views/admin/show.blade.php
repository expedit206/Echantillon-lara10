<x-layout>
    @section('title', 'Admin Details')

    @section('content')
    <x-header />
    <x-menu />

    <div class="max-w-5xl mx-auto p-8 bg-slate-500 rounded-lg shadow-lg mt-10 ">
        <div class="bg-orange-500 p-4 rounded-t-lg text-white text-center">
            <h1 class="text-2xl font-bold">DÉTAIL ADMINISTRATEUR : [{{ strtoupper($admin->nom) }}]</h1>
            <p class="text-lg mt-2">RÔLE : {{ $admin->role }}</p>
        </div>

        <div class="flex justify-between mt-4 px-4">
            <a href="
            {{-- {{ route('admins') }} --}}
             " class="text-orange-500 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0L2.293 10.707a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L4.414 9H17a1 1 0 110 2H4.414l3.293 3.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Retour
            </a>
            <a href="
            {{-- {{ route('admin.edit', $admin->id) }} --}}
             " class="text-orange-500 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M17.414 2.586a2 2 0 00-2.828 0L7.586 9.586a2 2 0 00-.586 1.414v3.414a1 1 0 001 1h3.414a2 2 0 001.414-.586l7-7a2 2 0 000-2.828zM7 12.414V10h2.414l6-6L13 4.414l-6 6zm2.707 2.293a1 1 0 00-1.414-1.414L7 14.586V17h2.414l1.293-1.293z" />
                </svg>
                Éditer les infos de l'admin
            </a>
        </div>

        <!-- Section pour les informations personnelles -->
        <div class="mt-6 bg-gray-100 p-4 rounded-lg">
            <h2 class="text-xl font-semibold text-orange-500">IDENTIFICATION</h2>
            <div class="overflow-x-auto mt-4">
                <table class="min-w-full bg-white rounded-lg shadow-md">
                    <thead class="bg-gray-200 text-gray-700">
                        <tr>
                            <th class="py-3 px-6 text-left">Nom</th>
                            <th class="py-3 px-6 text-left">Rôle</th>
                            <th class="py-3 px-6 text-left">Email</th>
                            <th class="py-3 px-6 text-left">Mot de Passe</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        <tr>
                            <td class="py-3 px-6">{{ $admin->nom }}</td>
                            <td class="py-3 px-6">{{ $admin->role }}</td>
                            <td class="py-3 px-6">{{ $admin->email }}</td>
                            <td class="py-3 px-6">********</td> <!-- Ne pas afficher le mot de passe -->
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @endsection
</x-layout>
