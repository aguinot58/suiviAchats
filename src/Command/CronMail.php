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
    use Symfony\Component\Mailer\MailerInterface;
    use Symfony\Component\Mailer\Transport\TransportInterface;

    
    class CronMail extends Command
    {

        private $em;
        private $mailer;
        private $transport;

        public function __construct($conn, EntityManagerInterface $em, MailerInterface $mailer, TransportInterface $transport)
        {
            $this->conn = $conn;
            $this->em = $em;
            $this->mailer = $mailer;
            $this->transport = $transport;
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
        }

        /***
         * 
         * @return int
         */
        public function execute(InputInterface $input, OutputInterface $output): int
        {

            $today = "2024-06-21";

            $sql = "SELECT a.id_achat, a.date_achat, a.date_gar_achat, p.id_prod, p.nom_prod, p.infos_prod, u.id_user, u.nom_user, u.prenom_user, u.mail_user from Achats a JOIN Produits p ON a.id_prod = p.id_prod JOIN Utilisateurs u ON a.id_user = u.id_user WHERE a.date_gar_achat = '$today'";

            $configDirectories = 'config\\';
            $fileLocator = new FileLocator($configDirectories);
            $iniFiles = $fileLocator->locate('achats.ini', null, true);

            if ($_SERVER['APP_ENV']=="dev"){
                $base = "locale";
                $inifile = parse_ini_file($iniFiles,true);
                $servername = $inifile['Base_locale']['servername'];
                $username = $inifile['Base_locale']['username'];
                $password = $inifile['Base_locale']['password'];
                $db = $inifile['Base_locale']['database'];
            } else {
                $base = "prod";
                $inifile = parse_ini_file($iniFiles,true);
                $servername = $inifile['Base_prod']['servername'];
                $username = $inifile['Base_prod']['username'];
                $password = $inifile['Base_prod']['password'];
                $db = $inifile['Base_prod']['database'];
            }

            $conn = new PDO("mysql:host=$servername;dbname=$db;charset=UTF8", $username, $password);
            //On définit le mode d'erreur de PDO sur Exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sth = $conn->prepare($sql);
            $sth->execute();
            //Retourne un tableau associatif pour chaque entrée de notre table avec le nom des colonnes sélectionnées en clefs
            $datas = $sth->fetchAll(PDO::FETCH_ASSOC);

            foreach ($datas as $data) {

                if ($data['id_achat'] != null) {

                    /*$email = (new Email())
                        ->from('aymeric.guinot@gmail.com')
                        ->to($data['mail_user'])
                        ->subject('Alerte produit en fin de garantie')
                        ->text('test envoi mail');

                    $transport = new EsmtpTransport();
                    $mailer = new Mailer($transport);
                    $mailer->send($email);*/

                    $to = $data['mail_user'];
                    $subject = "Alerte produit en fin de garantie";
                    $body = "Bonjour, le produit ".$data['nom_prod']." acheté le ".$data['date_achat']." arrive en fin de garantie aujourd'hui.";
                    $headers = "From: suivisAchats@localhost" . "\r\n";
                    mail($to,$subject,$body,$headers);

                    return 0;
     
                }

            }

            return 0;

        }

    }