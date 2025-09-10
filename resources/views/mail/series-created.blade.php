@component('mail::message')
#{{$nomeSerie ?? ''}} criada

A série {{$nomeSerie ?? ''}} com {{$qtdTemporadas ?? ''}} temporadas e {{$epPorTemporada ?? ''}} episódios por temporada foi criada.
@component('mail::button', ['url' => route('series.seasons', $id??1)]) Ver série @endcomponent
@endcomponent