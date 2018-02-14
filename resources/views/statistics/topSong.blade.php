@extends('statistics.layout')

@section('container')
    <div class="topgroup">
        <h2><span class="titlebox">SpotyTop</span></h2>
    </div>

    <div class="midgroup">
        <div class="mainview">
            <header>
                <div class="cover">
                    <img src="{{ $tracks[0]->album->images[1]->url }}"
                         class="img-fluid rounded"
                         alt="{{ $tracks[0]->album->name }}">
                </div>

                <div class="coverInfo">
                    <h4>{{ $tracks[0]->album->name }}</h4>
                    <h1 class="song">{{ $tracks[0]->name }}</h1>
                    <h2>{{ $tracks[0]->reproductions }} times reproduced</h2>
                    <div class="byAuthor">
                            By <a href="#">{{ $tracks[0]->artists[0]->name }}</a>
                            &middot;
                            Duration {{ gmdate('i:s', $tracks[0]->duration_ms / 1000) }}
                    </div>

                        <audio id="music" preload="true">
                                <source src="{{ $tracks[0]->preview_url }}">
                        </audio>
                        <div id="audioplayer">
                            <button id="pButton" class="play"></button>
                            <div id="timeline">
                                <div id="playhead"></div>
                            </div>
                        </div>


                </div>


            </header>


        </div>
    </div>
@endsection