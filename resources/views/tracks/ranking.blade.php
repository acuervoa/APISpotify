@extends('layouts.layout')

@section('body')

    <div class="topgroup">
     <h1 class="titlebox">Top 20</h1>
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

        @foreach($tracksInfo->tracks as $indexKey => $a_trackInfo)
            {{--{{ dd($a_trackInfo  ) }}--}}
            <tr>
                <td scope="row">{{ $indexKey }}</td>

                {{--<td>{{ $a_trackInfo->id }}</td>--}}
                <td>
                    @if(($indexKey === 0 ) && $a_trackInfo->album->images[1])
                        <img src="{{ $a_trackInfo->album->images[1]->url }}" class="rounded media-middle" alt="{{ $a_trackInfo->album->name }}">
                    @elseif($a_trackInfo->album->images[2] && $indexKey !== 0)
                        <img src="{{ $a_trackInfo->album->images[2]->url }}" class="rounded media-middle" alt="{{ $a_trackInfo->album->name }}">
                    @endif
                </td>
                <td ><span>{{ $a_trackInfo->name }}</span></td>
                <td>{{ $a_trackInfo->album->name }}</td>
                <td>{{ $a_trackInfo->artists[0]->name }}</td>
                <td>
                    <div>{{$a_trackInfo->ponderatedReproductions }} ponderated reproductions (sqrt n)</div>
                    <div class="">{{ $a_trackInfo->reproductions }} reproductions</div>
                    <div>
                        @foreach($a_trackInfo->profiles as $profile)
                            <div>
                                {{ $profile->tracked_by }} play this {{ $profile->times }} times
                                &middot;
                                {{ $profile->ponderatedReproductions }} ponderated times
                            </div>
                            {{--<ul>--}}
                            {{--@foreach($profile->played_at as $played_at)--}}
                                {{--<li>{{ $played_at->played_at }}</li>--}}
                            {{--@endforeach--}}
                            {{--</ul>--}}
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

