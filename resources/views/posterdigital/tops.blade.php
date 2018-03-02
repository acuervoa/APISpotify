@extends('posterdigital.layout')

@section('content')

    <div id="app">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <h2>Top songs</h2>
                        <div class="col-tracks">
                            <div class="row">
                                <div class="principal col-md-6">
                                    <result
                                        :item="first(tracks)">
                                    </result>
                                </div>
                                <div class="secondary col-md-6">
                                    <result
                                        v-for="(track, index) in tracks"
                                        v-if="index > 0"
                                        :item="track"
                                        :index="index"
                                        :key="index">
                                    </result>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                    <h2>Top albums</h2>
                    <div class="col-albums">
                        <div class="row">
                            <div class="principal col-md-6">
                                <result
                                    :item="first(albums)">
                                </result>
                            </div>
                            <div class="secondary col-md-6">
                                <result
                                    v-for="(album, index) in albums"
                                    v-if="index > 0"
                                    :item="album"
                                    :index="index"
                                    :key="index">
                                </result>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
