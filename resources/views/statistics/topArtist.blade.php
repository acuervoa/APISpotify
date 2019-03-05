<div class="row">
    <div class="col-md-12">
        <h1>Top Artist</h1>
    </div>
</div>


@if(sizeof($artists) > 0)
    <div class="row">
        <div class="col-md-1">
            <h1 class="top1">#1</h1>
        </div>
        <div class="col-md-2">
            @if(!is_null($artists[0]->image_url_640x640))
                <img src="{{ $artists[0]->image_url_640x640 }}"
                     alt="{{ $artists[0]->name }}"
                     class="img-fluid rounded">
            @endif
        </div>


        <div class="col-md-4">
            <h1 class="song">{{ $artists[0]->name }}</h1>
            <p>Reproduced {{ $artists[0]->reproductions }} times</p>
        </div>
        <div class="col-lg-5">
            <table class="tracks">

                <thead>
                <th>#</th>

                <th>ARTIST</th>
                <th>REPRODUCTIONS</th>
                </thead>

                <tbody>
                @foreach($artists as $indexKey => $a_artist)
                    @if($indexKey > 0 && $indexKey < 5)
                        <tr>
                            <td>{{ $indexKey + 1 }}</td>
                            <td>
                                @if(!is_null($a_artist->image_url_320x320))
                                    <img class="img-fluid rounded imgArtist" src="{{ $a_artist->image_url_320x320 }}">
                                @endif
                                {{ $a_artist->name }}
                            </td>
                            <td>Reproduced {{ $a_artist->reproductions }} times</td>
                        </tr>
                    @endif

                @endforeach
                </tbody>

            </table>
        </div>

    </div>

@endif
