@extends('layouts.layout')

@section('body')
    <div class="fullview">
        @include('statistics.topSong')
        <hr/>
        <hr/>
        @include('statistics.topAlbum')
        <hr/>
        <hr/>
        @include('statistics.topArtist')
        <hr/>
        <hr/>
        {{--@include('statistics.topGenre')--}}
        {{--<hr/>--}}
        {{--<hr/>--}}
        {{--@include('statistics.lastSongs')--}}


    </div>
@endsection