<?php
class Application_Model_Util_ZendgridBotao
{
  const POSICAO_DIREITA = "right";
  const POSICAO_ESQUERDA = "left";
  
  private $titulo;
  private $nome;
  private $posicao;
  private $decorador;
  private $link;
  private $onClick;
  
  public function getOnClick()
  {
    return $this->onClick;
  }
  public function setOnClick($onClick)
  {
    $this->onClick = $onClick;
  }
  public function getTitulo()
  {
    return $this->titulo;
  }
  public function getNome()
  {
    return $this->nome;
  }
  public function getPosicao()
  {
    return $this->posicao;
  }
  public function getDecorador()
  {
    return $this->decorador;
  }
  public function getLink()
  {
    return $this->link;
  }
  public function setTitulo($titulo)
  {
    $this->titulo = $titulo;
  }
  public function setNome($nome)
  {
    $this->nome = $nome;
  }
  public function setPosicao($posicao)
  {
    $this->posicao = $posicao;
  }
  public function setDecorador($decorador)
  {
    $this->decorador = $decorador;
  }
  public function setLink($link)
  {
    $this->link = $link;
  }


}