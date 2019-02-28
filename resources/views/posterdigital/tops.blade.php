@extends('posterdigital.layout')

@section('content')

    <div id="app">
        <h2> @{{ title }} </h2>
        <div class="container-fluid" v-if="results.length">
            <div class="col-results">
                <div class="row">
                    <div class="principal">
                        <result
                            :item="first(results)">
                        </result>
                    </div>
                    <div class="secondary">
                        <div class="row">
                            <result
                                v-for="(result, index) in results"
                                v-if="index > 0"
                                :item="result"
                                :index="index"
                                :key="index">
                            </result>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
