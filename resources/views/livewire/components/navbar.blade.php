<nav class="navbar">
  <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4" x-data="{ openMobileMenu: false }">
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
          <button type="button" :class="darkMode ? 'bg-indigo-500' : 'bg-gray-200'" x-on:click="darkMode = !darkMode" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2" role="switch" aria-checked="false">
            <span class="sr-only">Dark mode toggle</span>
            <span :class="darkMode ? 'translate-x-5 bg-gray-700' : 'translate-x-0 bg-white'" class="pointer-events-none relative inline-block h-5 w-5 transform rounded-full shadow ring-0 transition duration-200 ease-in-out">
              <span :class="darkMode ? 'opacity-0 ease-out duration-100' : 'opacity-100 ease-in duration-200'" class="absolute inset-0 flex h-full w-full items-center justify-center transition-opacity" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                  <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
                </svg>
              </span>
              <span :class="darkMode ?  'opacity-100 ease-in duration-200' : 'opacity-0 ease-out duration-100'" class="absolute inset-0 flex h-full w-full items-center justify-center transition-opacity" aria-hidden="true">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-white" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd" />
                </svg>
              </span>
            </span>
          </button>
    </div>
    </li>
    </ul>
    @else
    <ul class="navbar__links">
      <li>
        <a href="/login" wire:navigate @if( $page=='Login' ) aria-current="page" class="navbar__link-item navbar__link-item--active" @else class="navbar__link-item" @endif>Login</a>
      </li>
    </ul>
    @endif
  </div>
  </div>
</nav>