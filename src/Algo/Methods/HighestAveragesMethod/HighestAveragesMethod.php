<?php
/*
    Part of Highest Averages Methods module - From the original Condorcet PHP

    Condorcet PHP - Election manager and results calculator.
    Designed for the Condorcet method. Integrating a large number of algorithms extending Condorcet. Expandable for all types of voting systems.

    By Julien Boudry and contributors - MIT LICENSE (Please read LICENSE.txt)
    https://github.com/julien-boudry/Condorcet
*/
declare(strict_types=1);

namespace CondorcetPHP\Condorcet\Algo\Methods\HighestAveragesMethod;

use CondorcetPHP\Condorcet\Algo\{Method, MethodInterface, StatsVerbosity};

# Copeland is a proportional algorithm | https://en.wikipedia.org/wiki/Webster/Sainte-Lagu%C3%AB_method
abstract class HighestAveragesMethod extends Method implements MethodInterface
{
    // Method Name
    public const METHOD_NAME = ['SainteLague'];

    protected array $candidatesVotes = [];
    protected array $candidatesSeats = [];
    protected array $rounds = [];


/////////// COMPUTE ///////////

    protected function compute (): void
    {
        $this->countVotesPerCandidates();

        foreach (\array_keys($this->getElection()->getCandidatesList()) as $candidateKey) :
            $this->candidatesSeats[$candidateKey] = 0;
        endforeach;

        # Rounds
        $this->rounds = [];
        $this->_Result = $this->createResult( $this->makeRounds() );
    }

    protected function countVotesPerCandidates (): void
    {
        $election = $this->getElection();

        foreach (\array_keys($election->getCandidatesList()) as $candidateKey) :
            $this->candidatesVotes[$candidateKey] = 0;
        endforeach;

        foreach ($election->getVotesValidUnderConstraintGenerator() as $oneVote) :
            $voteWinnerRank = $oneVote->getContextualRankingWithoutSort($election)[1];

            if (\count($voteWinnerRank) !== 1): continue; endif; // This method support only one winner per vote. Ignore bad votes.

            $this->candidatesVotes[$election->getCandidateKey(\reset($voteWinnerRank))] += $oneVote->getWeight($election);
        endforeach;
    }

    protected function makeRounds (): array
    {
        $election = $this->getElection();
        $results = [];

        while (\array_sum($this->candidatesSeats) < $election->getNumberOfSeats()) :
            $roundNumber = \count($this->rounds) + 1;
            $maxQuotient = 0;
            $maxQuotientCandidateKey = null;

            foreach ($this->candidatesVotes as $candidateKey => $oneCandidateVotes) :
                $quotient = $this->computeQuotient($oneCandidateVotes, $this->candidatesSeats[$candidateKey]);

                $this->rounds[$roundNumber][$candidateKey]['Quotient'] = $quotient;
                $this->rounds[$roundNumber][$candidateKey]['NumberOfSeatsAllocatedBeforeRound'] = $this->candidatesSeats[$candidateKey];

                if ($quotient > $maxQuotient) :
                    $maxQuotient = $quotient;
                    $maxQuotientCandidateKey = $candidateKey;
                endif;
            endforeach;

            $this->candidatesSeats[$maxQuotientCandidateKey]++;
            $results[$roundNumber] = $maxQuotientCandidateKey;
        endwhile;

        return $results;
    }

    abstract protected function computeQuotient (int $votes, int $seats): float;

    protected function getStats(): array
    {
        $election = $this->getElection();

        $stats = [];

        if ($election->getStatsVerbosity()->value > StatsVerbosity::NONE->value) :
            foreach ($this->rounds as $roundNumber => $oneRound) :
                foreach ($oneRound as $candidateKey => $roundCandidateStats) :
                    $stats['Rounds'][$roundNumber][$election->getCandidateObjectFromKey($candidateKey)->getName()] = $roundCandidateStats;
                endforeach;
            endforeach;

            foreach ($this->candidatesSeats as $candidateKey => $candidateSeats) :
                $stats['Seats per Candidates'][$election->getCandidateObjectFromKey($candidateKey)->getName()] = $candidateSeats;
            endforeach;
        endif;

        return $stats;
    }

}
