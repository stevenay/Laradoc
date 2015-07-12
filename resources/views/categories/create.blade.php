@extends('admin')

@section('content')
    <h1 class="page-heading">Create a new Category</h1>

    {!! Form::open(['action' => 'CategoriesController@store']) !!}

        @include('categories._form', ['submitButtonText' => 'Save'])

    {!! Form::close() !!}

    @include('errors._list')
@endsection