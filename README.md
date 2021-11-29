<p align="center">
  <img src="condorcet-logo.png" alt="Condorcet" width="40%">
</p>

[![Build Status](https://github.com/julien-boudry/Condorcet/workflows/Execute%20All%20Tests/badge.svg?branch=master)](https://github.com/julien-boudry/Condorcet/actions)
[![License](https://d3g33cz5i5omk9.cloudfront.net/github/license/mashape/apistatus.svg?style=flat-square)](LICENSE.txt)
[![Packagist](https://d3g33cz5i5omk9.cloudfront.net/packagist/v/julien-boudry/condorcet.svg?style=flat-square)](https://packagist.org/packages/julien-boudry/condorcet)
[![Docker Hub](https://d3g33cz5i5omk9.cloudfront.net/docker/cloud/automated/julienboudry/condorcet?logo=Docker%20Hub%20Condorcet)](https://hub.docker.com/r/julienboudry/condorcet)
[![Packagist Download](https://d3g33cz5i5omk9.cloudfront.net/packagist/dt/julien-boudry/condorcet.svg?style=flat-square)](https://packagist.org/packages/julien-boudry/condorcet)
[![GitHub contributors](https://d3g33cz5i5omk9.cloudfront.net/github/contributors/julien-boudry/Condorcet.svg?style=flat-square)](https://github.com/julien-boudry/Condorcet/graphs/contributors)
![GitHub code size in bytes](https://d3g33cz5i5omk9.cloudfront.net/github/languages/code-size/julien-boudry/Condorcet.svg?style=flat-square)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/f34e354703514ab68248a0c995a4913a)](https://www.codacy.com/app/julien-boudry/Condorcet?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=julien-boudry/Condorcet&amp;utm_campaign=Badge_Grade)
[![Codacy Badge](https://api.codacy.com/project/badge/Coverage/f34e354703514ab68248a0c995a4913a)](https://www.codacy.com/app/julien-boudry/Condorcet?utm_source=github.com&utm_medium=referral&utm_content=julien-boudry/Condorcet&utm_campaign=Badge_Coverage)

> Main Author: [Julien Boudry](https://www.linkedin.com/in/julienboudry/)   
> License: [MIT](LICENSE.txt) _- Please say hello if you like or use this code!_  
> Contribute: [Contribute File](CONTRIBUTING.md)   
> Donation: **₿ [bc1qesj74vczsetqjkfcwqymyns9hl6k220dhl0sr9](https://blockchair.com/bitcoin/address/bc1qesj74vczsetqjkfcwqymyns9hl6k220dhl0sr9)** or **[Github Sponsor Page](https://github.com/sponsors/julien-boudry)**  
> _You can also offer me a bottle of good wine._  
>
> Methods provided natively: Condorcet / Borda (+ Nauru variant) / Copeland / Dodgson (2 Approximations) / FTPT / Instant-runoff (alternative vote) / Kemeny–Young / Minimax (+ variants) / Ranked Pairs (+ variants) / Schulze (+ variants) / STV  


Condorcet PHP
===========================
> **Presentation | [Manual](https://github.com/julien-boudry/Condorcet/wiki) | [Methods References](Documentation/README.md) | [Tests](Tests/)**  

Condorcet is an application implementing the Condorcet voting system and many other methods like the Schulze, Tideman, Borda or Alternative Voting. And also a powerful election manager allowing the logical management of a phased election, with many natives options and elections methodes included.  

_Two different ways to use Condorcet:_
* A **command line application**, for quick use of essential features without complicated technical knowledge. Allowing you to easily compute your elections results and stats.  
* A **PHP library** that you can include in your code to take advantage of 100% of the advanced features (abstraction, control, interaction, extensions).  


*Read more about alternative voting methods >> https://en.wikipedia.org/wiki/Condorcet_method*  

## Summary
1. [Project State and Specifications](#project-state-and-specifications)  
1. [Main features](#main-features)     
1. [Supported Methods](#supported-methods)  
  a. [Methods provided natively](#methods-provided-natively)     
  b. [Add your own method](#add-your-own-method-as-module)  
1. [Use Condorcet as a command line application](#use-condorcet-as-a-command-line-application)  
  a. [Install as an application](#install-as-an-application)  
  b. [Condorcet Wiki - Command Line Manual](#condorcet-wiki---command-line-manual)  
  c. [Command Line - Examples](#command-line---some-quick-examples)
1. [Use Condorcet as a PHP Library](#use-condorcet-as-a-php-library)  
  a. [Install / Autoloading](#install--autoloading)  
  b. [Condorcet Wiki Manual](#condorcet-wiki-manual)     
  c. [Class & Methods reference](#class--methods-reference)     
  d. [PHP Library - Examples](#php-library---examples) *Have a look on Examples!*     
  e. [Really quick and simple example](#really-quick-and-simple-example)
1. [Performance & Coding style considerations](#roadmap-for-further-releases)
1. [Roadmap for further releases](#roadmap-for-further-releases)
1. [Related projects / They use Condorcet](#related-projects--they-use-condorcet)  

## Project State and Specifications    

> [**Releases Notes**](CHANGELOG.md)

* **Stable Version: 3.2.x**  _support provided_  
  * * *PHP Requirement:* PHP 8.1
* **Stable Version: 3.1.x**  _support provided_  
  * * *PHP Requirement:* PHP 8.0. _(tested up to PHP 8.1)_
* **Stable Version: 2.2.x**  _support provided_  
  * * *PHP Requirement:* PHP 7.4 with Json PHP extension. _(tested up to PHP 8.0)_
* **Old Stable: 2.0.x** _support NOT provided_  
    * *PHP Requirement:* PHP 7.1 with Ctype, MB_String, Json common extensions. _(tested up to PHP 7.4)_
* **Very Old Stable: 1.0.x** _Support requiring some bait._  
    * *PHP Requirement:* PHP 5.6 with Ctype, MB_String, Json common extensions. _(tested up to PHP 7.1)_

_Some support and fix can be done for 0.14 version on demand. Since v0.90, you should consider then it's a new project (api, engine)._  

## Main features
* __Manage an election__
  * Respect an election cycle: Registering candidate, registering a vote, get results from many algorithms.
  * Ordered votes, delete it, simulate partials results.
  * Many input type available (String, Json, Parse text, Objects...)
  * Integrity check (checksumming) and logs.
  * Support for storing elections (serializing Election object, export data...)
  * Some methods can be used nearly front final user (anti-spam check, parsing input, human-friendly results and stats, vote constraints...)
* __Get election results and stats__
  * Get the natural Condorcet Winner, Loser, Pairwise, Paradox...
  * Get full ranking from advanced Condorcet-like methods (Schulze, Copeland, Ranked Pairs, Kemeny–Young, Minimax...)
  * Get full ranking from others methods like Alternative Vote
  * Get full ranking from proportional methods (STV...)
  * Get some additional stats from these methods
  * Force ranking all candidate implicitly _(default)_ or allow voters to not rank all candidates.
  * Put weight for each vote, give more importance to certain voters.
* __Be more powerful__
  * All are objects, all are abstract _(But there are many higher-level functions and inputs types)_.
  * Candidates and Votes are objects which can take part to multiples elections at the same time and change her name or ranking dynamically. That allows powerful tools to simulate elections.
  * Manage hundred billions of votes by activating an external driver to store (instead of RAM) an unlimited number of votes during the computation phase. A PDO driver is provided by default, an example is provided with SQLite, an interface allows you to design other drivers.
* __Extend it! Configure it!__
  * Modular architecture to extend it without fork Condorcet PHP! Just make your own module on your own namespace.
    * Election, Candidate and Vote class are extensible.
    * Add your own ranking algorithm.
    * Create your own votes constraints.
  * Allow you to use your own datastore driver to manage very large elections at your way without ram limit. A first driver for PDO (and Sqlite example) is provided.
  * Many configurations options and methods.

_Condorcet PHP is not designed for high performances. But can handle virtually unlimited voting without limit or degrading performance, it's a linear and predictable scheme._  
_And has no certification or proven implementation that would guarantee a very high level of reliability. However, there are many written tests for each voting methods and features. This ensures an excellent level of confidence in the results._   

## Supported Methods
### Methods provided natively

**All explanations and implementation choices [on this documentation](https://github.com/julien-boudry/Condorcet/wiki/I-%23-Installation---Basic-Configuration-%23-2.-Voting-Methods-%28library%29)**

* **Condorcet Basic** Give you the natural winner or loser of Condorcet if there is one.  
* **Borda count**
    * **[Borda System](VOTING_METHODS.md#borda-count)**
    * **[Dowdall system (Nauru)](VOTING_METHODS.md#dowdall-system-nauru)**
* **[Copeland](VOTING_METHODS.md#copeland)**
* **Dodgson Approximations**
    * **[Dodgson Quick](VOTING_METHODS.md#dodgson-quick)**
    * **[Dodgson Tideman approximation](VOTING_METHODS.md#dodgson-tideman-approximation)**
* **[Instant-runoff](VOTING_METHODS.md##instant-runoff-alternative-vote)** *(Alternative Vote / Preferential Voting)*
* **[Kemeny–Young](VOTING_METHODS.md#kemenyyoung)**
* **Majority Family**
    * **[First-past-the-post](VOTING_METHODS.md#first-past-the-post)**
    * **[Multiple Rounds system](VOTING_METHODS.md#multiple-rounds-system)**
* **Minimax Family**
    * **[Minimax Winning](VOTING_METHODS.md#minimax-winning)**
    * **[Minimax Margin](VOTING_METHODS.md#minimax-margin)**
    * **[Minimax Opposition](VOTING_METHODS.md#minimax-opposition)**
* **Ranked Pairs Family** *(Tideman method)*
    * **[Ranked Pairs Margin](VOTING_METHODS.md#ranked-pairs-margin)**
    * **[Ranked Pairs Winning](VOTING_METHODS.md#ranked-pairs-winning)**
* **Schulze Method**
    * **[Schulze Winning](VOTING_METHODS.md#schulze-winning)** *(recommended)*
    * **[Schulze Margin](VOTING_METHODS.md#schulze-margin)**
    * **[Schulze Ratio](VOTING_METHODS.md#schulze-ratio)**
* **[Single Transferable Vote](VOTING_METHODS.md#single-transferable-vote)** *(STV)*

### Add your own method as module
Condorcet is designed to be easily extensible with new algorithms (they don't need to share the same namespace).  
[*More explanations in the documentation below*](https://github.com/julien-boudry/Condorcet/wiki/III-%23-B.-Extending-Condorcet-%23-1.-Add-your-own-ranking-algorithm)  

---------------------------------------
## Use Condorcet as a command line application

_I have undertaken and continues to undertake efforts to reform and improve the documentation. Thereof is not yet satisfactory and perfectly updated. Your help is welcome!_

### Install as an application

#### Option 1: Build it yourself with composer
***(you must have PHP >= 8.1 and composer)***  

```shell
mkdir Condorcet && cd Condorcet
composer require julien-boudry/condorcet

# Execute a command, example:
./vendor/bin/condorcet election -c "A;B;C" -w "A>B;A>C;C>B" -r
```

#### Option 2: From Docker Container

_You must install Docker first. See [installation instructions](https://hub.docker.com/search/?type=edition&offering=community)._

##### From a public image
```shell
docker pull julienboudry/condorcet:latest

# Interactive mod
docker run -it --rm julienboudry/condorcet election

# With custom parameters :
docker run -it --rm julienboudry/condorcet election -c "A;B;C" -w "A>B;A>C;C>B" -r
```

##### From docker file
```shell
git clone https://github.com/julien-boudry/Condorcet.git
cd Condorcet
docker build -t condorcet .

# Interactive mod
docker run --rm -it condorcet election

# Or execute a command, example:
docker run --rm -it condorcet election -c "A;B;C" -w "A>B;A>C;C>B" -r
```

#### Option 3: From PHAR file

Download the PHAR file from [releases section](https://github.com/julien-boudry/Condorcet/releases).

```shell
# Interactive mod
php condorcet.phar

# Or execute a command, example:
php condorcet.phar election -c "A;B;C" -w "A>B;A>C;C>B" -r
```

### Condorcet Wiki - Command Line Manual

* [**Examples**](https://github.com/julien-boudry/Condorcet/wiki/III-%23-Usage-%28command-line%29)
* [**Man Page**](https://github.com/julien-boudry/Condorcet/wiki/II-%23-Man-Page-%28command-line%29)

## Use Condorcet as a PHP Library

### Install / Autoloading  
This project is consistent with the standard PSR-4 and can be loaded easily and without modification in most frameworks or Composer autoloader. Namespace \CondorcetPHP is used. 
The examples also provide an easy way of implementation using an optional Condorcet autoloader. If you don't want to use composer or others PSR-4 autoloader.

> [**Please visit the install section from the wiki**](https://github.com/julien-boudry/Condorcet/wiki/I-%23-Installation---Basic-Configuration-%23-1.-Installation-%28library%29)    

### Condorcet Wiki Manual

* **[Visit the Manual](https://github.com/julien-boudry/Condorcet/wiki)**

Living and learning examples, giving an overview but not exhaustive of the possibilities of the library.

### Class & Methods reference

The precise documentation of methods is not a wiki. It can be found in the form of Markdown in the "Documentation" folder for each release.   
* [Class & Methods documentation](Documentation/README.md)

### PHP Library - Examples

### Overview

* [General Overview](Examples/1.%20Overview.php) _(not exhaustive and partial, but just a great tour.)_
* [Advanced Object Management](Examples/1.%20AdvancedObjectManagement.php)

### With Html output basics examples

* [Visual simple & advanced script examples with HTML output](Examples/Examples-with-html/)

### Specifics examples

* [Condorcet Wiki Manual](https://github.com/julien-boudry/Condorcet/wiki) provides many code example
* [Manage millions of votes with an external database drive](Examples/Specifics_Examples/use_large_election_external_database_drivers.php) Your own driver, or the provided simple driver for PDO.


## Performance & Coding style considerations

#### Coding standards:  
The code is close to the respect of PSR-1 (lacks only the naming of methods), and freely influenced by PSR-2 when it is not unnecessarily authoritarian.  

#### Performance:  
* Complete and huge use case with all algorithms chained, 6 candidates and one thousand votes (many with implicit ranking).
  * _Memory usage: less than 6M_    
  * _Execution time: less than 180ms_  
###### Kemeny-Youg case:   
* use Kemeny-Young 7 candidates: ~8MB - 25ms    
* use Kemeny-Young 8 candidates: ~80MB - 230ms    
###### Massive election case:  
Extending PHP memory_limit allows you to manage hundreds of thousands of votes, but it can be a bit slower than outsource this data (PHP don't like that) and it's not extensive to infinity.   

If you need to manage an election with more than 50 000 votes. You should consider externalizing your data, Condorcet provides a simple PDO driver to store data outside RAM between processing steps, this driver stores it into a classical relational database system, it supports hundreds millions votes _(or more)_. A very simple example with Sqlite is provided and very easy to activate.   

You can also develop your own datastore driver (to store into NoSQL... all your fantasy), the modular architecture allows you to link it easily.

[Have a look to the manual](https://github.com/julien-boudry/Condorcet/wiki/III-%23-A.-Avanced-features---Configuration-%23-3.-Get-started-to-handle-millions-of-votes-%28library%29)     

_Benchmark on a modern machine (linux - x64 - php 8.0 - cli)._ 


## Roadmap for further releases 
  
  - **Research reference librarians !!**  


## Related projects / They use Condorcet
* From August 2014: [Condorcet.Vote](http://www.condorcet.vote) Web services to create and store online Condorcet election. Including interactives and collaborative features.    
It is based in large part on this project and uses the library as a real election manager for computing, storage & stats.        
* [Mahler-S2-BlindTest-Condorcet
](https://github.com/julien-boudry/Mahler-S2-BlindTest-Condorcet) (French interface) Web wrapper to compute and show the result for classical music blind challenge with the Condorcet Class full potential (can also be used and adapted for any elections).    
Look like the examples provided here, but better: [Gustav Mahler blind listening test](http://classik.forumactif.com/t7244-ecoute-comparee-mahler-2e-symphonie-la-suite)    
