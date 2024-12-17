<section>
    <header>
        <h2>{{ __('Update Password') }}</h2>
        <p>{{ __('Ensure your account is using a long, random password to stay secure.') }}</p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-4">
        @csrf
        @method('put')

        <div class="form-group">
            <label for="current_password">{{ __('Current Password') }}</label>
            <input type="password" id="current_password" name="current_password" class="form-control" required>
            @error('current_password')<span class="text-danger">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label for="password">{{ __('New Password') }}</label>
            <input type="password" id="password" name="password" class="form-control" required>
            @error('password')<span class="text-danger">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation">{{ __('Confirm Password') }}</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
            @error('password_confirmation')<span class="text-danger">{{ $message }}</span>@enderror
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
        </div>
    </form>
</section>
