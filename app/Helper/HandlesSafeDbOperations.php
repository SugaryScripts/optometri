<?php

namespace App\Helper;

use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\DB;

trait HandlesSafeDbOperations {
    protected function safeDbOperation(
        callable $operation,
        ?string $customErrorMessage = null,
        ?string $type = null): bool {

        try {
            DB::transaction($operation);
            return true;
        } catch (\Exception $e) {
            // Since Form classes don't have direct access to the component,
            // we need to emit an event that the parent component can handle
            $this->component->dispatch('swal:alert', data: [
                'icon' => 'error',
                'title' => 'Gagal!',
                'text' => $customErrorMessage
            ]);
            Debugbar::critical($e);
            return false;
        }
    }
    // TODO: redundant function
    protected function safeDbOperationNotifiable(callable $operation, ?string $customErrorMessage = null): bool {
        try {
            DB::transaction($operation);
            return true;
        } catch (\Exception $e) {
            $this->component->dispatch('handle-error', [
                'error' => $e,
                'message' => $customErrorMessage,
                'type' => 'swal'
            ]);
            return false;
        }
    }
}
