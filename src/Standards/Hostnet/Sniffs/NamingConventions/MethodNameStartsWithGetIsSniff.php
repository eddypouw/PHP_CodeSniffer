<?php

class Hostnet_Sniffs_NamingConventions_MethodNameStartsWithGetIsSniff implements PHP_CodeSniffer_Sniff
{
    public function register()
    {
        // TODO: Auto-generated method stub
        return array(
            T_FUNCTION
        );
    }
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        // search till T_STRING
        $index = 0;
        while (isset($phpcsFile->getTokens()[$stackPtr + (++ $index)]) && $phpcsFile->getTokens()[$stackPtr + ($index)]['type'] !== 'T_STRING');

        $ptr = $stackPtr + $index;

        $f_name = $phpcsFile->getTokens()[$ptr]['content'];
        if (preg_match('~^getIS~', $f_name)) {
            return;
        }

        if (preg_match('~^get([Ii]s[A-Z0-9]{1}.*)~', $f_name, $matches)) {
            $suggested = 'i' . substr($matches[0], 4);
            $phpcsFile->addError('Invalid method name to get Boolean value. Suggested: ' . $suggested, $ptr);
            return;
        }

        if (preg_match('~^getis[a-zA-Z0-9]*~', $f_name)) {
            $phpcsFile->addError('Invalid method name, do not use getis(.*)', $ptr);
            return;
        }
    }
}
