@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Words</div>
                    @if($errors->all())
                        @foreach ($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    @endif
                    <div class="panel-body">
                        <ul>
                        @foreach ($words as $word)
                            <li>{{$word->word}} - {{$word->translation}}</li>
                        @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
