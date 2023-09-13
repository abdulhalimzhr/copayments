<div>
  <div class="p-5 max-w-sm">
    <div class="mb-5">
      <h1 class="text-2xl font-semibold">Withdraw</h1>
    </div>
    @if (session()->has('wds'))
    <div class="alert alert--success">
      {{ session('wds') }}
    </div>
    @elseif (session()->has('wde'))
    <div class="alert alert--danger">
      {{ session('wde') }}
    </div>
    @endif
    <form wire:submit.prevent="withdraw">
      <div class="flex flex-col">
        <label for="withdraw" class="mb-3">Amount: </label>
        <input type="text" id="withdraw" wire:model.live="amount" class="table__search-input" placeholder="e.g 50000.12" required>
      </div>
      <div class="flex flex-col">
        <button type="submit" class="btn-primary">
          Withdraw
          <span wire:loading wire:target="withdraw" class="ml-3">
            <i class="fas fa-spinner fa-spin"></i>
          </span>
        </button>
      </div>
    </form>
  </div>
</div>