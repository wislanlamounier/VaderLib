<?php

/**
 * Created by PhpStorm.
 * User: Tiaguinho
 * Date: 19/11/2015
 * Time: 10:06
 */
class Vader_Filtros_BaseZendGrid
{
  const TIPO_SELECT = 0;

  public $tipo = self::TIPO_SELECT;
  public $opcoes;
  public $label;
  public $placeHolder = 'Selecione um item';
  public $nome;
  public $classeCSS;
  public $attr;
  public $ID = 'list-filtro';

  /**
   * @param mixed $attr
   */
  public function setAttr($attr)
  {
    $this->attr[] = $attr;
    return $this;
  }



  /**
   * @return mixed
   */
  private function getTipo()
  {
    return $this->tipo;
  }

  /**
   * @param mixed $tipo
   */
  public function setTipo($tipo)
  {
    $this->tipo = $tipo;
    return $this;
  }

  /**
   * @return mixed
   */
  private function getOpcoes()
  {
    return $this->opcoes;
  }

  /**
   * @param mixed $opcoes
   */
  public function setOpcoes($opcoes)
  {
    $this->opcoes = $opcoes;
    return $this;
  }

  /**
   * @return mixed
   */
  private function getLabel()
  {
    return $this->label;
  }

  /**
   * @param mixed $label
   */
  public function setLabel($label)
  {
    $this->label = $label;
    return $this;
  }

  /**
   * @return mixed
   */
  private function getPlaceHolder()
  {
    return $this->placeHolder;
  }

  /**
   * @param mixed $placeHolder
   */
  public function setPlaceHolder($placeHolder)
  {
    $this->placeHolder = $placeHolder;
    return $this;
  }

  /**
   * @return mixed
   */
  private function getNome()
  {
    return $this->nome;
  }

  /**
   * @param mixed $nome
   */
  public function setNome($nome)
  {
    $this->nome = $nome;
    return $this;
  }

  /**
   * @return mixed
   */
  private function getClasseCSS()
  {
    return $this->classeCSS;
  }

  /**
   * @param mixed $classeCSS
   */
  public function setClasseCSS($classeCSS)
  {
    $this->classeCSS = $classeCSS;
    return $this;
  }

  /**
   * @return mixed
   */
  private function getID()
  {
    return $this->ID;
  }

  /**
   * @param mixed $ID
   */
  public function setID($ID)
  {
    $this->ID = $ID;
    return $this;
  }




}