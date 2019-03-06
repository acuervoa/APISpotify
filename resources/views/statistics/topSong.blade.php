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



@if (sizeof($tracks) > 0)


    <div class="row">
        <div class="col-md-1">
            <h1 class="top1">#1</h1>
        </div>
        <div class="col-md-2">
            @if (!is_null($tracks[0]->album->image_url_640x640))
                <img src="{{ $tracks[0]->album->image_url_640x640 }}"
                     alt="{{ $tracks[0]->album->name }}"
                     class="img-fluid rounded">
            @endif
        </div>

        <div class="col-md-4">

            <h4>{{ $tracks[0]->album->name }}</h4>

            <h1 class="song">{{ $tracks[0]->name }}</h1>
            <p>{{ $tracks[0]->reproductions }} times reproduced</p>
            <div class="byAuthor">
                By <a href="#">{{ $tracks[0]->artists[0]->name }}</a>
                &middot;
                Duration {{ gmdate('i:s', $tracks[0]->duration_ms / 1000) }}
                &middot;
                @if(!empty($tracks[0]->preview_url))
                    <audio preload id="audio-top1">
                        <source src="{{ $tracks[0]->preview_url }}">
                    </audio>

                    <a class="button green" onclick="document.getElementById('audio-top1').play()">
                        <i class="fa fa-play" aria-hidden="true"></i>
                    </a>
                @endif
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
                            <td>
                                @if (!is_null($a_track->album->image_url_64x64))
                                    <img class="img-fluid rounded" src="{{ $a_track->album->image_url_64x64 }}">
                                @endif
                                {{ $a_track->name }}
                            </td>

                            <td>
                                @if(sizeof($a_track->artists)>0)
                                    {{ $a_track->artists[0]->name  }}
                                @endif
                            </td>
                            <td> Reproduced {{ $a_track->reproductions }} Times
                            </td>
                            <td>
                                @if(!empty($a_track->preview_url))
                                    <audio id="audio-{{$indexKey + 1}}">
                                        <source src="{{ $a_track->preview_url }}">
                                    </audio>
                                    <a class="button green"
                                       onclick="document.getElementById('audio-{{$indexKey +1}}').play()">
                                        <i class="fa fa-play" aria-hidden="true"></i>
                                    </a>
                                    <a class="button green"
                                       onclick="document.getElementById('audio-{{$indexKey +1}}').stop()">
                                        <i class="fa fa-pause" aria-hidden="true"></i>
                                    </a>
                            </td>
                            @endif
                        </tr>
                    @endif

                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endif

