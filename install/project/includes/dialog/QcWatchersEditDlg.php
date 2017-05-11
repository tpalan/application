<?php

use QCubed\Project\Control\FormBase;
use QCubed\Project\Control\ControlBase;

require(__DIALOG_GEN__ . '/QcWatchersEditDlgGen.php');

/**
 * This is the customizable subclass for the edit dialog. This dialog is just a shell for the
 * QcWatchersEditPanel class, and so you will not likely need to do major customizations here.
 * Generally speaking, you would only add things here that you want to display outside of the edit panel.
 *
 * This file is intended to be modified. Subsequent code regenerations will NOT modify
 * or overwrite this file.
 */
class QcWatchersEditDlg extends QcWatchersEditDlgGen
{

	/**
	 * @param FormBase|ControlBase $objParentObject
	 * @param null|string $strControlId
	 */
	public function __construct($objParent = null, $strControlId = null) {
		parent::__construct($objParent, $strControlId);

		/**
		 * Setting AutoRenderChildren will automatically draw the QcWatchersEditPanel panel that is
		 * a member of this class, and anything else you add. To customize how the dialog renders, create a template
		 * and set the Template property of the dialog.
		 **/

		$this->AutoRenderChildren = true;
	}
}
