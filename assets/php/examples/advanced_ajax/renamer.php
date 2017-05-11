<?php
require_once('../qcubed.inc.php');

class SelectableLabel extends \QCubed\Control\Label {
	// For Simplicity -- We made this a public member variable
	// In the future, you might want to make it protected, and make public get/set accessors
	public $Selected;

}

class ExampleForm extends \QCubed\Project\Control\FormBase {

	protected $lblArray;
	protected $txtArray;

	protected function formCreate() {
		for ($intIndex = 0; $intIndex < 10; $intIndex++) {
			// Create the Label
			$this->lblArray[$intIndex] = new SelectableLabel($this);
			$this->lblArray[$intIndex]->Text = 'This is a Test for Item #' . ($intIndex + 1);
			$this->lblArray[$intIndex]->CssClass = 'renamer_item';
			$this->lblArray[$intIndex]->ActionParameter = $intIndex;
			$this->lblArray[$intIndex]->AddAction(new \QCubed\Event\Click(), new \QCubed\Action\Ajax('lblArray_Click'));

			// Create the Textbox (hidden)
			$this->txtArray[$intIndex] = new \QCubed\Project\Control\TextBox($this);
			$this->txtArray[$intIndex]->Visible = false;
			$this->txtArray[$intIndex]->ActionParameter = $intIndex;

			// Create Actions to Save Textbox on Blur or on "Enter" Key
			$this->txtArray[$intIndex]->AddAction(new \QCubed\Event\Blur(), new \QCubed\Action\Ajax('TextItem_Save'));
			$this->txtArray[$intIndex]->AddAction(new \QCubed\Event\EnterKey(), new \QCubed\Action\Ajax('TextItem_Save'));
			$this->txtArray[$intIndex]->AddAction(new \QCubed\Event\EnterKey(), new \QCubed\Action\Terminate());

			// Create Action to CANCEL/Revert Textbox on "Escape" Key
			$this->txtArray[$intIndex]->AddAction(new \QCubed\Event\EscapeKey(), new \QCubed\Action\Ajax('TextItem_Cancel'));
			$this->txtArray[$intIndex]->AddAction(new \QCubed\Event\EscapeKey(), new \QCubed\Action\Terminate());
		}
	}

	protected function lblArray_Click($strFormId, $strControlId, $strParameter) {
		// Is the Label being clicked already selected?
		if ($this->lblArray[$strParameter]->Selected) {
			// It's already selected -- go ahead and replace it with the textbox
			$this->lblArray[$strParameter]->Visible = false;
			$this->txtArray[$strParameter]->Visible = true;
			$this->txtArray[$strParameter]->Text = html_entity_decode($this->lblArray[$strParameter]->Text, ENT_COMPAT, \QCubed\Project\Application::encodingType());
			\QCubed\Project\Application::ExecuteControlCommand($this->txtArray[$strParameter]->ControlId, 'select');
			\QCubed\Project\Application::ExecuteControlCommand($this->txtArray[$strParameter]->ControlId, 'focus');
		} else {
			// Nope -- not yet selected
			// First, unselect everything else
			for ($intIndex = 0; $intIndex < 10; $intIndex++)
				if ($this->lblArray[$intIndex]->Selected) {
					$this->lblArray[$intIndex]->Selected = false;
					$this->lblArray[$intIndex]->CssClass = 'renamer_item';
				}

			// Now, make this item selected
			$this->lblArray[$strParameter]->Selected = true;
			$this->lblArray[$strParameter]->CssClass = 'renamer_item renamer_item_selected';
		}
	}

	protected function TextItem_Save($strFormId, $strControlId, $strParameter) {
		$strValue = trim($this->txtArray[$strParameter]->Text);

		if (strlen($strValue)) {
			// Copy the Textbox value back to the Label
			$this->lblArray[$strParameter]->Text = $strValue;
		}

		// Hide the Textbox, get the label cleaned up and ready to go
		$this->lblArray[$strParameter]->Visible = true;
		$this->txtArray[$strParameter]->Visible = false;
		$this->lblArray[$strParameter]->Selected = false;
		$this->lblArray[$strParameter]->CssClass = 'renamer_item';
	}

	protected function TextItem_Cancel($strFormId, $strControlId, $strParameter) {
		// Hide the Textbox, get the label cleaned up and ready to go
		$this->lblArray[$strParameter]->Visible = true;
		$this->txtArray[$strParameter]->Visible = false;
		$this->lblArray[$strParameter]->Selected = false;
		$this->lblArray[$strParameter]->CssClass = 'renamer_item';
	}

}

ExampleForm::Run('ExampleForm');
?>