REM 6.4.3 Final
REM D:\wamp\bin\php\php7.1.16\php.exe D:\wamp\bin\phpunit\phpunit-6.4.3.phar --coverage-html D:\wamp\www\formDin\phpunit-code-coverage D:\wamp\www\formDin\base\testsPHPUnit\ph

ECHO 7.2.4 Coverage
REN D:\wamp\bin\php\php7.2.14\php.exe D:\wamp\bin\phpunit\phpunit-7.2.4.phar --whitelist D:\wamp\www\formDin\sysgen --coverage-html D:\wamp\www\formDin\phpunit-code-coverage D:\wamp\www\formDin\sysgen\tests\

ECHO 7.2.4 Config XML and Coverage
REN D:\wamp\bin\php\php7.2.14\php.exe D:\wamp\bin\phpunit\phpunit-7.2.4.phar --configuration D:\wamp\www\formDin\sysgen\tests\phpunit-conf.xml --coverage-html D:\wamp\www\formDin\phpunit-code-coverage D:\wamp\www\formDin\sysgen\tests\

ECHO 7.2.4 Config XML file
D:\wamp\bin\php\php7.2.14\php.exe D:\wamp\bin\phpunit\phpunit-7.2.4.phar --configuration D:\wamp\www\formDin\sysgen\tests\phpunit-conf.xml D:\wamp\www\formDin\sysgen\tests\

