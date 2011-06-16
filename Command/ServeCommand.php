namespace JDD\ServerBundle\Command

use Symfony\Bundle\FrameworkBundle\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ServeCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('server:serve')
            ->setDescription('Run a local webserver (only intended for development!)')
            ->addOption('port', 'p', InputArgument::OPTIONAL, 'The port to run the server on', 8080);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $port = $input->getArgument('port');
        $output->writeln($port);
    }
}
            
            
