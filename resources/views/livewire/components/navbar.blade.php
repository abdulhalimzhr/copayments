<nav class="navbar">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        <a href="/" wire:navigate class="flex items-center">
            <span class="navbar__logo-text">{{ env('APP_NAME') }}</span>
        </a>
        <button data-collapse-toggle="navbar-default" type="button" class="navbar__btn-nav" aria-controls="navbar-default" aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15" />
            </svg>
        </button>
        <div class="hidden w-full md:block md:w-auto" id="navbar-default">
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