

<div class="row">
    <div class="col-md-12">
        <h1>Top Album</h1>
    </div>
</div>

<div class="row">
    <div class="col-md-1">
        <h1 class="top1">#1</h1>
    </div>
    <div class="col-md-2">
        <img src="{{ $albums[0]->image_url_300x300 }}"
             alt="{{ $albums[0]->name }}"
             class="img-fluid rounded">
    </div>


    <div class="col-md-4">
        <h1 class="song">{{ $albums[0]->name }}</h1>
        <div class="byAuthor">
            By <a href="#">{{ $albums[0]->artists[0]->name }}</a>
            &middot;
            Reproduced {{ $albums[0]->reproductions }} times


        </div>


    </div>
    <div class="col-lg-5">
        <table class="tracks">

            <thead>
                <th>#</th>
                <th>ALBUM</th>
                <th>ARTIST</th>
                <th>REPRODUCTIONS</th>
            </thead>

            <tbody>
            @foreach($albums as $indexKey => $a_album)
                @if($indexKey > 0 && $indexKey < 5)
                    <tr>
                        <td>{{ $indexKey + 1 }}</td>
                        <td>
                        <img class="img-thumbnail rounded" src="{{ $a_album->image_url_64x64 }}">
                            {{ $a_album->name }}
                        </td>
                        <td>{{ $a_album->artists[0]->name  }}</td>
                        <td> Reproduced {{ $a_album->reproductions }}  Times</td>

                    </tr>
                @endif

            @endforeach
            </tbody>
        </table>
    </div>
</div>
