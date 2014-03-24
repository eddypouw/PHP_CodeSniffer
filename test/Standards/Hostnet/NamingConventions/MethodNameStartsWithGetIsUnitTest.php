<?php

/**
 * Unit test for MethodNameStartsWithGetIs
 * @author Nico Schoenmaker <nschoenmaker@hostnet.nl>
 */
class Hostnet_NamingConventions_MethodNameStartsWithGetIsUnitTest extends AbstractSniffUnitTest
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
        return array(13 => 1, 17 => 1, 35 => 1, 39 => 1, 43 => 1, 49 => 1, 55 => 1, 59 => 1, 73 => 1, 78 => 1, 83 => 1);
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


