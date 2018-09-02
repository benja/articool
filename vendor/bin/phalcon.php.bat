@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../phalcon/devtools/phalcon.php
php "%BIN_TARGET%" %*
