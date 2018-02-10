@extends('layouts.layout')

@section('body')

    @foreach($list as $userNick => $recentTracks)
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
        </tr>
        </thead>
        <tbody>

        @foreach($recentTracks->items as $indexKey => $recentTrack)
            <tr>
                <th scope="row">{{ $indexKey }}</th>
                <td>{{ $recentTrack->track->id }}</td>
                <td>{{ $recentTrack->track->name }}</td>
                <td>{{ $recentTrack->track->album->name }}</td>
                <td>{{ $recentTrack->track->artists[0]->name }}</td>
                <td>{{ $recentTrack->played_at }}</td>
            </tr>
        @endforeach

        </tbody>
    </table>
@endforeach
@endsection

