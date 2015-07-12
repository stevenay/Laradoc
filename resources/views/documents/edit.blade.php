@extends('admin')

@section('content')

    <h1 class="page-heading">Edit: {{ $document->title }}</h1>

    {!! Form::model($document, ['method' => 'PATCH', 'action' => ['DocumentsController@update', str_slug($document->category->category_name.' '.$document->title)]]) !!}

        @include('documents._form', ['submitButtonText' => 'Save edit'])

    {!! Form::close() !!}

    @include('errors._list')

@endsection