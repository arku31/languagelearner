@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Create word</div>
                    @if($errors->all())
                        @foreach ($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    @endif
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/words/store') }}">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="word" class="col-md-4 control-label">Word (RU)</label>

                                <div class="col-md-6">
                                    <input id="word" type="text" class="form-control" name="word" value="{{ old('word') }}" required autofocus>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Translation" class="col-md-4 control-label">Translation</label>

                                <div class="col-md-6">
                                    <input id="Translation" type="text" class="form-control" name="translation" value="{{ old('Translation') }}" required autofocus>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn"/>
                            </div>

                           
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
