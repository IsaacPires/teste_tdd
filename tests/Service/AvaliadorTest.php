<?php

namespace Alura\Leilao\Testes\Service;

use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use Alura\Leilao\Model\Lance;
use Alura\Leilao\Service\Avaliador;
use DomainException;
use PHPUnit\Framework\TestCase;

Class AvaliadorTest extends TestCase
{

  private $leiloeiro;
  
    /* ao chamar cada caso de teste ele executa está função */

  protected function setUp() :void
  {
      $this->leiloeiro = new Avaliador();
  }

  /**
   * @dataProvider ordemCrescente
   * @dataProvider ordemDecrescente
   * @dataProvider ordemAleatoria
   */

  public function testEncontrarMaiorValor(Leilao $leilao)
  {

    $this->leiloeiro->avalia($leilao);

    $maiorValor = $this->leiloeiro->getMaiorValor();
    
    self::assertEquals(2500, $maiorValor );
     
  }

  /**
   * @dataProvider ordemCrescente
   * @dataProvider ordemDecrescente
   * @dataProvider ordemAleatoria
   */
  public function testEncontrarMenorValor(Leilao $leilao)
  {

    $this->leiloeiro->avalia($leilao);

    $menorValor = $this->leiloeiro->getMenorValor();

    self::assertEquals(1000, $menorValor );
     
  }
      /**
   * @dataProvider ordemCrescente
   * @dataProvider ordemDecrescente
   * @dataProvider ordemAleatoria
   */
  public function testeBusca3MaioresValores(Leilao $leilao)
  {

    $this->leiloeiro->avalia($leilao);

    $maiores = $this->leiloeiro->getMaioresLances();
    static::assertCount(3, $maiores);
    static::assertEquals(2500, $maiores[0]->getValor());
    static::assertEquals(2000, $maiores[1]->getValor());
    static::assertEquals(1700, $maiores[2]->getValor());

  }

  public function testLancaExcessaoEmLeilaoVazio()
  {

    $this->expectException(DomainException::class);
    $this->expectExceptionMessage('Não é possível avaliar um leilão vazio');
    $leilao = new leilao('Fusca Azul');
    $this->leiloeiro->avalia($leilao);

  }

  public function testLeilaoFinalizadoNaoPodeSerAvaliado(){
    
    $this->expectException(DomainException::class);
    $this->expectExceptionMessage('Leilão Finalizado');

    $leilao = new Leilao('Palio');

    $leilao->recebeLance(new Lance(new Usuario('Enner'), 2000));
    $leilao->finaliza();

    $this->leiloeiro->avalia($leilao);
  }

  /* Caso de tests data providers */
  public static function ordemCrescente()
  {
    $leilao = new Leilao('fard Ka');

    $kakashi = new Usuario('kakashi');
    $sasuke = new Usuario('sasuke');
    $sakura = new Usuario('sakura');
    $naruto = new Usuario('naruto');

    $leilao->recebeLance(new Lance($naruto, 1000));
    $leilao->recebeLance(new Lance($sakura, 1700));
    $leilao->recebeLance(new Lance($kakashi, 2000));
    $leilao->recebeLance(new Lance($sasuke, 2500));

    return [
     'ordem-crescente'=> [$leilao]
    ];
  }

  public static function ordemDecrescente()
  {
    $leilao = new Leilao('fard Ka');


    $kakashi = new Usuario('kakashi');
    $sasuke = new Usuario('sasuke');
    $sakura = new Usuario('sakura');
    $naruto = new Usuario('naruto');

    $leilao->recebeLance(new Lance($sasuke, 2500));
    $leilao->recebeLance(new Lance($kakashi, 2000));
    $leilao->recebeLance(new Lance($sakura, 1700));
    $leilao->recebeLance(new Lance($naruto, 1000));

    return [
     'ordem-decrescente'=> [$leilao]
    ];

  }

  public static function ordemAleatoria()
  {
    $leilao = new Leilao('fard Ka');


    $kakashi = new Usuario('kakashi');
    $sasuke = new Usuario('sasuke');
    $sakura = new Usuario('sakura');
    $naruto = new Usuario('naruto');

    $leilao->recebeLance(new Lance($kakashi, 2000));
    $leilao->recebeLance(new Lance($sasuke, 2500));
    $leilao->recebeLance(new Lance($naruto, 1000));
    $leilao->recebeLance(new Lance($sakura, 1700));

    return 
    [
      'ordem-Aleatoria' =>  [$leilao]
    ];

  }

  

}