@Echo off
title BTCsql.py
Pushd "%~dp0"
:loop
python BTCsql.py
goto loop