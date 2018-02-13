@extends('layouts.layout')

@section('body')


    <table class="table">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Id</th>
            <th scope="col">Song</th>
            <th scope="col">Album Name</th>
            <th scope="col">Artists</th>
            <th scope="col">Reproductions</th>
            <th scope="col">Preview</th>
        </tr>
        </thead>
        <tbody>

        @foreach($tracksInfo->tracks as $indexKey => $a_trackInfo)
            <tr>
                <th scope="row">{{ $indexKey }}</th>
                <td>{{ $a_trackInfo->id }}</td>
                <td>{{ $a_trackInfo->name }}</td>
                <td>{{ $a_trackInfo->album->name }}</td>
                <td>{{ $a_trackInfo->artists[0]->name }}</td>
                <td>
                    <div>{{ $a_trackInfo->reproductions }}</div>
                    <div>
                        @foreach($a_trackInfo->profiles as $profile)
                            <div>{{ $profile->tracked_by }} play this {{ $profile->times }} times</div>
                            <ul>
                            @foreach($profile->played_at as $played_at)
                                <li>{{ $played_at->played_at }}</li>
                            @endforeach
                            </ul>
                        @endforeach
                    </div>

                </td>
                <td>
                    <audio controls>
                        <source src="{{ $a_trackInfo->preview_url }}">
                        Tu navegador no soporta audio
                    </audio>
                </td>

            </tr>
        @endforeach

        </tbody>
    </table>

@endsection

