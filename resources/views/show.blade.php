@extends('layouts.app')

@section('content')
    <div>
        <iframe width="1920" height="1080" src="https://www.youtube.com/embed/{{ $id }}?rel=0&modestbranding=1&autohide=1&mute=1&loop=1&showinfo=0&controls=0&autoplay=1" frameborder="0" allowfullscreen></iframe>
    </div>
@endsection