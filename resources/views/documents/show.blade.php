@extends('app')

@section('content')

    {{-- Edit the Document Link --}}
    @if (Auth::check())

        <a href="{{ action("DocumentsController@edit", [str_slug($document->category->category_name.' '.$document->title)])  }}" class="btn btn-info">Edit</a>
    @endif

    {{--<h1 class="page-heading">{{ $document->title }}</h1>--}}
    
    {!! $document->content !!}



@endsection
