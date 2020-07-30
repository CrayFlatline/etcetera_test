<?php
/**
 * File containing general constants
 *
 * @package RealtyManager
 */

namespace RealtyManager;

class Constants {

########################################################################
#
#  General Settings
#

	public static $searchItemsLimit = 5;
	public static $excerptWordsLimit = 15;

########################################################################
#
#  Form Fields Settings
#

	public static function formValuesTypes() {
		return array(
			'1' => __( 'Panel', 'rm' ),
			'2' => __( 'Brick', 'rm' ),
			'3' => __( 'Foam Block', 'rm' ),
		);
	}
	public static function formValuesFloors() {
		return array_combine(range(1,20),range(1,20));
	}

	public static function formValuesRooms() {
		return array_combine(range(1,10),range(1,10));
	}

	public static function formValuesEcologicalIndex() {
		return array_combine(range(1,5),range(1,5));
	}

}