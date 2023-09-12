<div>
    <div class="p-5 max-w-sm">
        <div class="mb-5">
            <h1 class="text-2xl font-semibold">Deposit</h1>
        </div>
        @if (session()->has('deposits'))
        <div class="alert alert--success">
            {{ session('deposits') }}
        </div>
        @elseif (session()->has('deposite'))
        <div class="alert alert--danger">
            {{ session('deposite') }}
        </div>
        @endif
        <form wire:submit.prevent="deposit">
            <div class="flex flex-col">
                <label for="deposit" class="mb-3">Amount: </label>
                <input type="text" id="deposit" wire:model.live="amount" class="table__search-input" placeholder="e.g 50000" required>
            </div>
            <div class="flex flex-col">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-5">
                    Deposit
                    <span wire:loading wire:target="deposit" class="ml-3">
                        <i class="fas fa-spinner fa-spin"></i>
                    </span>
                </button>
            </div>
        </form>
    </div>
</div>