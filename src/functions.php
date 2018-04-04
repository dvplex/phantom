<?php
if (! function_exists('bark')) {
    /**
     * Arrange for a flash message.
     *
     * @param  string|null $message
     * @param  string      $level
     * @return \\Flash\FlashNotifier
     */
    function bark()
    {
        $notifier = app('dog');
            return $notifier->bark();
        return $notifier;
    }
}