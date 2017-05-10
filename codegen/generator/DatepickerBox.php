<?php
/**
 *
 * Part of the QCubed PHP framework.
 *
 * @license MIT
 *
 */

namespace QCubed\Generator;

use QCubed\Codegen\ColumnInterface;
use QCubed\Codegen\DatabaseCodeGen;
use QCubed\Codegen\SqlTable;

class DatepickerBox extends TextBox
{
    public function __construct($strControlClassName = 'DatepickerBox')
    {
        parent::__construct($strControlClassName);
    }


    /**
     * @param string $strPropName
     * @return string
     */
    public function varName($strPropName)
    {
        return 'cal' . $strPropName;
    }

    public function connectorImports(DatabaseCodeGen $objCodeGen, SqlTable $objTable, ColumnInterface $objColumn)
    {
        $a = parent::connectorImports($objCodeGen, $objTable, $objColumn);
        $a[] = ['class' => 'QCubed\\Control\\DatepickerBox'];
        return $a;
    }

    /**
     * Returns code to refresh the control from the saved object.
     *
     * @param DatabaseCodeGen $objCodeGen
     * @param SqlTable $objTable
     * @param ColumnInterface $objColumn
     * @param bool $blnInit
     * @return string
     */
    public function connectorRefresh(DatabaseCodeGen $objCodeGen, SqlTable $objTable, ColumnInterface $objColumn, $blnInit = false)
    {
        $strObjectName = $objCodeGen->modelVariableName($objTable->Name);
        $strPropName = $objColumn->Reference ? $objColumn->Reference->PropertyName : $objColumn->PropertyName;
        $strControlVarName = $this->varName($strPropName);

        if ($blnInit) {
            $strRet = "\t\t\t\$this->{$strControlVarName}->DateTime = \$this->{$strObjectName}->{$strPropName};";
        } else {
            $strRet = "\t\t\tif (\$this->{$strControlVarName}) \$this->{$strControlVarName}->DateTime = \$this->{$strObjectName}->{$strPropName};";
        }
        return $strRet . "\n";
    }

    /**
     * @param DatabaseCodeGen $objCodeGen
     * @param SqlTable $objTable
     * @param ColumnInterface $objColumn
     * @return string
     */
    public function connectorUpdate(DatabaseCodeGen $objCodeGen, SqlTable $objTable, ColumnInterface $objColumn)
    {
        $strObjectName = $objCodeGen->modelVariableName($objTable->Name);
        $strPropName = $objColumn->Reference ? $objColumn->Reference->PropertyName : $objColumn->PropertyName;
        $strControlVarName = $this->varName($strPropName);
        $strRet = <<<TMPL
				if (\$this->{$strControlVarName}) \$this->{$strObjectName}->{$objColumn->PropertyName} = \$this->{$strControlVarName}->DateTime;

TMPL;
        return $strRet;
    }
}
