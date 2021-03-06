<?php

class Hostnet_Classes_NoVerticalWhitespaceBetweenUseStatementsUnitTest extends AbstractSniffUnitTest
{
    /**
     * Returns the lines where errors should occur.
     *
     * The key of the array should represent the line number and the value
     * should represent the number of errors that should occur on that line.
     *
     * @return array(int => int)
     */
    public function getErrorList($filename = null)
    {
        switch($filename) {
            case 'NoVerticalWhitespaceBetweenUseStatementsUnitTest.0.inc' :
                return array(5 => 1, 12 => 1, 14 => 1, 18 => 1);
            case 'NoVerticalWhitespaceBetweenUseStatementsUnitTest.1.inc' :
                return array(5 => 1, 7 => 1);
            case 'NoVerticalWhitespaceBetweenUseStatementsUnitTest.2.inc' :
                return array(5 => 1);
        }


    }//end getErrorList()

    /**
     * Returns the lines where warnings should occur.
     *
     * The key of the array should represent the line number and the value
     * should represent the number of warnings that should occur on that line.
     *
     * @return array(int => int)
     */
    public function getWarningList()
    {
        return array();
    }
}
