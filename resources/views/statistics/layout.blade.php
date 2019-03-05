@extends('layouts.layout')

@section('body')
    <div class="fullview">
        @include('statistics.topSong')
        <hr/>
        <hr/>
        @include('statistics.topAlbum')
        <hr/>
        <hr/>
        @include('statistics.topArtist')
        <hr/>
        <hr/>
        {{--@include('statistics.topGenre')--}}
        {{--<hr/>--}}
        {{--<hr/>--}}
        {{--@include('statistics.lastSongs')--}}


    </div>
@endsection

@push('custom-javascript')
    <script type="text/javascript">
        $(function() {
            $(".playback").click(function(e) {
                e.preventDefault();
                // This next line will get the audio element
                // that is adjacent to the link that was clicked.
                var song = $(this).next('audio').get(0);
                if (song.paused) {
                    song.play();
                    this.innerHTML = '<i class="fa fa-pause"></i>';
                } else {
                    song.pause();
                    this.innerHTML = '<i class="fa fa-play"></i>';
                }
            });
        });
    </script>

@endpush
