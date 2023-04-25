<?php

namespace App\Command;

use App\Entity\Pokemon;
use App\Entity\PokemonSpecie;
use App\Service\CallPokeApi;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;


#[AsCommand(
    name: 'dev:filldb',
    description: 'Pour remplir la base de données avec des pokémons',
)]
class FillDataBaseCommand extends Command
{
    private $callPokemon;
    public $entityManager;
    private int $pokeId = 1;

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Ajouter un argument')
            ->addOption('alert', 'a', InputOption::VALUE_NONE, 'Option description')
        ;
    }

    public function __construct(CallPokeApi $callPokeApi, EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->callPokemon = $callPokeApi;
        $this->callGen = $callPokeApi;
        $this->entityManager = $entityManager;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $em = $this->entityManager;
        $io = new SymfonyStyle($input, $output);
//        $arg1 = $input->getArgument('arg1');

        $pokemon=$em->getRepository(Pokemon::class)->find(1);

        if (!$pokemon) {

//                $genLength = $this->callGen->getGen(1);
//                $test = count($genLength['pokemon_species']);
//                $result = $this->callPokemon->getPokedexId($pokeId);
//            $io->success('entity is empty');
//            dd($this->callGen->getGen(1));
            foreach ($this->callGen->getGen(1)['pokemon_species'] as $pokemonData) {
                $result = $this->callPokemon->getPokemonByUrl($pokemonData['url']);
                dd($result['name']);
            }
            exit;

            for ($pokeId = 1; $pokeId <= $test; $pokeId++) {

                $result2 [] = [
                    'poke_name' => $result['names'][4]['name'],
                    'pokedex_id' => $result['id']
                    ];


                dump($test);
//                $em->persist($result);
//                $em->flush();

                $io->success('You have fill your database with Pokemon.');
            }
        }else {
        $io->error('Your database is already fill with Pokemon !');
        return Command::FAILURE;
        }

        return Command::SUCCESS;

//        if ($arg1) {
//            $io->note(sprintf('Vous avez passé un argument : %s', $arg1));
//        $io->success('You have fill your database with '.$arg1);
//        }
//
//
//        $alert = $input->getOption('alert');
//        if ($alert) {
//            $io->success('Coucou !');
//            exit;
//        }

    }
}
