<x-layout>
    @section('title','home')

    @section('content')
    <x-header />
    <x-menu />
    <p>Bienvenue</p>
<x-modal-form :annees="$annees" :semestres="$semestres" :niveaux="$niveaux" :specialites="$specialites" :matieres="$uniteValeurs" />
    
@endsection

</x-layout>
