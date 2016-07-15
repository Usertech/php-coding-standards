<?php

namespace Usertech\Sniffs\Whitespace;

class NoNewlineBeforeClassOpenBraceSniff implements \PHP_CodeSniffer_Sniff {

	public function register() {
		return array(T_CLASS);
	}

	public function process(\PHP_CodeSniffer_File $phpcsFile, $stackPtr) {
		$tokens = $phpcsFile->getTokens();
		$token = $tokens[$stackPtr];

		if ($token['scope_opener']) {
			$braceToken = $tokens[$token['scope_opener']];
			if ($token['line'] !== $braceToken['line']) {
				$error = "Open brace for classes must be on same line as class.";
				$phpcsFile->addError($error, $stackPtr);
			}
		}
	}
}
