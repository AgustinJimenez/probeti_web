C:\laragon\bin\mysql\mariadb-10.1.19-win32\bin\mysqldump.exe --host=localhost --user=root --password= probeti  > C:\Users\User\Desktop\copia.sql
@Echo off
WMIC.EXE Alias /? >NUL 2>&1 || GOTO s_error
FOR /F "skip=1 tokens=1-6" %%G IN ('WMIC Path Win32_LocalTime Get Day^,Hour^,Minute^,Month^,Second^,Year /Format:table') DO (
   IF "%%~L"=="" goto s_done
      Set _yyyy=%%L
      Set _mm=00%%J
      Set _dd=00%%G
      Set _hour=00%%H
      SET _minute=00%%I
)
:s_done
:: Pad digits with leading zeros
      Set _mm=%_mm:~-2%
      Set _dd=%_dd:~-2%
      Set _hour=%_hour:~-2%
      Set _minute=%_minute:~-2%
C:
cd \
cd \Users\User\Desktop
set fecha=&quot;%date:~6,4%&quot;
set hora=%TIME:~,2%
set min=%TIME:~3,2%
set seg=%TIME:~6% 
ren copia.sql %_yyyy%-%_mm%-%_dd%-%_hour%%_minute%_copia.sql