<?php

namespace App\Helper;

use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

trait HandleComponentError {
    use WithSweetAlert;

    /**
     * Error notification types
     */
    protected function getErrorTypeSession(): string {
        return 'session';
    }

    protected function getErrorTypeSwal(): string {
        return 'swal';
    }

    /**
     * Handle and log errors that occur during component operations
     *
     * @param Exception $e The exception that occurred
     * @param array $options Error handling options
     * @return void
     */
    protected function handleComponentError(Exception $e, string $message = '', array $options = []) {
        // Default options
        $defaultOptions = [
            'type' => $this->getErrorTypeSession(), // Default to session flash
            'level' => 'error', // error, warning, info
            'swalOptions' => [], // Additional SweetAlert options
        ];
        $options = array_merge($defaultOptions, $options);

        // Rollback transaction if it's a database-related error
        $this->rollBack();

        // Log the error with context
        $this->logError($e);

        // Determine the appropriate error message
        $errorMessage = $this->determineErrorMessage($e, $message);

        // Notify based on the specified type
        $this->notifyError($errorMessage, $options);
    }


    /**
     * Notify error through different channels
     *
     * @param string $message Error message
     * @param array $options Notification options
     * @return void
     */
    protected function notifyError(string $message, array $options) {
        switch ($options['type']) {
            case $this->getErrorTypeSwal():
                // Merge any additional SweetAlert options
                $swalOptions = array_merge([
                    'title' => 'Error',
                    'icon' => 'error',
                    'message' => $message,
                    // Add more default SweetAlert options here
                ], $options['swalOptions']);

                $this->alert($swalOptions);
                break;

            case $this->getErrorTypeSession():
            default:
                // Use standard Laravel session flash
                session()->flash('error', $message);
                break;
        }
    }


    /**
     * Run a database operation with advanced error handling
     *
     * @param callable $operation The operation to perform
     * @param array $options Error handling options
     * @return mixed
     */
    protected function safeDbOperation(callable $operation, array $options = []) {
        try {
            return DB::transaction($operation);
        } catch (Exception $e) {
            $this->handleComponentError($e, $options);
            return false;
        }
    }


    /**
     * Log the error with additional context
     *
     * @param Exception $e The exception to log
     * @return void
     */
    protected function logError(Exception $e) {
        // TODO: Log signal debug and release
        // Prepare context information
        $context = [
            'component' => get_class($this),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString(),
        ];

        // Log the error
        Log::error('Livewire Component Error: ' . $e->getMessage(), $context);
    }



    /**
     * Determine the appropriate error message
     *
     * @param Exception $e The exception
     * @param string|null $customErrorMessage Optional custom error message
     * @return string
     */
    protected function determineErrorMessage(Exception $e, ?string $customErrorMessage = null): string {
        // If a custom error message is provided, use it
        if ($customErrorMessage) {
            return $customErrorMessage;
        }

        // Handle specific types of exceptions
        if ($e instanceof QueryException) {
            // Handle database-specific errors
            switch ($e->getCode()) {
                case '23000':
                    return 'Data duplikat atau pelanggaran batasan unik terdeteksi.';
                case '42S02':
                    return 'Tabel atau kolom basis data tidak ditemukan.';
                default:
                    return 'Terjadi kesalahan basis data. Silakan hubungi administrator.';
            }
        }

        // For other exceptions, provide a generic error message
        return 'Terjadi kesalahan tidak terduga. Silakan hubungi administrator.';
    }



    /**
     * Rollback transaction if possible
     *
     * @return void
     */
    protected function rollBack() {
        try {
            if (DB::transactionLevel() > 0) {
                DB::rollBack();
            }
        } catch (Exception $rollbackException) {
            Log::error('Rollback Error: ' . $rollbackException->getMessage());
        }
    }
}
