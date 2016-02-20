<?php
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

namespace Xmf;

if (!defined('XMF_KRUMO_URL')) {
    define('XMF_KRUMO_URL', XOOPS_URL . '/include/krumo/');
}

/**
 * Debugging tools for developers
 *
 * @category  Xmf\Debug
 * @package   Xmf
 * @author    trabis <lusopoemas@gmail.com>
 * @author    Richard Griffith <richard@geekwright.com>
 * @copyright 2011-2016 XOOPS Project (http://xoops.org)
 * @license   GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @version   Release: 1.0
 * @link      http://xoops.org
 * @since     1.0
 */
class Debug
{
    /**
     * Dump one or more variables
     *
     * @param mixed $var variable(s) to dump
     *
     * @return void
     */
    public static function dump($var)
    {
        $args = func_get_args();

        $config = array(
            'skin' => array('selected' => 'modern'),
            'css' => array('url' => XOOPS_URL . '/include/krumo/'),
            'display' => array(
                'show_version' => false,
                'show_call_info' => false,
                'sort_arrays' => false,
            ),
        );
        \Krumo::setConfig($config);
        foreach ($args as $var) {
            $msg = \Krumo::dump($var);
            echo $msg;
        }
    }

    /**
     * Display debug backtrace
     *
     * @return void
     */
    public static function backtrace()
    {
        static::dump(debug_backtrace());
    }

    /**
     * start_trace - turn on xdebug trace
     *
     * Requires xdebug extension
     *
     * @param string $tracefile      file name for trace file
     * @param string $collect_params argument for ini_set('xdebug.collect_params',?)
     *                             Controls display of parameters in trace output
     * @param string $collect_return argument for ini_set('xdebug.collect_return',?)
     *                             Controls display of function return value in trace
     *
     * @return void
     */
    public static function startTrace($tracefile = '', $collect_params = '3', $collect_return = 'On')
    {
        if (function_exists('xdebug_start_trace')) {
            ini_set('xdebug.collect_params', $collect_params);
            ini_set('xdebug.collect_return', $collect_return);
            if ($tracefile == '') {
                $tracefile = XOOPS_VAR_PATH . '/logs/php_trace';
            }
            xdebug_start_trace($tracefile);
        }
    }

    /**
     * stop_trace - turn off xdebug trace
     *
     * Requires xdebug extension
     *
     * @return void
     */
    public static function stopTrace()
    {
        if (function_exists('xdebug_stop_trace')) {
            xdebug_stop_trace();
        }
    }
}
