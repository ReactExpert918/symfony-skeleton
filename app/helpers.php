<?php
//===========================================================================

if (!function_exists('pa')) {
    function pa ($value, $stop = false)
    {
        if (!isset($GLOBALS['_pa_output'])) $GLOBALS['_pa_output'] = '';
        $_debug = debug_backtrace();
        $debug = array_shift($_debug);
        $msg = '<pre>';
        $msg .= basename($debug['file']).':'.$debug['line'].' => ';
        $msg .= htmlspecialchars(print_r($value, 1)).'</pre>';
        $GLOBALS['_pa_output'] .= $msg;
        if ($stop)
        {
            if (!headers_sent())
            {
                header('Content-type: text/html; Charset=utf-8');
            }
            echo $GLOBALS['_pa_output'];
            exit;
        }
        else
        {
            //if (__CFG_SCRIPT_STATUS == 'debug')
            //write_debug_info('Print', $GLOBALS['_pa_output']);
        }

        return true;
    }
}

//===========================================================================

if (!function_exists('ff')) {

    function ff($v, $pref = '') {
        try {
            ob_start();
            var_dump($v);
            $output = ob_get_clean();

            $i = 0;
            do {
                $pathFile = 'ff/' . $pref . '_dump-' . $i . '.txt';
                $i++;
            } while (Storage::exists($pathFile));

            Storage::put($pathFile, $output);

        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
