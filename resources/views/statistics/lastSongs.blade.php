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
            <th>WHO</th>
            <th>WHEN</th>
            </thead>

            <tbody>
            @foreach($lastTracks as $indexKey => $a_track)
                @if( $indexKey < 5)
                    <tr>
                        <td>{{ $indexKey + 1 }}</td>
                        <td>
                            {{ $a_track->name }}
                        </td>
                        <td>
                             {{$a_track->tracked_by}}
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($a_track->played_at)->format('d F Y h:i') }}
                    </tr>
                @endif

            @endforeach
            </tbody>

        </table>
    </div>
</div>

