<div class="row">
    <div class="col-md-12">
        <h1 class="titlebox">{{ $numberOfTracks }} reproductions &middot;
            {{ $numberOfAlbums }} albums &middot;
            {{ $numberOfArtists }} artists &middot;
            {{ $numberUsers }} users
        </h1>
    </div>

</div>

<div class="row">
    <div class="col-md-12">
        <h1>Top Songs</h1>
    </div>
</div>

<div class="row">
    <div class="col-md-1">
        <h1 class="top1">#1</h1>
    </div>
    <div class="col-md-2">
        <img src="{{ !(count($tracks) >= 1) ?: $tracks[0]->album->image_url_300x300 }}"
             alt="{{ !(count($tracks) >= 1) ?: $tracks[0]->album->name }}"
             class="img-fluid rounded img-thumbnail">
    </div>

    <div class="col-md-4">

        <h4>{{ !(count($tracks) >= 1) ?: $tracks[0]->album->name }}</h4>

        <h1 class="song">{{ !(count($tracks) >= 1) ?: $tracks[0]->name }}</h1>
        {{--<p>{{ !(count($tracks) >= 1) ?: $tracks[0]->ponderatedReproductions }} ponderated times reproduced <br>--}}
            {{ !(count($tracks) >= 1) ?: $tracks[0]->reproductions }} times reproduced</p>
        <div class="byAuthor">
            By <a href="#">{{ !(count($tracks) >= 1) ?: $tracks[0]->album->artists[0]->name }}</a>
            &middot;
            Duration {{ gmdate('i:s', !(count($tracks) >= 1) ?: $tracks[0]->duration_ms / 1000) }}
            &middot;

            <a class="playback button green">
              <i class="fa fa-play" aria-hidden="true"></i>
            </a>
            <audio preload id="audio-top1">
                <source src="{{ !(count($tracks) >= 1) ?: $tracks[0]->preview_url }}">
            </audio>

        </div>


    </div>
    <div class="col-lg-5">
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
                @if($indexKey > 0 && $indexKey < 5)
                    <tr>
                        <td>{{ $indexKey + 1 }}</td>
                        <td>{{ $a_track->name }}</td>
                        <td>{{ $a_track->album->artists[0]->name  }}</td>
                        <td> Reproduced {{ $a_track->reproductions }}  Times</td>
                        {{--(pond. {{ $a_track->ponderatedReproductions }})--}}
                        <td>
                            <a class="playback button green">
                                <i class="fa fa-play" aria-hidden="true"></i>
                            </a>
                            <audio id="audio-{{$indexKey + 1}}">
                                <source src="{{ $a_track->preview_url }}">
                            </audio>
                        </td>
                    </tr>
                @endif

            @endforeach
            </tbody>
        </table>
    </div>
</div>
