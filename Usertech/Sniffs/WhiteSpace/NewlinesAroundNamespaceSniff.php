<?php

namespace Usertech\Sniffs\Whitespace;

class NewlinesAroundNamespaceSniff implements \PHP_CodeSniffer_Sniff {

	public function register() {
		return array(T_NAMESPACE);
	}

	public function process(\PHP_CodeSniffer_File $phpcsFile, $stackPtr) {
		$tokens = $phpcsFile->getTokens();
		$token = $tokens[$stackPtr];
		$prev = $tokens[$stackPtr - 1];
		if ($prev['code'] !== T_WHITESPACE || $prev['content'] !== "\n" || $prev['column'] !== 1) {
			$error = "Namespace must be preceded with an empty line.";
			$phpcsFile->addError($error, $stackPtr, 'Before');
		}
		$next = null;
		$ptr = $stackPtr;
		do {
			$ptr++;
			$next = $tokens[$ptr];
		} while ($next['line'] === $token['line']);
		if ($next['code'] !== T_WHITESPACE || $next['content'] !== "\n" || $next['column'] !== 1) {
			$error = "Namespace must be followed with an empty line.";
			$phpcsFile->addError($error, $stackPtr, 'After');
		}
	}
}
