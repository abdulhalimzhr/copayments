<div>
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
          Amount
        </th>
        <th scope="col" class="px-6 py-3">
          Type
        </th>
        <th scope="col" class="px-6 py-3">
          Status
        </th>
      </tr>
    </thead>
    <tbody>
      @foreach ($transactions as $post => $value)
      <tr class="
        border-b
        @if ($value->type == 1) 
            bg-green-100
        @else
            bg-red-100
        @endif>
        dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
        <td class="px-6 py-4">{{ $value->id }}</td>
        <td class="px-6 py-4">{{ $value->created_at }}</td>
        <td class="px-6 py-4">{{ $value->amount }}</td>
        <td class="px-6 py-4">{{ $value->type }}</td>
        <td class="px-6 py-4">{{ $value->status }}</td>
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