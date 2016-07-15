<?php

namespace Usertech\Sniffs\Whitespace;

class NewlinesAroundUseSniff implements \PHP_CodeSniffer_Sniff {

	public function register() {
		return array(T_USE);
	}

	public function process(\PHP_CodeSniffer_File $phpcsFile, $stackPtr) {
		$tokens = $phpcsFile->getTokens();
		$token = $tokens[$stackPtr];
		if ($token['column'] !== 1) {
			return; // function() use () {}
		}
		if ($phpcsFile->findPrevious(T_USE, $stackPtr - 1) === false) {
			// first use in file
			$prev = $tokens[$stackPtr - 1];
			if ($prev['code'] !== T_WHITESPACE || $prev['content'] !== "\n" || $prev['column'] !== 1) {
				$error = "Use must be preceded with an empty line.";
				$phpcsFile->addError($error, $stackPtr, 'Before');
			}
		}

		$nextUsePtr = $phpcsFile->findNext(T_USE, $stackPtr + 1);
		if ($nextUsePtr === false || $tokens[$nextUsePtr]['column'] !== 1) {
			// last use in file
			$nextPtr = $phpcsFile->findNext(T_SEMICOLON, $stackPtr + 1);
			$next = $tokens[$nextPtr + 2];
			if ($next['code'] !== T_WHITESPACE || $next['content'] !== "\n" || $next['column'] !== 1) {
				$error = "Use must be followed with an empty line.";
				$phpcsFile->addError($error, $stackPtr, 'After');
			}
		}
	}
}
