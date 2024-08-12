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

if (!function_exists('flasher_message')) {
    /**
     * Flasher dynamic type message.
     *
     * @param  string  $message
     * @param  string  $type
     * @return void
     */
    function flasher_message(string $message, string $type): void
    {
        flash()->addFlash($type, $message, $type === 'success' ? 'Sukses' : 'Gagal', [
            'timeout' => 3000, 'position' => 'top-right'
        ]);
    }
}

if (!function_exists('flasher_success')) {
    /**
     * Flasher success message.
     *
     * @param  string  $message
     * @return void
     */
    function flasher_success(string $message): void
    {
        flash()->addFlash('success', $message, 'Sukses', [
            'timeout' => 3000, 'position' => 'top-right'
        ]);
    }
}

if (!function_exists('flasher_fail')) {

    /**
     * Flasher error message.
     *
     * @param  string  $message
     * @return void
     */
    function flasher_fail(string $message): void
    {
        flash()->addFlash('error', $message, 'Gagal', [
            'timeout' => 3000, 'position' => 'top-right'
        ]);
    }
}
