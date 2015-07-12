@extends('admin')

@section('content')

    <h1 class="page-heading">Edit Category</h1>

    {!! Form::model($category, ['method' => 'PATCH', 'action' => ['CategoriesController@update', $category->id]]) !!}
    
        @include('categories._form', ['submitButtonText' => 'Update'])

    {!! Form::close() !!}

    @include('errors._list')
    
@endsection