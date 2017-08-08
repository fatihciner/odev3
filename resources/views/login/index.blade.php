{{ Form::open() }}
LoginID: {{ Form::text('id') }}  <br/>
Password: {{ Form::password('password') }}  <br/>
{{ Form::submit() }}
{{ Form::close() }}

form ile ilgili:
http://laravel-recipes.com/categories/21
http://laravel-recipes.com/recipes/171/creating-a-submit-button
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