<section class="section">
  <div class="container-login">
    <a href="#" class="logo-text">
      {{ env('APP_NAME') }}
    </a>
    <div class="card">
      <div class="card__inner">
        <h1 class="card__header">
          Sign in to your account
        </h1>
        <div>
          @if (session()->has('error'))
          <div class="alert alert--danger">
            {{ session('error') }}
          </div>
          @endif
        </div>
        <form class="login-form" wire:submit.prevent="login">
          <div>
            <label for="email" class="login-form__label">Your email</label>
            <input type="email" wire:model="email" id="email" class="login-form__input" placeholder="name@company.com" required="">
            @error('email') <span class="form__error-message">{{ $message }}</span> @enderror
          </div>
          <div>
            <label for="password" class="login-form__label">Password</label>
            <input type="password" wire:model="password" id="password" placeholder="••••••••" class="login-form__input" required="">
            @error('password') <span class="form__error-message">{{ $message }}</span> @enderror
          </div>
          <button type="submit" class="btn-full-primary">
            Sign in
            <span class="loader" wire:loading wire:target="login">
              <i class="fas fa-spinner fa-spin"></i>
            </span>
          </button>
        </form>
      </div>
    </div>
  </div>
</section>