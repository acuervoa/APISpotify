@extends('posterdigital.layout')

@section('content')

    <div id="app">
        <h2 class="logo" />
        <h2 v:if="title" class="offset-md-1"> @{{ title }} </h2>
        <div class="container-fluid" v-if="results.length">
            <div class="col-results col-md-12">
                <div class="row">
                    <div class="principal col-md-5 offset-md-1">
                        <result
                            :item="first(results)">
                        </result>
                    </div>
                    <div class="secondary col-md-5">
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

@endsection
