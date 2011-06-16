<?php
namespace JDD\ServerBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ServeCommand extends Command
{
    protected function configure()
    {
        $this->setName('server:serve')
            ->setDescription('Run a local webserver (only intended for development!)');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $root_dir = $this->container->get('kernel')->getRootDir();
        $assumed_host_dir = realpath($root_dir.'/../web');

        $conf = <<<EOF
Listen 8080
LoadModule dir_module modules/mod_dir.so
LoadModule php5_module modules/libphp5.so
LockFile "/tmp/JDDServerBundle.lock"
PidFile "/tmp/JDDServerBundle.pid"

DocumentRoot "$assumed_host_dir"
<Directory />
 Options all
 AllowOverride all
</Directory>

DirectoryIndex app_dev.php index.php index.html
<FilesMatch "\.php$">
SetHandler application/x-httpd-php
</FilesMatch>

<FilesMatch "\.phps$">
SetHandler application/x-httpd-php-source
</FilesMatch>

ErrorLog "/tmp/JDDServerBundle-error_log"


EOF;
        $confPath = '/tmp/JDDServerBundle.conf';
        $fh = fopen($confPath, 'w');
        fwrite($fh, $conf);
        fclose($fh);

        $httpd = '/usr/sbin/httpd';
        $output->writeln('Serving on port 8080...');
        exec("$httpd -f $confPath -k start");

    }
}
