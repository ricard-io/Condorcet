<?php
/*
    Condorcet PHP - Election manager and results calculator.
    Designed for the Condorcet method. Integrating a large number of algorithms extending Condorcet. Expandable for all types of voting systems.

    By Julien Boudry and contributors - MIT LICENSE (Please read LICENSE.txt)
    https://github.com/julien-boudry/Condorcet
*/
declare(strict_types=1);

namespace CondorcetPHP\Condorcet\Throwable;

use CondorcetPHP\Condorcet\Dev\CondorcetDocumentationGenerator\CondorcetDocAttributes\{Description, Example, FunctionReturn, PublicAPI, Related};
use CondorcetPHP\Condorcet\CondorcetVersion;

// Custom Exception
class CondorcetException extends \Exception implements \Stringable
{
    use CondorcetVersion;

    public const CODE_RANGE = [0,1000];

    public const EXCEPTION_CODE = [
        11 => 'You try to unserialize an object version older than your actual Class version. This is a problematic thing',
        13 => 'Formatting error: You must specify an integer',
        14 => 'Bad Input',

        16 => 'You have exceeded the maximum number of votes allowed per election ({{ infos1 }}).',
        18 => 'New vote can\'t match Candidate of his elections',
        20 => 'You need to specify one or more candidates before voting',
        21 => 'Bad vote timestamp format',
        22 => 'This context is not valid',
        23 => 'No Data Handler in use',
        24 => 'A Data Handler is already in use',
        25 => 'Algo class try to use existing alias',
        26 => 'Weight can not be < 1',
        30 => 'Seats number must be >= 1',

        31 => 'Vote object already registred',
        33 => 'This vote is not in this election',

        // DataManager
        50 => 'This entity does not exist.',

        // Algo.
        102 => 'Marquis of Condorcet algortihm can\'t provide a full ranking. But only Winner and Loser.',
        103 => 'This quota is not implemented.',
    ];

    protected array $_infos;

    public function __construct (int $code = 0, string ...$infos)
    {
        if ($code < static::CODE_RANGE[0] || $code > static::CODE_RANGE[1]) :
            throw new self (0,'Exception class error');
        endif;

        $this->_infos = $infos;

        parent::__construct(message: $this->correspondence($code), code: $code);
    }

    public function __toString (): string
    {
           return static::class . ": [{$this->code}]: {$this->message} (line: {$this->file}:{$this->line})\n";
    }

    protected function correspondence (int $code): string
    {
        // Algorithms
        if ($code === 0 || $code === 101) :
            return $this->_infos[0] ?? '';
        endif;

        if ( \array_key_exists($code, static::EXCEPTION_CODE) ) :
            return \str_replace('{{ infos1 }}', $this->_infos[0] ?? '', static::EXCEPTION_CODE[$code]);
        else :
            return static::EXCEPTION_CODE[0] ?? 'Mysterious Error';
        endif;
    }
}
