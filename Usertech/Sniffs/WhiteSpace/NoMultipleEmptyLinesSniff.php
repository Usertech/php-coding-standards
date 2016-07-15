<?php

namespace Usertech\Sniffs\Whitespace;

class NoMultipleEmptyLinesSniff implements \PHP_CodeSniffer_Sniff {

	public function register() {
		return array(T_WHITESPACE);
	}

	public function process(\PHP_CodeSniffer_File $phpcsFile, $stackPtr) {
		$tokens = $phpcsFile->getTokens();
		$token = $tokens[$stackPtr];
		if ($token['content'] !== "\n" || $token['column'] !== 1) {
			return; // not an empty line
		}
		if ($stackPtr < $phpcsFile->numTokens) {
			$next = $tokens[$stackPtr + 1];
			if ($next['code'] === T_WHITESPACE && $next['content'] === "\n") {
				$error = "File must not contain multiple empty lines in a row.";
				$phpcsFile->addError($error, $stackPtr);
			}
		}
	}
}
