Set WshShell = CreateObject("WScript.Shell")
WshShell.Run chr(34) & "C:\apps\boarder\crons\sync_data.bat" & Chr(34), 0
Set WshShell = Nothing
