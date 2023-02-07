<?php
/*
    Condorcet PHP - Election manager and results calculator.
    Designed for the Condorcet method. Integrating a large number of algorithms extending Condorcet. Expandable for all types of voting systems.

    By Julien Boudry and contributors - MIT LICENSE (Please read LICENSE.txt)
    https://github.com/julien-boudry/Condorcet
*/
declare(strict_types=1);

namespace CondorcetPHP\Condorcet\Dev\CondorcetDocumentationGenerator\CondorcetDocAttributes;

use Attribute;
use CondorcetPHP\Condorcet\Dev\CondorcetDocumentationGenerator\BookLibrary;

#[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class Book
{
    public function __construct(public readonly BookLibrary $chapter)
    {
    }
}