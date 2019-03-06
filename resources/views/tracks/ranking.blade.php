@extends('layouts.layout')

@section('body')
    {{debug($tracksInfo)}}
    <div class="topgroup">
        <h1 class="titlebox">All time - Top 20 Songs</h1>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            {{--<th scope="col">Id</th>--}}
            <th scope="col">Album Image</th>
            <th scope="col">Song</th>
            <th scope="col">Album Name</th>
            <th scope="col">Artists</th>
            <th scope="col">Reproductions</th>
            <th scope="col">Preview</th>
        </tr>
        </thead>
        <tbody>

        @foreach($tracksInfo as $indexKey => $a_trackInfo)

            <tr>
                <td scope="row">{{ $indexKey + 1}}</td>

                <td>
                    @if(!is_null($a_trackInfo->album->image_url_64x64))
                        <img src="{{ $a_trackInfo->album->image_url_64x64 }}" class="rounded media-middle"
                             alt="{{ $a_trackInfo->album->name }}">
                    @endif
                </td>
                <td><span>{{ $a_trackInfo->name }}</span></td>
                <td>{{ $a_trackInfo->album->name }}</td>
                <td>
                    @foreach($a_trackInfo->artists as $artist)
                        {{ $artist->name }}@if(!$loop->last), @endif
                    @endforeach
                </td>
                <td>
                    <div class="">{{ $a_trackInfo->reproductions }} reproductions</div>
                </td>
                <td>
                    @if(!empty($a_trackInfo->preview_url))
                        <audio id="audio-{{$indexKey + 1}}">
                            <source src="{{ $a_trackInfo->preview_url }}">
                        </audio>
                        <a class="button green"
                           onclick="document.getElementById('audio-{{$indexKey +1}}').play()">
                            <i class="fa fa-play" aria-hidden="true"></i>
                        </a>
                        <a class="button green"
                           onclick="document.getElementById('audio-{{$indexKey +1}}').stop()">
                            <i class="fa fa-pause" aria-hidden="true"></i>
                        </a>
                    @endif
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>

@endsection

