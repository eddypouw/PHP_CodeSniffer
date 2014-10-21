<?php

/**
 *
 * @author Eddy Pouw <epouw@hostnet.nl>
 */
class Entity_Entities_ImplementGeneratedInterfaceUnitTest extends AbstractSniffUnitTest
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
        if($filename === "ImplementGeneratedInterfaceUnitTest.3.inc") {
            return [10 => 1];
        }elseif($filename === "ImplementGeneratedInterfaceUnitTest.2.inc") {
            return [4 => 1];
        }else{
            return [];
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

    }//end getWarningList()


}//end class


