@extends('layouts.layout')

@section('body')
    <div class="row">
        <div class="col-md-12">

            @foreach($list as $userNick => $recentTracks)

                <hr/>
                <hr/>

                <h2>{{ $userNick }}</h2>

                <table class="tracks">
                    <thead>
                     <tr>
                        <th scope="col">#</th>

                        <th scope="col">Song</th>
                        <th scope="col">Album Name</th>
                        <th scope="col">Artists</th>
                        <th scope="col">Played At</th>
                        <th scope="col">Preview</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($recentTracks as $indexKey => $recentTrack)
                        <tr>
                            <th scope="row">{{ $indexKey + 1 }}</th>
                            <td>{{ $recentTrack->name }}</td>
                            <td>{{ $recentTrack->album->name }}</td>
                            <td>{{ $recentTrack->artists[0]->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($recentTrack->played_at)->format('d F Y H:i') }}</td>
                            <td>
                                @if($recentTrack->album->images[2])
                                    <img src="{{ $recentTrack->album->images[2]->url }}"
                                         class="img-fluid rounded"
                                         alt="{{ $recentTrack->album->name }}">
                                @endif
                                <audio preload id="audio-{{ $recentTrack->id }}">
                                    <source src="{{ $recentTrack->preview_url }}">
                                    Tu navegador no soporta audio
                                </audio>
                                    <a class="button green"
                                       onclick="document.getElementById('audio-{{ $recentTrack->id }}').play()">
                                        <i class="fa fa-play" aria-hidden="true"></i>
                                    </a>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            @endforeach
        </div>
    </div>
@endsection


