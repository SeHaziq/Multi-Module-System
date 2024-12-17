<section>
    <header>
        <h2>{{ __('Delete Account') }}</h2>
        <p>{{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}</p>
    </header>

    <form method="post" action="{{ route('profile.destroy') }}">
        @csrf
        @method('delete')

        <div class="form-group">
            <label for="password">{{ __('Password') }}</label>
            <input type="password" name="password" id="password" class="form-control" placeholder="{{ __('Enter your password') }}">
            @error('password')<span class="text-danger">{{ $message }}</span>@enderror
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-danger">{{ __('Delete Account') }}</button>
            <a href="#" class="btn btn-secondary" onclick="event.preventDefault(); window.history.back();">{{ __('Cancel') }}</a>
        </div>
    </form>
</section>
