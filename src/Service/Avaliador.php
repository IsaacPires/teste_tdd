<?php

namespace Alura\Leilao\Service;

use DomainException;

class Avaliador
{
  private $maiorValor = -INF;
  private $menorValor = INF;
  private $maioresLances;


  public function avalia($leilao)
  {
   
    if($leilao->estaFinalizado()){
      throw new DomainException("Leilão Finalizado");
    }

    if(empty($leilao->getLances())){
      throw new DomainException("Não é possível avaliar um leilão vazio");
      
    }

    foreach ($leilao->getLances() as $lance)
    {
      if($lance->getValor() > $this->maiorValor)
      { 
        $this->maiorValor = $lance->getValor();
      }
      
      if($lance->getValor() < $this->menorValor){
        $this->menorValor = $lance->getValor();
      } 

    }

    $lances = $leilao->getLances();

    usort($lances, function ($lance1, $lance2){

   /*    if ($lance1->getValor() == $lance2->getValor()) {
        return 0;
      }

      return ($lance1->getValor() > $lance2->getValor()) ? -1 : 1; */

      return $lance2->getValor() - $lance1->getValor();


    });

    $this->maioresLances = array_slice($lances, 0, 3);

  }

  public function getMaiorValor()
  {
    return $this->maiorValor;
  }

  public function getMenorValor()
  {
    return $this->menorValor;
  }

  public function getMaioresLances()
  {
    return $this->maioresLances;
  }

}



