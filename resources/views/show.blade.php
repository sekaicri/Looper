@extends('layouts.app')

@section('content')
    <div>
        <iframe width="1920" height="1080" src="https://www.youtube.com/embed/{{ $id }}?autoplay=1&loop=1"></iframe>
    </div>
@endsection