<?php
/*
    Condorcet PHP - Election manager and results calculator.
    Designed for the Condorcet method. Integrating a large number of algorithms extending Condorcet. Expandable for all types of voting systems.

    By Julien Boudry and contributors - MIT LICENSE (Please read LICENSE.txt)
    https://github.com/julien-boudry/Condorcet
*/
declare(strict_types=1);

namespace CondorcetPHP\Condorcet\DataManager;

use CondorcetPHP\Condorcet\Dev\CondorcetDocumentationGenerator\CondorcetDocAttributes\{Description, Example, FunctionReturn, PublicAPI, Related, Throws};
use CondorcetPHP\Condorcet\{Election, Vote};
use CondorcetPHP\Condorcet\ElectionProcess\ElectionState;
use CondorcetPHP\Condorcet\Throwable\VoteManagerException;
use CondorcetPHP\Condorcet\Tools\Converters\CondorcetElectionFormat;

class VotesManager extends ArrayManager
{



/////////// Data CallBack for external drivers ///////////

    protected function decodeOneEntity (string $data): Vote
    {
        $vote = new Vote ($data);
        $vote->registerLink($this->getElection());
        $vote->notUpdate = true;
        $this->getElection()->checkVoteCandidate($vote);
        $vote->notUpdate = false;

        return $vote;
    }

    protected function encodeOneEntity (Vote $data): string
    {
        $data->destroyLink($this->getElection());

        return \str_replace([' > ',' = '],['>','='],(string) $data);
    }

    protected function preDeletedTask ($object): void
    {
        $object->destroyLink($this->getElection());
    }

/////////// Array Access - Specials improvements ///////////

    public function offsetGet(mixed $offset): Vote
    {
        return parent::offsetGet($offset);
    }

    #[Throws(VoteManagerException::class)]
    public function offsetSet(mixed $offset, mixed $value): void
    {
        if ($value instanceof Vote) :
            parent::offsetSet((is_int($offset) ? $offset : null),$value);
            $this->UpdateAndResetComputing(key: $this->_maxKey, type: 1);
        else :
            throw new VoteManagerException();
        endif;

        $this->checkRegularize();
    }

    public function offsetUnset(mixed $offset): void
    {
        $this->UpdateAndResetComputing(key: $offset, type: 2);
        parent::offsetUnset($offset);
    }

/////////// Internal Election related methods ///////////

    public function UpdateAndResetComputing (int $key, int $type): void
    {
        $election = $this->getElection();


        if ($election->getState() === ElectionState::VOTES_REGISTRATION) :

            if ($type === 1) :
                $election->getPairwise()->addNewVote($key);
            elseif ($type === 2) :
                $election->getPairwise()->removeVote($key);
            endif;

            $election->cleanupCalculator();
        else :
            $election->setStateToVote();
        endif;
    }


/////////// Get Votes Methods ///////////

    public function getVoteKey (Vote $vote): ?int
    {
        ($r = \array_search(needle: $vote, haystack: $this->_Container, strict: true)) !== false || ($r = \array_search(needle: $vote, haystack: $this->_Cache, strict: true));

        return ($r !== false) ? $r : null;
    }

    protected function getFullVotesListGenerator (): \Generator
    {
        foreach ($this as $voteKey => $vote) :
            yield $voteKey => $vote;
        endforeach;
    }

    protected function getPartialVotesListGenerator (array $tags, bool $with): \Generator
    {
        foreach ($this as $voteKey => $vote) :
            $noOne = true;
            foreach ($tags as $oneTag) :
                if ( ( $oneTag === $voteKey ) || \in_array(needle: $oneTag, haystack: $vote->getTags(), strict: true) ) :
                    if ($with) :
                        yield $voteKey => $vote;
                        break;
                    else :
                        $noOne = false;
                    endif;
                endif;
            endforeach;

            if (!$with && $noOne) :
                yield $voteKey => $vote;
            endif;
        endforeach;
    }

