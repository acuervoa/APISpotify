<div class="row">
    <div class="col-md-12">
        <h1>Top Genre</h1>
    </div>
</div>
<div class="row">
    <div class="col-md-1">
        <h1 class="top1">#1</h1>
    </div>
    <div class="col-md-2">
        <h1>{{ $genres[0]->name }}</h1>
    </div>



    <div class="col-lg-5">
        <table class="tracks">

            <thead>
            <th>#</th>

            <th>GENRE</th>
            <th>REPRODUCTIONS</th>
            </thead>

            <tbody>
            @foreach($genres as $indexKey => $a_genre)
                @if($indexKey > 0 && $indexKey < 5)
                    <tr>
                        <td>{{ $indexKey + 1 }}</td>
                        <td>
                            {{ $a_genre->name }}
                        </td>
                        <td></td>
                    </tr>
                @endif

            @endforeach
            </tbody>

        </table>
    </div>
</div>

