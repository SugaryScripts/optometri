<?php

namespace App\Livewire;

use App\Helper\HandleComponentError;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class BaseComponent extends Component {
    use HandleComponentError;

    protected function safeDbOperation(callable $operation,
                                       ?string $customErrorMessage = null,
                                       ?string $type = null,
                                       ?string $title = null) {
        try {
            return DB::transaction($operation);
        } catch (\Exception $e) {
            $type = $type ?? 'swal';
            $this->handleComponentError($e, $customErrorMessage, [
                'type' => $type,
                'title' => $title ?? 'Error!',
                'text' => $e->getMessage()
            ]);
            return false;
        }
    }

    protected function safeDbOperationNotifiable(callable $operation, ?string $customErrorMessage = null) {
        try {
            return DB::transaction($operation);
        } catch (\Exception $e) {
            $this->handleComponentError($e, $customErrorMessage, [
                'type' => $this->getErrorTypeSwal()
            ]);
            return false;
        }
    }
}
