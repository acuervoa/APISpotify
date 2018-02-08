<ul>
    @foreach($tracksInfo->tracks as $a_trackInfo)

        <li>{{ $a_trackInfo->name }} -- {{ $a_trackInfo->album->name }} -- {{ $a_trackInfo->artists[0]->name }}</li>
    @endforeach
</ul>

