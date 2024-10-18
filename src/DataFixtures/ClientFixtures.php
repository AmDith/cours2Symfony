<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Dette;
use App\Entity\Client;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ClientFixtures extends Fixture
{
    private $encoder;
    public function __construct(UserPasswordHasherInterface $encoder){
        //Injection de dépendance sur le constructeur

        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        //ObjectManager est une class d'implémentation


        // $product = new Product();
        // $manager->persist($product);
        for ($i = 1; $i <=  9; $i++) {

            $client = new Client();
            $client->setSurname('Nom ' . $i);
            $client->setTelephone('77777777' . $i);
            $client->setAdresse('Adresse ' . $i);
            if ($i % 2  == 0) {
                //Création d'un utilisateur et association avec le client
                $user =new  User();
                $user->setNom('Nom' . $i);
                $user->setPrenom('Prenom' . $i);
                $user->setLogin('Login' . $i);
                $plaintextPassword = "password";

                // hash the password (based on the security.yaml config for the $user class)
                $hashedPassword = $this->encoder->hashPassword(
                    $user,//doit implémenté cette interface PasswordAuthenticatedUserInterface
                    $plaintextPassword
                );
                $user->setPassword($hashedPassword);
                $client->setUserId($user);
                //Création de dettes dans client
                for ($j = 1; $j <= 10; $j++) {
                    $dette = new Dette();
                    $dette->setMontant(1000 * $j);
                    $dette->setMontantVerser(1000 * $j);
                    $client->addDette($dette);
                }
            }
            else {
                for ($j = 1; $j <= 10; $j++) {
                    $dette = new Dette();
                    $dette->setMontant(1000 * $j);
                    $dette->setMontantVerser(1000);
                    $client->addDette($dette);
                }
            }
            $manager->persist($client);
        }

        $manager->flush();
    }
}
