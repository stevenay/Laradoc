<div class="form-group">
    {!! Form::label('category_name', 'Category Name') !!}
    {!! Form::text('category_name', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {!! Form::submit($submitButtonText, ['class' => 'form-control btn btn-primary']) !!}
</div>