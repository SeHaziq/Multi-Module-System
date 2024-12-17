<section>
    <header>
        <h2>{{ __('Profile Information') }}</h2>
        <p>{{ __("Update your account's profile information and email address.") }}</p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-4">
        @csrf
        @method('patch')

        <div class="form-group">
            <label for="name">{{ __('Name') }}</label>
            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="form-control" required autofocus>
            @error('name')<span class="text-danger">{{ $message }}</span>@enderror
        </div>

        <div class="form-group">
            <label for="email">{{ __('Email') }}</label>
            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
            @error('email')<span class="text-danger">{{ $message }}</span>@enderror
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
        </div>
    </form>
</section>
