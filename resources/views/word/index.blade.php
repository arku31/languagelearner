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
                    @if($message)
                        <div class="alert  alert-{{$message['type']}}">
                            {{$message['msg']}}
                        </div>
                    @endif
                    <div class="panel-body">
                        <table class="table">
                        @foreach ($words as $word)
                            <tr>
                                <td>{{$word->word}}</td>
                                <td>{{$word->translation}}</td>
                                <td><a href="/words/destroy/{{$word->id}}">Delete</a></td>
                            </tr>
                        @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