    // Get the votes list
    public function getVotesList (?array $tags = null, bool $with = true): array
    {
        if ($tags === null) :
            return $this->getFullDataSet();
        else :
            $search = [];

            foreach ($this->getPartialVotesListGenerator($tags,$with) as $voteKey => $vote) :
                $search[$voteKey] = $vote;
            endforeach;

            return $search;
        endif;
    }

    // Get the votes list as a generator object
    public function getVotesListGenerator (?array $tags = null, bool $with = true): \Generator
    {
        if ($tags === null) :
            return $this->getFullVotesListGenerator();
        else :
            return $this->getPartialVotesListGenerator($tags,$with);
        endif;
    }

    public function getVotesValidUnderConstraintGenerator (?array $tags = null, bool $with = true): \Generator
    {
        $election = $this->getElection();
        $generator = ($tags === null) ? $this->getFullVotesListGenerator(): $this->getPartialVotesListGenerator($tags,$with);

        foreach ($generator as $voteKey => $oneVote) :
            if (!$election->testIfVoteIsValidUnderElectionConstraints($oneVote)) :
                continue;
            endif;

            yield $voteKey => $oneVote;
        endforeach;
    }

    public function getVotesListAsString (bool $withContext): string
    {
        $election = $this->getElection();

        $simpleList = '';

        $weight = [];
        $nb = [];

        foreach ($this as $oneVote) :
            $oneVoteString = $oneVote->getSimpleRanking($withContext ? $election : null);

            if(!array_key_exists(key: $oneVoteString, array: $weight)) :
                $weight[$oneVoteString] = 0;
            endif;
            if(!array_key_exists(key: $oneVoteString, array: $nb)) :
                $nb[$oneVoteString] = 0;
            endif;

            if ($election->isVoteWeightAllowed()) :
                $weight[$oneVoteString] += $oneVote->getWeight();
            else :
                $weight[$oneVoteString]++;
            endif;

            $nb[$oneVoteString]++;
        endforeach;

        \ksort($weight, \SORT_NATURAL);
        \arsort($weight);

        $isFirst = true;
        foreach ($weight as $key => $value) :
            if (!$isFirst) :
                $simpleList .= "\n";
            endif;
            $voteString = ($key === '') ? CondorcetElectionFormat::SPECIAL_KEYWORD_EMPTY_RANKING : $key;
            $simpleList .= $voteString.' * '.$nb[$key];
            $isFirst = false;
        endforeach;

        return $simpleList;
    }

    public function countVotes (?array $tag, bool $with): int
    {
        if ($tag === null) :
            return \count($this);
        else :
            $count = 0;

            foreach ($this as $key => $value) :
                $noOne = true;
                foreach ($tag as $oneTag) :
                    if ( ( $oneTag === $key ) || \in_array(needle: $oneTag, haystack: $value->getTags(), strict: true) ) :
                        if ($with) :
                            $count++;
                            break;
                        else :
                            $noOne = false;
                        endif;
                    endif;
                endforeach;

                if (!$with && $noOne) :
                    $count++;
                endif;
            endforeach;

            return $count;
        endif;
    }

    public function countInvalidVoteWithConstraints (): int
    {
        $election = $this->getElection();
        $count = 0;

        foreach ($this as $oneVote) :
            if(!$election->testIfVoteIsValidUnderElectionConstraints($oneVote)) :
                $count++;
            endif;
        endforeach;

        return $count;
    }

    public function sumVotesWeight (bool $constraint = false): int
    {
        $election = $this->getElection();
        $sum = 0;

        foreach ($this as $oneVote) :
            if ( !$constraint || $election->testIfVoteIsValidUnderElectionConstraints($oneVote) ) :
                $sum += $election->isVoteWeightAllowed() ? $oneVote->getWeight(): 1;
            endif;
        endforeach;

        return $sum;
    }
}