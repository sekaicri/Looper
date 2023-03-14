@extends('layouts.app')

@section('content')
    <div>
        <iframe width="1920" height="1080" src="https://www.youtube.com/embed/{{ $id }}?controls=0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay=1; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
    </div>
@endsection