Set WinScriptHost = CreateObject("WScript.Shell")
WinScriptHost.Run Chr(34) & "C:\laragon\www\suiviAchats\src\Script\Cron_Mails.bat" & Chr(34), 0
Set WinScriptHost = Nothing