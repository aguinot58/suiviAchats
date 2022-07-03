<?php

    namespace App\Command;

    use Symfony\Component\Console\Command\Command;
    use Symfony\Component\Console\Input\InputArgument;
    use Symfony\Component\Console\Input\InputInterface;
    use Symfony\Component\Console\Output\OutputInterface;
    use Doctrine\ORM\EntityManagerInterface;
    use Symfony\Component\Mime\Email;
    use \PDO;
    use Symfony\Component\Config\FileLocator;

    use Symfony\Component\Mailer\Mailer;
    use Symfony\Component\Mailer\MailerInterface;

    use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport;
    use Symfony\Component\Mailer\Transport\TransportInterface;

    

    class CronMail extends Command
    {

        private $em;
        private $mailer;
        private $trspSMTP;

        public function __construct($conn, EntityManagerInterface $em, MailerInterface $mailer, TransportInterface $trspSMTP)
        {
            $this->conn = $conn;
            $this->em = $em;
            $this->mailer = $mailer;
            $this->trspSMTP = $trspSMTP;
            parent::__construct();
        }

        protected function configure (): void 
        {
            // On set le nom de la commande
            $this->setName('app:cronMails');

            // On set la description
            $this->setDescription("Permet d'envoyer automatiquement un e-mail lorsque qu'une date de garantie touche à sa fin");

            // On set l'aide
            $this->setHelp("Je serai affichée si on lance la commande app/console app:cronMails -h");

            // On prépare les arguments
            //$this->addArgument('name', InputArgument::REQUIRED, "Quel est ton prenom ?")
            //     ->addArgument('last_name', InputArgument::OPTIONAL, "Quel est ton nom ?");
        }

        /***
         * 
         * @return int
         */
        public function execute(InputInterface $input, OutputInterface $output): int
        {
            //$today = date('Y-m-d');
            $today = "2024-06-21";
            //$output->writeln($today);

            $sql = "SELECT a.id_achat, a.date_achat, a.date_gar_achat, p.id_prod, p.nom_prod, p.infos_prod, u.id_user, u.nom_user, u.prenom_user, u.mail_user from Achats a JOIN Produits p ON a.id_prod = p.id_prod JOIN Utilisateurs u ON a.id_user = u.id_user WHERE a.date_gar_achat = '$today'";
            //$output->writeln($sql);

            /*$lien_local = "../../";
            $lien_prod = "../../../../";*/

            $configDirectories = [__DIR__];
            $fileLocator = new FileLocator($configDirectories);
            $iniFiles = $fileLocator->locate('achats.ini', null, true);

            //$output->writeln($iniFiles);

            /*if ($filesystem->exists('/public/config/achats.ini')){*/

                //$output->writeln("test");

                $base = "locale";
                $inifile = parse_ini_file($iniFiles,true);
                $servername = $inifile['Base_locale']['servername'];
                $username = $inifile['Base_locale']['username'];
                $password = $inifile['Base_locale']['password'];
                $db = $inifile['Base_locale']['database'];
            /*} else {
                $base = "prod";
                $inifile = parse_ini_file('../../../../config/achats.ini',true);
                $servername = $inifile['Base_prod']['servername'];
                $username = $inifile['Base_prod']['username'];
                $password = $inifile['Base_prod']['password'];
                $db = $inifile['Base_prod']['database'];
            }*/

            $conn = new PDO("mysql:host=$servername;dbname=$db;charset=UTF8", $username, $password);
            //On définit le mode d'erreur de PDO sur Exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sth = $conn->prepare($sql);
            $sth->execute();
            //Retourne un tableau associatif pour chaque entrée de notre table avec le nom des colonnes sélectionnées en clefs
            $datas = $sth->fetchAll(PDO::FETCH_ASSOC);

            foreach ($datas as $data) {

                //var_dump($datas);

                if ($data['id_achat'] != null) {

                    mail($data['mail_user'], 'Alerte produit en fin de garantie', 'test envoi mail');
                    return 0;
     
                }

            }

            return 0;

        }

    }