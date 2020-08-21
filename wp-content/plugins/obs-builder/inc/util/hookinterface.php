<?php
/**
 * @package Obspgb Builder
 */

/**
 * Interface OBSPGB_Util_HookInterface
 *
 * Classes that implement this interface will have their hook() method called automatically when they are added as
 * a module to a class that is an instance of OBSPGB_Util_Modules via the add_module() method.
 *
 * In addition to the two methods in this interface, a OBSPGB_Util_HookInterface class should have a static $hooked
 * boolean property that starts as false. The hook() method should check this property when it is called and only run
 * if the value is still false. Then it should change the value to true at its completion.
 *
 * The is_hooked() method should return the current boolean value of the $hooked property.
 *
 * @since 1.0.0.
 */
interface OBSPGB_Util_HookInterface {
	public function hook();

	public function is_hooked();
}