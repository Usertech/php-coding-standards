<?php

namespace Usertech\Sniffs\Whitespace;

class NoEmptyLinesBeforeClosingBracketSniff implements \PHP_CodeSniffer_Sniff {

	public function register() {
		return array(T_CLOSE_CURLY_BRACKET);
	}

	public function process(\PHP_CodeSniffer_File $phpcsFile, $stackPtr) {
		$tokens = $phpcsFile->getTokens();
		$prev = null;
		$ptr = $stackPtr;
		$line = $tokens[$stackPtr]['line'];
		do {
			$ptr--;
			$prev = $tokens[$ptr];
		} while ($line === $prev['line']);
		if ($prev['code'] === T_WHITESPACE && $prev['column'] === 1) {
			$error = "Closing curly bracket should not be preceded by an empty line.";
			$phpcsFile->addError($error, $stackPtr);
		}
	}
}
