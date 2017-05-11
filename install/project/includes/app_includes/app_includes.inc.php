<?php
/*
 * =============================================
 * PREPAIRING YOUR CUSTOM CLASSES FOR AUTOLOADING
 * =============================================
 * This file is run everytime the framework initializes
 * (i.e. on each page access or in anyfile where you include prepend.inc.php or qcubed.inc.php)
 *
 * This file is intended to allow you to create a classmap so the autoloader can get to your files.
 *
 * For example:
 * $a['plantypes'] = __APP_INCLUDES__ . '/classes/PlanTypes.class.php';
 * $a['planlayout'] = __APP_INCLUDES__ . '/controls/PlanLayout.class.php';
 *
 * Note that the format is:
 * $a['classname'] = __APP_INCLUDES__ .'/path/to/file_containing_the_class/FileName.class.php';
 *
 * The class you define in the '/path/to/file_containing_the_class/FileName.class.php' file can be in
 * any case but the same classname must be written in all lower case in the $a['classname']
 * as the key name to the array.
 *
 * -------
 * NOTE:
 * The directories 'classes' and 'controls' or any other directories must be created by you.
 * They do not come by default.
 * -------
 *
 * In case you want to run some custom code on each page access (such as counting number of hits etc),
 * you should create a new file for that and include it here. Do not put executable PHP code here directly.
 *
 * You may add the file as:
 *
 * require_once(__APP_INCLUDES__ . '/functions/blog_functions.inc.php');
 *
 */
$a['navpanel'] = __INCLUDES__ .'/app_includes/nav_panel.class.php';

return $a;