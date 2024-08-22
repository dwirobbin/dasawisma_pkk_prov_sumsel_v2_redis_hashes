<?php

if (!function_exists('flash_message')) {

    /**
     * Flash message.
     *
     * @param  string  $message
     * @param  string  $type
     * @return void
     */
    function flash_message(string $message, string $type): void
    {
        session()->flash('message', ['text' => $message, 'type' => $type === 'success' ? 'success' : 'danger']);
    }
}

if (!function_exists('toastr_message')) {
    /**
     * Flasher dynamic type message.
     *
     * @param  string  $message
     * @param  string  $type
     * @return void
     */
    function toastr_message(string $message, string $type): void
    {
        toastr($message, $type, $type === 'success' ? 'Sukses' : 'Gagal', [
            'timeout' => 3000,
            'position' => 'top-right'
        ]);
    }
}

if (!function_exists('toastr_success')) {
    /**
     * Flasher success message.
     *
     * @param  string  $message
     * @return void
     */
    function toastr_success(string $message): void
    {
        toastr($message, 'success', 'Sukses', [
            'timeout' => 3000,
            'position' => 'top-right'
        ]);
    }
}

if (!function_exists('toastr_error')) {

    /**
     * Flasher error message.
     *
     * @param  string  $message
     * @return void
     */
    function toastr_error(string $message): void
    {
        toastr($message, 'error', 'Gagal', [
            'timeout' => 3000,
            'position' => 'top-right'
        ]);
    }
}
