<?php

use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use Alura\Leilao\Model\Lance;
use Alura\Leilao\Service\Avaliador;

require 'vendor/autoload.php';


/* $leilao = new Leilao('fard Ka');

$maria = new Usuario('Maria');
$joao = new Usuario('João');

$leilao->recebeLance(new Lance($maria, 2000));
$leilao->recebeLance(new Lance($joao, 2500));

$leiloeiro = new Avaliador();
$leiloeiro->avalia($leilao);

$maiorValor = $leiloeiro->getMaiorValor();
$menorValor = $leiloeiro->getMenorValor();

$valorEsperado = 2000;

  if($menorValor == $valorEsperado)
  {
    echo 'ok';
  }
  else{
    echo 'Error';
  } */

  /* 
  
  Para garantir a qualidade do código, devemos escrever testes;
  Um teste também é código;
  Um teste sempre segue um estrutura padrão, que tem três partes:
  A inicialização do cenário (Arrange ou Given)
  A execução da regra de negócio (Act ou When)
  A verificação do resultado (Assert ou Then)
  A tarefa do teste é dar um feedback rápido e claro sobre a corretude do nosso código.

  */


  $leilao = new Leilao('Pegeout 206');

  $snorlax = new Usuario('Snorlax');
  $goku = new Usuario('Goku');
  $rivaldo = new Usuario('Rivaldo');
  $sasuke = new Usuario('Sasuke');

  $leilao->recebeLance(new Lance($snorlax, 1500));
  $leilao->recebeLance(new Lance($goku, 1000));
  $leilao->recebeLance(new Lance($rivaldo, 2000));
  $leilao->recebeLance(new Lance($sasuke, 1700));

  $leiloeiro = new Avaliador();
  $leiloeiro->avalia($leilao);

  $maiores = $leiloeiro->getMaioresLances();