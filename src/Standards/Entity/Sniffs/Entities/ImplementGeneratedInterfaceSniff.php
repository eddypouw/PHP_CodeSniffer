<?php

/**
 * Interfaces are automatically generated for entities. This code sniffer checks whether all the
 * entities implement their generated interface.
 *
 * @author Eddy Pouw <epouw@hostnet.nl>
 */
class Entity_Sniffs_Entities_ImplementGeneratedInterfaceSniff implements \PHP_CodeSniffer_Sniff
{

    /**
     * @see PHP_CodeSniffer_Sniff::register()
     */
    public function register()
    {
        return array(T_CLASS);
    }

    /**
     * @see PHP_CodeSniffer_Sniff::process()
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $class                = $phpcsFile->getDeclarationName($stackPtr);
        $namespace_pointer    = $phpcsFile->findPrevious([T_NAMESPACE], $stackPtr);
        $implements_interface = $phpcsFile->findNext([T_IMPLEMENTS], $stackPtr);
        $paths                = $this->getFullQualifiedPath($phpcsFile, $namespace_pointer);

      //  Check if there are any interfaces implemented
        if (!$implements_interface) {
            $error = 'Implemented class returns "FALSE"; at least the generated interface should have been returned.';
            $phpcsFile->addError($error, $stackPtr, 'ImplementGeneratedInterface', $implements_interface);
            return;
        }

        $interface_name        = $phpcsFile->findNext(T_STRING, $implements_interface);
        $stackPtr              = $interface_name;
        $generated_implemented = FALSE;
        $more_implementations  = TRUE;

        // Go through every interface that is implemented and compare with the expected path
        // While loop will stop when a Curly Bracket is opened or when the end of the file is reached
        while($interface_name !== FALSE && $more_implementations) {

            $new_content               = $phpcsFile->getTokensAsString($interface_name, 1);
            $looping                   = TRUE;
            $content                   = "";
            $last_content              = "";
            $use_statement_declaration = "Namespace";

            // Merge the different strings of the interfaces to one string
            while ($looping) {
                $content          = $content . $new_content;
                $interface_name   = $phpcsFile->findNext([T_STRING, T_COMMA, T_NS_SEPARATOR, T_CURLY_OPEN, T_WHITESPACE], $interface_name+1);
                if (($phpcsFile->getTokens()[$interface_name]['code']) === T_STRING || ($phpcsFile->getTokens()[$interface_name]['code']) === T_NS_SEPARATOR) {
                    $last_content = $new_content;
                    $new_content  = $phpcsFile->getTokensAsString($interface_name, 1);
                    if ($phpcsFile->getTokens()[$interface_name]['code'] === T_NS_SEPARATOR) {
                        $use_statement_declaration = $content;
                    }
                }else{
                    $looping = FALSE;
                }
            }

            // Check if the interface uses one of the use statements
            if (array_key_exists($use_statement_declaration, $paths)) {
                $declaration_string = $phpcsFile->getTokensAsString($interface_name, 1);
                $interface_path     = $paths[$use_statement_declaration] . "\\" . $new_content;
            }else{
                $interface_path     = $paths['Namespace'] . "\\" . $content;
            }
                $class_path         = $paths['Namespace'] . "\\Generated\\" . $class . 'Interface';

            // Compare the interface path with the expected, generated interface path
            // Return if the expected path is the same as the current path
            if (!substr_compare($interface_path, $class_path, 0)) {
                return;
            }

            $stackPtr       = $interface_name;
            $interface_name = $phpcsFile->findNext(T_STRING, $stackPtr+1);
        }

        $error = 'None of the implemented interfaces in the class is the generated class. Make sure you use the generated interface too.';
        $phpcsFile->addError($error, $stackPtr, 'ImplementGeneratedInterface');
    }

    /**
     *
     * @param PHP_CodeSniffer_File $phpcsFile Code sniffer file
     * @param number $namespace_pointer Indicates where the namespace is in the token stack
     * @return array An array that contains both the namespace and all the use statements
     */
    private function getFullQualifiedPath (PHP_CodeSniffer_File $phpcsFile, $namespace_pointer = 0)
    {
        // Get the namespace if it's not false
        $tokens  = $phpcsFile->getTokens();
        $looping = TRUE;
        if ($namespace_pointer !== FALSE) {
            $new_content = "";$phpcsFile->getTokensAsString($phpcsFile->findNext([T_STRING, T_NS_SEPARATOR], $namespace_pointer), 1);
            $namespace   = "";

            // Merge strings and NS Separators to one string, forming the full path
            while ($looping) {
                $namespace         = $namespace . $new_content;
                $namespace_pointer = $phpcsFile->findNext([T_STRING, T_SEMICOLON, T_NS_SEPARATOR], $namespace_pointer+1);
                if ($tokens[$namespace_pointer]['code'] === T_STRING || $tokens[$namespace_pointer]['code'] === T_NS_SEPARATOR) {
                    $new_content = $phpcsFile->getTokensAsString($namespace_pointer, 1);
                }else{
                    $looping = FALSE;
                }
            }
        }
        $return_array              = $this->retrieveUseStatements($phpcsFile);
        $return_array['Namespace'] = $namespace;
        return $return_array;
    }

    /**
     *
     * @param PHP_CodeSniffer_File $phpcsFile Code sniffer file
     * @return array containing all use statements before the class definition
     */
    private function retrieveUseStatements (PHP_CodeSniffer_File $phpcsFile)
    {
        $stack_pointer     = 0;
        $use_statements    = [];
        $statement_pointer = [];

        // Find the pointers to where the use statements start
        while($stack_pointer !== FALSE) {
            $stack_pointer = $phpcsFile->findNext([T_USE, T_CLASS], $stack_pointer+1);
            if($phpcsFile->getTokens()[$stack_pointer]['code'] === T_CLASS) {
                $stack_pointer = FALSE;
            }else{
                array_push($statement_pointer, $stack_pointer);
            }
        }

        // Get the full paths of the use statements
        foreach ($statement_pointer as $stack_pointer) {
            $tokens        = $phpcsFile->getTokens();
            $looping       = TRUE;
            $ignore_string = FALSE;
            $statement     = "";
            $new_content   = "";

            // Merge all strings and NS Separators to one string, which represents the full path
            // Stop merging when a semicolon is found
            while ($looping) {
                if(!$ignore_string){
                    $statement    = $statement . $new_content;
                }
                $stack_pointer = $phpcsFile->findNext([T_STRING, T_SEMICOLON, T_NS_SEPARATOR, T_AS], $stack_pointer+1);
                $index         = $new_content;
                $new_content   = $phpcsFile->getTokensAsString($stack_pointer, 1);

                if ($tokens[$stack_pointer]['code'] === T_AS) {
                    $index = $phpcsFile->findNext(T_STRING, $stack_pointer);
                    $ignore_string = TRUE;
                }elseif ($tokens[$stack_pointer]['code'] === T_SEMICOLON){
                    $use_statements[$index] = $statement;
                    $looping = FALSE;
                }
            }
        }
        return $use_statements;
    }
}