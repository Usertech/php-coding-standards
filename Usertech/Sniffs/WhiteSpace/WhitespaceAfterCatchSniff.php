<?php

namespace Usertech\Sniffs\Whitespace;

class WhitespaceAfterCatchSniff implements \PHP_CodeSniffer_Sniff {

	public function register() {
		return array(T_CATCH);
	}

	public function process(\PHP_CodeSniffer_File $phpcsFile, $stackPtr) {
		$tokens = $phpcsFile->getTokens();
		$whitespace = $tokens[$stackPtr+1];
		$parenthesis = $tokens[$stackPtr+2];
		if ($whitespace["code"] !== T_WHITESPACE || $whitespace["content"] !== " " || $parenthesis["code"] !== T_OPEN_PARENTHESIS) {
			$error = "There must be a single whitespace after catch statement followed by an openning bracket, i.e. } catch (Exception ......";
			$phpcsFile->addError($error, $stackPtr);
		}
	}
}
