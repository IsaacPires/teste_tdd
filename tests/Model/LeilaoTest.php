<?php

use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use Alura\Leilao\Model\Lance;
use DomainException;
use PHPUnit\Framework\TestCase;

Class LeilaoTest extends TestCase
{



  public function testNaoReceberMaisDe5LancesPorUser(){

    $this->expectException(DomainException::class);

    $leilao = new Leilao('Palio');
    $user1 = new Usuario('AlanPa');
    $user2 = new Usuario('Enner');

    $leilao->recebeLance(new Lance($user1, 1000));
    $leilao->recebeLance(new Lance($user2, 1500));
    
    $leilao->recebeLance(new Lance($user1, 2000));
    $leilao->recebeLance(new Lance($user2, 2500));
    
    $leilao->recebeLance(new Lance($user1, 3000));
    $leilao->recebeLance(new Lance($user2, 3500));
    
    $leilao->recebeLance(new Lance($user1, 4000));
    $leilao->recebeLance(new Lance($user2, 4500));
    
    $leilao->recebeLance(new Lance($user1, 5000));
    $leilao->recebeLance(new Lance($user2, 5500));

    $leilao->recebeLance(new Lance($user1, 6000));

    static::assertCount(10, $leilao->getLances());
    static::assertEquals(5500, $leilao->getLances()[count($leilao->getLances()) - 1]->getValor());

  }



  public function testSemReceberLancesRepetidos()
  {

    $this->expectException(DomainException::class);
    $this->expectExceptionMessage("Não é permitido realizar dois lances consecutivos");
    

    $leilao = new Leilao('Palio');
    $user1 = new Usuario('AlanPa');

    $leilao->recebeLance(new Lance($user1, 1000));
    $leilao->recebeLance(new Lance($user1, 2000));


    static::assertCount(1, $leilao->getLances());
    static::assertEquals(1000, $leilao->getLances()[0]->getValor());


  }

  /**
   * @dataProvider geraLances
   */
  public function testrecebeLances(
    int $qtdLances,
    Leilao $leilao,
    array $valores
  ){

    static::assertCount($qtdLances, $leilao->getLances());

    foreach ($valores as $key => $valorEsperado) {
     static::assertEquals($valorEsperado, $leilao->getLances()[$key]->getValor());
    }

  }

  public static function geraLances()
  {
    $user1 = new Usuario('AlanPa');
    $user2 = new Usuario('Valencia');

    $leilao2Lances = new Leilao('Palio');

    $leilao2Lances->recebeLance(new Lance($user1, 1000));
    $leilao2Lances->recebeLance(new Lance($user2, 2000));

    $leilao1Lances = new Leilao('corsinha');
    $leilao1Lances->recebeLance(new Lance($user1, 5000));
    
    return [
      'dois-lances' => [2, $leilao2Lances, [1000, 2000]],
      'um-lance' => [1, $leilao1Lances, [5000]],

    ];

  }

/*   public static function geraLanceRepitido()
  {

   
    return [
      'lance-repetido' => [1, $leilao, 1000],
    ];

  } */

/*   public static function AceitaApenas5Lances()
  {

   


    return [
      'multiplos-Lancamentos' => [10, $leilao, 5500],
    ];

  } */

}