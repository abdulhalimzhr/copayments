<nav class="navbar">
  <div class="navbar__wrapper" x-data="{ openMobileMenu: false }">
    <a href="/" wire:navigate class="flex items-center">
      <span class="navbar__logo-text">{{ env('APP_NAME') }}</span>
    </a>
    <button data-collapse-toggle="navbar-default" type="button" class="navbar__btn-nav" aria-controls="navbar-default" aria-expanded="openMobileMenu" @click="openMobileMenu = !openMobileMenu">
      <span class="sr-only">Open main menu</span>
      <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15" />
      </svg>
    </button>
    <div :class="{ 'hidden' : !openMobileMenu }" class="w-full md:block md:w-auto" id="navbar-default">
      @if (auth()->check())
      <ul class="navbar__links">
        <li>
          <a href="/dashboard" wire:navigate @if( $page=='Dashboard' ) aria-current="page" class="navbar__link-item navbar__link-item--active" @else class="navbar__link-item" @endif>Dashboard</a>
        </li>
        <li>
          <a href="/deposit" wire:navigate @if( $page=='Deposit' ) aria-current="page" class="navbar__link-item navbar__link-item--active" @else class="navbar__link-item" @endif>Deposit</a>
        </li>
        <li>
          <a href="/withdraw" wire:navigate @if( $page=='Withdraw' ) aria-current="page" class="navbar__link-item navbar__link-item--active" @else class="navbar__link-item" @endif>Withdraw</a>
        </li>
        <li>
          <a href="/logout" wire:navigate class="navbar__link-item">Logout</a>
        </li>
        <li>
          <button type="button" :class="darkMode ? 'bg-indigo-500' : 'bg-gray-200'" x-on:click="darkMode = !darkMode" class="btn__toggle-switch" role="switch" aria-checked="false">
            <span class="sr-only">Dark mode toggle</span>
            <span :class="darkMode ? 'translate-x-5 bg-gray-700' : 'translate-x-0 bg-white'" class="pointer-events-none relative inline-block h-5 w-5 transform rounded-full shadow ring-0 transition duration-200 ease-in-out">
              <span :class="darkMode ? 'opacity-0 ease-out duration-100' : 'opacity-100 ease-in duration-200'" class="absolute inset-0 flex h-full w-full items-center justify-center transition-opacity" aria-hidden="true">
                <i class="fa-solid fa-moon"></i>
              </span>
              <span :class="darkMode ?  'opacity-100 ease-in duration-200' : 'opacity-0 ease-out duration-100'" class="absolute inset-0 flex h-full w-full items-center justify-center transition-opacity" aria-hidden="true">
                <i class="fa-solid fa-sun"></i>
              </span>
            </span>
          </button>
        </li>
      </ul>
    </div>
    @else
    <ul class="navbar__links">
      <li>
        <a href="/login" wire:navigate @if( $page=='Login' ) aria-current="page" class="navbar__link-item navbar__link-item--active" @else class="navbar__link-item" @endif>Login</a>
      </li>
    </ul>
    @endif
  </div>
</nav>