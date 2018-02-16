<div class="topgroup">
    <h1 class="titlebox">{{ $numberOfTracks }} reproductions &middot; {{ $numberOfAlbums }} albums &middot; {{ $numberOfArtists }} artists</h1>
    {{--<h2><span class="titlebox">SpotyTop</span></h2>--}}
</div>

<div class="midgroup">

    <div class="mainview">
        <header>
            <h1 class="top1">#1</h1>
            <div class="cover">
                <img src="{{ $tracks[0]->album->images[1]->url }}"
                     class="img-fluid rounded"
                     alt="{{ $tracks[0]->album->name }}">
            </div>

            <div class="coverInfo">
                <h4>{{ $tracks[0]->album->name }}</h4>
                <h1 class="song">{{ $tracks[0]->name }}</h1>
                <h2>{{ $tracks[0]->ponderatedReproductions }} ponderated times reproduced</h2>
                <p>{{ $tracks[0]->reproductions }} times reproduced</p>
                <div class="byAuthor">
                    By <a href="#">{{ $tracks[0]->artists[0]->name }}</a>
                    &middot;
                    Duration {{ gmdate('i:s', $tracks[0]->duration_ms / 1000) }}
                </div>

                <audio controls>
                    <source src="{{ $tracks[0]->preview_url }}">
                </audio>


            </div>

            <table class="tracks">

                <thead>
                <th>#</th>
                <th>SONG</th>
                <th>ARTIST</th>
                <th>REPRODUCTIONS</th>
                <th></th>

                </thead>

                <tbody>
                @foreach($tracks as $indexKey => $a_track)
                    @if($indexKey > 0 && $indexKey < 50)
                        <tr>
                            <td>{{ $indexKey + 1 }}</td>
                            <td>
                                <img class="rounded" src="{{ $a_track->album->images[2]->url }}">
                                {{ $a_track->name }}
                            </td>
                            <td>{{ $a_track->artists[0]->name  }}</td>
                            <td>{{ $a_track->ponderatedReproductions }} ponderated reproductions &middot; Reproduced {{ $a_track->reproductions }} Times</td>
                            <td>
                                <audio controls>
                                    <source src="{{ $a_track->preview_url }}">
                                </audio>
                            </td>
                        </tr>
                    @endif

                @endforeach
                </tbody>
            </table>

        </header>


    </div>
</div>
