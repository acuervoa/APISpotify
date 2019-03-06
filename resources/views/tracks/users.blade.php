@extends('layouts.layout')

@section('body')
    <div class="topgroup">
        <h1 class="titlebox">Every users - Last 5 Songs</h1>
    </div>
    <div class="row">
        <div class="col-md-12">

            @foreach($list as $userNick => $arrayRecentTracks)
                <h3>{{ $userNick }}</h3>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Id</th>
                        <th scope="col">Song</th>
                        <th scope="col">Album Name</th>
                        <th scope="col">Artists</th>
                        <th scope="col">Played At</th>
                        <th scope="col">Preview</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($arrayRecentTracks as  $indexKey => $recentTrack)

                        <tr>
                            <th scope="row">{{ $indexKey + 1}}</th>
                            <td>
                                @if($recentTrack['data'][0]->album->image_url_64x64)
                                    <img src="{{ $recentTrack['data'][0]->album->image_url_64x64 }}"
                                         class="rounded-right"
                                         alt="{{ $recentTrack['data'][0]->album->name }}">
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($recentTrack['played'])->format('d F Y') }}</td>

                            <td>{{ $recentTrack['data'][0]->name }}</td>
                            <td>{{ $recentTrack['data'][0]->album->name }}</td>
                            <td>
                                @foreach($recentTrack['data'][0]->artists as $artist)
                                    {{ $artist->name }} @if (!$loop->last), @endif
                                @endforeach
                            </td>
                            <td>
                                @if(!empty($recentTrack['data'][0]->preview_url))
                                    <audio id="audio-{{$indexKey + 1}}">
                                        <source src="{{ $recentTrack['data'][0]->preview_url }}">
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
    @endforeach


@endsection


