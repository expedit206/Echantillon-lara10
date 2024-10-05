<x-layout>
    @section('title', 'matieres->specialite')

    @section('content')
        <x-header />
        <x-menu />

        <div class="mt-4 bg-slate-500 rounded-lg py-5">

        <h2 class="font-semibold text-xl text-gray-800 leading-tight px-5 text-white">
            {{ __('Attribuer des Unités de Valeur à la Spécialité : ') . $specialite->nom }}
        </h2>

    <div class="py-12 bg-slate-500 h-full">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('specialite.assignUnite', $specialite->id) }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($unites as $unite)
                                <div class="flex items-center">
                                    <x-checkbox id="unite_{{ $unite->id }}" name="unite_de_valeurs[]" value="{{ $unite->id }}"
                                        :checked="$specialite->uniteValeurs->contains($unite->id)" />
                                    <label for="unite_{{ $unite->id }}" class="ml-2 block text-sm text-gray-600">
                                        {{ $unite->nom }}
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            <button class="bg-blue-500 rounded-lg p-2 text-white">
                                {{ __('Attribuer') }}
                            </button >
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    @endsection
</x-layout>
