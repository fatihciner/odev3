{{ Form::open() }}
LoginID: {{ Form::text(FieldType::EMAIL, 'demo@bumin.com.tr') }}  <br/>
Password: {{ Form::password(FieldType::PASSWORD) }}  <br/>
{{ Form::submit() }}
{{ Form::close() }}

form ile ilgili:
http://laravel-recipes.com/categories/21
http://laravel-recipes.com/recipes/171/creating-a-submit-button
<br> email: demo@bumin.com.tr | sifrE: cjaiU8CV
<hr>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


