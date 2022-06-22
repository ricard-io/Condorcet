<?php
declare(strict_types=1);

namespace CondorcetPHP\Condorcet\Tests\Algo\Methods\HighestAverage;

use CondorcetPHP\Condorcet\Election;
use PHPUnit\Framework\TestCase;

class JeffersonTest extends TestCase
{
    private readonly Election $election;

    public function setUp(): void
    {
        $this->election = new Election;
    }

    # https://fr.wikipedia.org/wiki/Scrutin_proportionnel_plurinominal#M%C3%A9thode_de_Jefferson_ou_m%C3%A9thode_D'Hondt
    public function testResult_1 (): void
    {
        $this->election->addCandidate('A');
        $this->election->addCandidate('B');
        $this->election->addCandidate('C');
        $this->election->addCandidate('D');

        $this->election->setNumberOfSeats(6);
        $this->election->allowsVoteWeight(true);

        $this->election->parseVotes('A * 42; B ^31; C *15; D ^12'); // Mix weight and number

        self::assertSame(['A' =>3, 'B' => 2, 'C' => 1, 'D' => 0], $this->election->getResult('Jefferson')->getStats()['Seats per Candidates']);
    }

}