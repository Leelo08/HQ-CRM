<div class="form-group">
    <label for="name">Company name</label>
    <input type="text" name="name" value="{{ old('name') ?? $company->name }}" class="form-control">
    <div>{{ $errors->first('name') }}</div>
</div>

<div class="form-group">
    <label for="email">Company email</label>
    <input type="email" name="email" value="{{ old('email') ?? $company->email }}" class="form-control">
    <div>{{ $errors->first('email') }}</div>
</div>

<div class="form-group d-flex flex-column">
    <label for="image">Company logo</label>
    <input type="file" name="image" class="py-1">
    <div>{{ $errors->first('image') }}</div>
</div>

<div class="form-group">
    <label for="website">Company website</label>
    <input type="text" name="website" value="{{ old('website') ?? $company->website }}" class="form-control">
    <div>{{ $errors->first('website') }}</div>
</div>

@csrf