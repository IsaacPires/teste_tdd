<?php

namespace Alura\Leilao\Model;

use DomainException;

class Leilao
{
    /** @var Lance[] */
    private $lances;
    /** @var string */
    private $descricao;
    private $finalizado;

    public function __construct(string $descricao)
    {
        $this->descricao = $descricao;
        $this->lances = [];
        $this->finalizado = false;
    }

    public function recebeLance(Lance $lance)
    {   
        if(!empty($this->lances) && $lance->getUsuario() == $this->lances[count($this->lances)-1]->getUsuario()){
            throw new DomainException("Não é permitido realizar dois lances consecutivos");
        }

        $usuario = $lance->getUsuario();
        $totalLancesUsuario = array_reduce(
            $this->lances,
            function (int $totalAcumulado, Lance $lanceAtual) use ($usuario)
             {
                if($lanceAtual->getUsuario() == $usuario){
                    return $totalAcumulado + 1;
                }

                return $totalAcumulado;
            },0
        );

        if($totalLancesUsuario >= 5){
            throw new DomainException("Usuário não pode realizar mais de 5 lances por leilão");

        }


        $this->lances[] = $lance;
    }

    public function finaliza(){
        $this->finalizado = true;
    }

    public function estaFinalizado(){
        return $this->finalizado;
    }

    /**
     * @return Lance[]
     */
    public function getLances(): array
    {
        return $this->lances;
    }
}
