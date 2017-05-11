<?php

require_once('../qcubed.inc.php');

class ExampleService extends QSoapService {

    /**
     * Adds two numbers together, and returns the result
     *
     * @param int $intNumber1
     * @param int $intNumber2
     * @return int
     */
    public function AddNumbers($intNumber1, $intNumber2) {
        return $intNumber1 + $intNumber2;
    }

    /**
     * Returns the Date as a \QCubed\QDateTime.
     * Note that the QSoapService handler will automatically convert to a valid
     * SOAP dateTime.
     * 
     * @param int $intMonth
     * @param int $intDay
     * @param int $intYear
     * @return \QCubed\QDateTime
     */
    public function GetDate($intMonth, $intDay, $intYear) {
        $dttToReturn = new \QCubed\QDateTime($intYear . '-' . $intMonth . '-' . $intDay);
        return $dttToReturn;
    }

    /**
     * Gets all the Person objects with a certain last name as an array
     * 
     * @param string $strLastName
     * @return Person[]
     */
    public function GetPeople($strLastName) {
        return Person::QueryArray(
                        \QCubed\Query\QQ::Equal(QQN::Person()->LastName, $strLastName)
        );
    }

}

// We need to RUN the WebService (just like how we run a \QCubed\Project\Control\FormBase)
ExampleService::Run('ExampleService', 'http://examples.qcu.be');

