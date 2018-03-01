@extends('posterdigital.layout')

@section('content')

    <div class="row">
        <div class="col-md-6">
            <h2>Top songs</h2>
            <div class="col-tracks"></div>
        </div>
        <div class="col-md-6">
            <h2>Top albums</h2>
            <div class="col-albums"></div>
        </div>
    </div>

    <div class="template item">
        <div class="row">
            <div class="col-md-3 image-container">
                <img class="image img-fluid rounded" />
            </div>
            <div class="col-md-9 info-container">
                <p class="artist"></p>
                <p class="name"></p>
            </div>
        </div>
    </div>

    <script type="text/javascript">

        $(document).ready(function() {

            var httpCall = function() {
                $.ajax({
                    type: 'get',
                    url: '{!! route("api.tops.get", [3]) !!}',
                    success: function (data) {

                        console.log('Getting data from API...')

                        $('.col-tracks').html('');
                        for (var i = 0; i < data.tracks.length; i++) {
                            $item = $('.template.item').first().clone();

                            $item.find('.image').attr('src', data.tracks[i].image);
                            $item.find('.name').text(data.tracks[i].name);
                            $item.find('.artist').text(data.tracks[i].artist);
                            $item.removeClass('template');

                            if (i == 0) {
                                $item.find('.image-container').removeClass('col-md-3').addClass('col-md-6');
                                $item.find('.info-container').removeClass('col-md-9').addClass('col-md-6');
                            }

                            $('.col-tracks').append($item);
                        }

                        $('.col-albums').html('');
                        for (var i = 0; i < data.albums.length; i++) {
                            $item = $('.template.item').first().clone();

                            $item.find('.image').attr('src', data.albums[i].image);
                            $item.find('.name').text(data.albums[i].name);
                            $item.find('.artist').text(data.albums[i].artist);
                            $item.removeClass('template');

                            if (i == 0) {
                                $item.find('.image-container').removeClass('col-md-3').addClass('col-md-6');
                                $item.find('.info-container').removeClass('col-md-9').addClass('col-md-6');
                            }

                            $('.col-albums').append($item);
                        }

                    }
                });
            }

            httpCall();
            setInterval(httpCall, 1000 * 60 * 30); // msecs * secs * minutes

        });

    </script>

@endsection
