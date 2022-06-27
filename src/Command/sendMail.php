<?php

use App\Service\checkDate;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

    class sendMail extends Command
    {
        private $checkDate;
        protected static $defaultName = 'bot:mail';

        public function __construct( checkDate $checkDate ){

            parent::__construct();
            $this->checkDate = $checkDate;
        }    

        protected function configure()
        {

        }

        protected function execute(InputInterface $input, OutputInterface $output)
        {
            $content = $this->checkDate;
            return Command::SUCCESS;
        }
    }



?>
