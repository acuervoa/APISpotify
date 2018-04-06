

<div class="row">
    <div class="col-md-12">
        <h1>Last tracks</h1>
    </div>
</div>
<div class="row">




    <div class="col-lg-12">
        <table class="tracks">

            <thead>
            <th>#</th>

            <th>SONG</th>

            <th>ALBUM</th>
            <th>ARTIST</th>
            <th>WHO</th>
            <th>WHEN</th>
            <th></th>
            </thead>

            <tbody>
            @foreach($lastTracks as $indexKey => $a_track)
                @if( $indexKey < 20)
                    <tr>
                        <td>{{ $indexKey + 1 }}</td>
                        <td>
                            {{ $a_track['track']->name }}
                        </td>
                        <td>
                            {{ $a_track['track']->album->name }}
                        </td>
                        <td>
                            {{ $a_track['track']->artists[0]->name }}
                        </td>
                        <td>
                             {{$a_track['profile']->nick}}
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($a_track['played'])->format('d F Y H:i') }}
                        </td>
                        <td>
                            <a class="playback button green"><i class="fa fa-play"></i></a>
                            <audio id="audio-{{$indexKey + 1}}">
                                <source src="{{ $a_track['track']->preview_url }}">
                            </audio>
                        </td>
                    </tr>
                @endif

            @endforeach
            </tbody>

        </table>
    </div>
</div>

