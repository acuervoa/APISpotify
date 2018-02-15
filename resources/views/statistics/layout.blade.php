@extends('layouts.layout')

@section('body')
    <div class="fullview">
        @include('statistics.topSong')
        <hr/>
        @include('statistics.topAlbum')
    </div>
@endsection