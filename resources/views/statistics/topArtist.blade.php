<div class="row">
    <div class="col-md-12">
        <h1>Top Artist</h1>
    </div>
</div>
<div class="row">
    <div class="col-md-1">
        <h1 class="top1">#1</h1>
    </div>
    <div class="col-md-2">
        <img src="{{ $artists[0]->images[1]->url }}"
             alt="{{ $artists[0]->name }}"
             class="img-fluid rounded">
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
                            <img class="img-fluid rounded imgArtist" src="{{ $a_artist->images[1]->url }}">
                            {{ $a_artist->name }}
                        </td>
                        <td>Reproducrd {{ $a_artist->reproductions }} times</td>
                    </tr>
                @endif

            @endforeach
            </tbody>

        </table>
    </div>
</div>

