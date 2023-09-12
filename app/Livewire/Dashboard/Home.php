<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Reactive;
use App\Services\Payment\ListTransactions as ListTransactionsService;
use App\DTO\TransactionListDTO;

class Home extends Component
{
    #[Reactive]
    #[Title('Dashboard')]
    public $transactions = null;
    public $perPage = 10;
    public $search  = '';
    public $balance = 0;

    public function mount()
    {
        $this->loadTransactions();
        $this->balance = $this->currencyFormat(auth()->user()->balance);
    }

    /**
     * Reload Data if any search input
     * @return void
     */
    public function updatedSearch()
    {
        $this->loadTransactions();
    }

    /**
     * @return void
     */
    public function loadTransactions()
    {
        $listTransaction = new ListTransactionsService();
        $result = $listTransaction->getList(
            new TransactionListDTO(
                $this->perPage,
                $this->search
            )
        );

        if ($result['status']) {
            $this->transactions = $result['data'];
        } else {
            $this->addError('search', $result['message']);
        }
    }

    private function currencyFormat($value)
    {
        return number_format($value, 2, ',', '.');
    }

    public function render()
    {
        return view('livewire.dashboard.home');
    }
}
