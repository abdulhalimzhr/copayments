<div>
  <div class="p-5">
    <h1>Your balance : {{ $balance }}</h1>
  </div>
  <div class="p-4 bg-white dark:bg-gray-900 flex">
    <label for="table-search" class="sr-only">Search</label>
    <div class="relative mt-1">
      <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
        </svg>
      </div>
      <input type="text" wire:loading.attr="disabled" wire:model.live="search" id="table-search" class="table__search-input" placeholder="Search...">
    </div>
    <div wire:loading wire:target="search" class="my-auto p-3">
      <i class="fas fa-spinner fa-spin"></i>
    </div>
  </div>
  @if ($transactions !== null)
  <table class="table">
    <thead class="table__thead">
      <tr>
        <th scope="col" class="px-6 py-3">
          No
        </th>
        <th scope="col" class="px-6 py-3">
          Date
        </th>
        <th scope="col" class="px-6 py-3">
          Order Id
        </th>
        <th scope="col" class="px-6 py-3">
          Amount
        </th>
        <th scope="col" class="px-6 py-3">
          Type
        </th>
        <th scope="col" class="px-6 py-3">
          Status
        </th>
        <th scope="col" class="px-6 py-3">
          Description
        </th>
      </tr>
    </thead>
    <tbody>
      @foreach ($transactions as $item => $value)
      <tr class="border-b dark:border-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600" wire:key="$value->id">
        <td class="px-6 py-4">{{ $item + 1 }}</td>
        <td class="px-6 py-4">{{ $this->dateFormat($value->created_at) }}</td>
        <td class="px-6 py-4">{{ $value->order_id }}</td>
        <td class="px-6 py-4">{{ $this->currencyFormat($value->amount) }}</td>
        <td class="px-6 py-4">{{ $value->type > 1 ? 'Withdraw' : 'Deposit' }}</td>
        <td class="
          px-6 py-4
          @if ($value['status'])
          !text-green-500
          @else
          !text-red-500
          @endif
        ">{{ $value['status'] ? 'Success' : 'Failed' }}</td>
        <td class="px-6 py-4">{{ $value->description }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
  {{ $transactions->links() }}
  @else
  <div class="px-6 py-4">
    @if ($search !== '')
    No results found for query "{{ $search }}"
    @else
    No transactions found
    @endif
  </div>
  @endif
</div>