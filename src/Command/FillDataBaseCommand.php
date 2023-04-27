<?php

namespace App\Command;

use App\Entity\Pokemon;
use App\Service\CallPokeApi;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;


#[AsCommand(
    name: 'dev:filldb',
    description: 'Pour remplir la base de données avec des pokémons',
)]
class FillDataBaseCommand extends Command
{
    public $entityManager;
    private $callPokemon;

    public function __construct(CallPokeApi $callPokeApi, EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->callPokemon = $callPokeApi;
        $this->callGen = $callPokeApi;
        $this->entityManager = $entityManager;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Ajouter un argument')
            ->addOption('alert', 'a', InputOption::VALUE_NONE, 'Option description');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $em = $this->entityManager;
        $io = new SymfonyStyle($input, $output);
//        $arg1 = $input->getArgument('arg1');

        $pokemonRepo = $em->getRepository(Pokemon::class);
//        $pokemon = $pokemonRepo->find(1);


        $pokemonSpecies = $this->callGen->getGen(1)['pokemon_species'];
        $progressBar = new ProgressBar($output, count($pokemonSpecies));
        $output->writeln('Début du chargement...');
        $progressBar->start();

        foreach ($pokemonSpecies as $pokemonData) {
            $result = $this->callPokemon->getPokemonByUrl($pokemonData['url']);
            $pokemonId = $result['id'];

            if (!$pokemon = $pokemonRepo->findOneByPokedexId($pokemonId)) {
                $pokemon = new Pokemon();
            }

            $pokemonName = $result['name'];
            $pokemonColor = $result['color']['name'];
            $pokemonShape = $result['shape']['name'];

            $pokemonLegend = $result['is_legendary'];
            if (!$pokemonLegend) {
                $pokemonLegend = "Non";
            } else {
                $pokemonLegend = "Oui";
            }


            $pokemon->setName($pokemonName);
            $pokemon->setColor($pokemonColor);
            $pokemon->setShape($pokemonShape);
            $pokemon->setLegendary($pokemonLegend);
            $pokemon->setPokedexId($pokemonId);

            $em->persist($pokemon);
            $progressBar->advance();
        }

        $progressBar->finish();
        $em->flush();
        $io->success('You have fill your database with Pokemon.');

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
