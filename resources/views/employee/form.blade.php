<div class="form-group">
    <label for="firstname">Firtname</label>
    <input type="text" name="firstname" value="{{ old('firstname') ?? $employee->firstname }}" class="form-control">
    <div>{{ $errors->first('firstname') }}</div>
</div>

<div class="form-group">
    <label for="lastname">Lastname</label>
    <input type="text" name="lastname" value="{{ old('lastname') ?? $employee->lastname }}" class="form-control">
    <div>{{ $errors->first('lastname') }}</div>
</div>

<div class="form-group">
    <label for="email">Email Address</label>
    <input type="email" name="email" value="{{ old('email') ?? $employee->email }}" class="form-control">
    <div>{{ $errors->first('email') }}</div>
</div>

<div class="form-group">
    <label for="company_id">Company</label>
    <select name="company_id" id="company_id" class="form-control">
        <option disabled>Select company</option>
        @foreach($companies as $company)
            <option value="{{ $company->id }}" {{ $company->id == $employee->company_id ? 'selected' : '' }}>{{ $company->name }}</option>
        @endforeach
    </select>
    <div>{{ $errors->first('company_id') }}</div>
</div>

<div class="form-group">
    <label for="password">Password</label>
    <input type="password" name="password" value="{{ old('password') ?? $employee->password }}" class="form-control">
    <div>{{ $errors->first('password') }}</div>
</div>

<div class="form-group">
    <label for="phone">Phone number</label>
    <input type="number" name="phone" value="{{ old('phone') ?? $employee->phone }}" class="form-control">
    <div>{{ $errors->first('phone') }}</div>
</div>

@csrf