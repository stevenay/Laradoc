@extends('admin')

@section('content')
    <h1 class="page-heading">Categories</h1>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <table class="table table-striped table-ordered table-condensed table-responsive">
                <thead>
                    <th>Id</th>
                    <th class="col-md-6">Name</th>
                    <th>No of Docs</th>
                    <th>Update</th>
                    <th>Delete</th>
                </thead>

                <tbody>
                    @foreach($categories as $category)

                        <?php $docCount = $category->documents->count(); ?>

                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->category_name }}</td>
                            <td style="text-align: center;">{{ $docCount }}</td>
                            <td>
                                {!! link_to_route('categories.edit', 'Edit', [$category->id], ['class' => 'btn btn-primary']); !!}
                            </td>
                            <td>
                                {!! Form::open(['data-remote', 'method' => 'DELETE', 'action' => ['CategoriesController@destroy', $category->id]]) !!}
                                    <div class="form-group">

                                        {!! Form::submit('Delete', ['class' => 'btn btn-danger', $docCount ? 'disabled' : 'enabled']) !!}
                                    </div>
                                {!! Form::close(); !!}
                            </td>
                        </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection