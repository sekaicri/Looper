@extends('layouts.app')

@section('content')
    <div>
        <iframe width="560" height="315" src="https://www.youtube.com/embed/{{ $id }};controls=0&amp;showinfo=0;autoplay=1&mute=1" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
    </div>
@endsection