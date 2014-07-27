<?php
/*
 * Copyright 2014, Karen Tsai (angelXwind). <angelXwind@angelxwind.net>
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without modification,
 * are permitted provided that the following conditions are met:
 * 
 *   Redistributions of source code must retain the above copyright notice, this
 *   list of conditions and the following disclaimer.
 * 
 *   Redistributions in binary form must reproduce the above copyright notice, this
 *   list of conditions and the following disclaimer in the documentation and/or
 *   other materials provided with the distribution.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR
 * ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON
 * ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

$firstRun = 1;
if (php_sapi_name() == "cli") {
	$dispNewline = "\n";
} else {
	$dispNewline = "<br>";
}

function cryptPass($unenc_username, $unenc_password) {
	$encrypted = $unenc_username . ":" . crypt($unenc_password, base64_encode($unenc_password));
	return $encrypted;
}

function cryptPassToFile($filename, $username, $password) {
	global $firstRun;
	global $dispNewline;
	if ($firstRun == 1) {
		if (file_exists($filename . ".htpasswd")) {
			unlink($filename . ".htpasswd");
		}
		if (file_exists($filename . ".plain")) {
			unlink($filename . ".plain");
		}
		$firstRun = 0;
	}
	echo("Encrypting password for " . $username . " (" . $filename . ") ..." . $dispNewline);
	file_put_contents($filename . ".htpasswd", cryptPass($username, $password) . "\n", FILE_APPEND);
	file_put_contents($filename . ".plain", $username . ":" . $password . "\n", FILE_APPEND);
}

cryptPassToFile("example", "username", "password");
cryptPassToFile("example", "username2", "password2");
?>
