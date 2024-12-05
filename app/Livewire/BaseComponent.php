<?php

namespace App\Livewire;

use App\Helper\HandleComponentError;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class BaseComponent extends Component {
    use HandleComponentError;

    protected function safeDbOperation(callable $operation, ?string $customErrorMessage = null) {
        try {
            return DB::transaction($operation);
        } catch (\Exception $e) {
            $this->handleComponentError($e, $customErrorMessage);
            return false;
        }
    }
}
