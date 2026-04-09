<?php

declare(strict_types=1);

namespace App\Livewire\Base;

use App\Traits\Livewire\HasBulkActions;
use App\Traits\Livewire\HasConfirmDelete;
use App\Traits\Livewire\HasFilters;
use App\Traits\Livewire\HasSorting;
use App\Traits\Livewire\HasToast;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

abstract class BaseDataTable extends Component
{
    use HasBulkActions;
    use HasConfirmDelete;
    use HasFilters;
    use HasSorting;
    use HasToast;

    abstract protected function getQuery(): Builder;

    public function getRowsProperty(): LengthAwarePaginator
    {
        $query = $this->getQuery();
        $query = $this->applyFilters($query);
        $query = $this->applySorting($query);

        return $query->paginate($this->perPage);
    }

    protected function performDelete(string $id): void
    {
        $this->getQuery()->getModel()::findOrFail($id)->delete();
        $this->dispatchSuccess('Record deleted successfully.');
    }

    public function render(): mixed
    {
        return view($this->getView(), [
            'rows' => $this->rows,
        ]);
    }

    abstract protected function getView(): string;
}
