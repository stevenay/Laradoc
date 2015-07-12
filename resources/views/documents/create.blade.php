@extends('admin')

@section('content')
    <h1 class="page-heading">Create a new document</h1>

    {!! Form::open(['action' => 'DocumentsController@store']) !!}

        @include('documents._form', ['submitButtonText' => 'Save'])

    {!! Form::close() !!}

    @include('errors._list')
@endsection