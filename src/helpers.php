<?php

if (!function_exists('dat')) {
    /**
     * Send debug information to the Dat debugging application
     *
     * @param mixed ...$arguments
     * @return \Dat\Dat
     */
    function dat(...$arguments): \Dat\Dat
    {
        $dat = \Dat\Dat::getInstance();
        
        if (empty($arguments)) {
            return $dat;
        }

        return $dat->send(...$arguments);
    }
}

if (!function_exists('datd')) {
    /**
     * Send debug information to Dat and die
     *
     * @param mixed ...$arguments
     * @return void
     */
    function datd(...$arguments): void
    {
        dat(...$arguments);
        exit(1);
    }
}

if (!function_exists('dat_if')) {
    /**
     * Send debug information to Dat conditionally
     *
     * @param bool $condition
     * @param mixed ...$arguments
     * @return \Dat\Dat
     */
    function dat_if(bool $condition, ...$arguments): \Dat\Dat
    {
        if ($condition) {
            return dat(...$arguments);
        }

        return \Dat\Dat::getInstance();
    }
}

if (!function_exists('dat_once')) {
    /**
     * Send debug information to Dat only once per execution
     *
     * @param mixed ...$arguments
     * @return \Dat\Dat
     */
    function dat_once(...$arguments): \Dat\Dat
    {
        static $called = false;
        
        if (!$called) {
            $called = true;
            return dat(...$arguments);
        }

        return \Dat\Dat::getInstance();
    }
}

if (!function_exists('dat_trace')) {
    /**
     * Send a stack trace to Dat
     *
     * @param int $limit
     * @return \Dat\Dat
     */
    function dat_trace(int $limit = 0): \Dat\Dat
    {
        $trace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, $limit);
        return dat($trace);
    }
}

if (!function_exists('dat_caller')) {
    /**
     * Send information about the caller to Dat
     *
     * @return \Dat\Dat
     */
    function dat_caller(): \Dat\Dat
    {
        $trace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 2);
        $caller = $trace[1] ?? [];
        
        $info = [
            'file' => $caller['file'] ?? 'unknown',
            'line' => $caller['line'] ?? 'unknown',
            'function' => $caller['function'] ?? 'unknown',
            'class' => $caller['class'] ?? null,
        ];

        return dat($info);
    }
}