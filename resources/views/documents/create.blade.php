@extends('app')

@section('content')
    <h1 class="page-heading">Create a new document</h1>
    
    {!! Form::open(['action' => 'DocumentsController@store']) !!}
    
    <div class="form-group">
        {!! Form::label('title', 'Document Title') !!}
        {!! Form::text('title', null, ['class' => 'form-control']) !!}
    </div>
    
    <div class="form-group">
        {!! Form::label('content', 'Document Content') !!}
        {!! Form::textarea('content', null, ['class' => 'form-control']) !!}
    </div>
    
    <div class="form-group">
        {!! Form::submit('Save', ['class' => 'btn btn-primary form-control']) !!}
    </div>
    
    {!! Form::close() !!}

    @include('errors._list')
@endsection