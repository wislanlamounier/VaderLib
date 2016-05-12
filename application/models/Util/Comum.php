<?php
/* 
 * Mobilus Tecnologia 2015
 * Alexandre Ramos
 * 26-01-2015
 * Classe Util-Comum
 * Classe genérica para agrupar todas as funções publicas das aplicação.
 */
class Application_Model_Util_Comum
{
  // Variaveis Globais
  private $OcorreuErro;
  private $CodigoErro;
  private $DescricaoErro;
  private $OcorreuAlerta;
  private $CodigoAlerta;
  private $DescricaoAlerta;
  
  /*
   * Função para preencher variaveis de Sucesso
   */
  public function setRetornoSucesso()
  {
    $this->OcorreuErro = "false";
    $this->DescricaoErro = null;
    $this->OcorreuAlerta = "false";
    $this->DescricaoAlerta = "";
  }

  /**
   * Função para preencher variaveis de Erro
   * @param type $ErrorMessage - Mensagem de erro que será retornada
   */
  public function setRetornoException($ErrorMessage)
  {
    $this->OcorreuErro = "true";
    $this->DescricaoErro = $ErrorMessage;
    $this->OcorreuAlerta = "false";
    $this->DescricaoAlerta = null;
  }
  
  /**
   * Função para preencher variaveis de Alerta
   * @param type $Message - Mensagem de alerta que será retornada
   */
  public function setRetornoAlert($Message)
  {
    $this->OcorreuErro = "false";
    $this->DescricaoErro = null;
    $this->OcorreuAlerta = "true";
    $this->DescricaoAlerta = $Message;
  }

  /**
   * Função para transformar um array de objetos em uma string serializada com JSON
   * @param type $arrayObject
   * @return string
   */
  public function montaJSON($arrayObject = null)
  {   
    $retorno = '{"OcorreuErro":'.$this->OcorreuErro.',"DescricaoErro":"'.$this->DescricaoErro.'","OcorreuAlerta":'.$this->OcorreuAlerta.',"DescricaoAlerta":"'.$this->DescricaoAlerta.'"';

    if($arrayObject == null)
      $retorno .= '}';
    else
    {
      foreach($arrayObject as $key => $value)
      {
        $retorno .= ',"' . $key . '": ' . json_encode($value);
      }
      $retorno .= '}';
    }

    return $retorno;
  }


  /**
   * 
   * @param type $array
   * @param type $alias
   * @param type $botoes
   * @return type
   * @throws Exception
   */
  public static function MontarGridGenericoComArray($array, $alias, $botoes)
  {
    try
    {
      $bvbGrid = new Plugin_BvbConfig();
      $grid = $bvbGrid->grid(); // New Grid 
      $grid->setSource(new Bvb_Grid_Source_Json(json_encode($array)));

      $campos = array();
      $camposAlias = array();
      $cont = 0;
      foreach($alias as $key => $value)
      {
        $campos[$cont] = $key;
        $camposAlias[$cont] = $value;
        $cont++;
      }

      $grid->setGridColumns($campos);

      for($i = 0; $i < count($alias); $i++)
      {
        $grid->updateColumn($campos[$i], array('title' => $camposAlias[$i]));
      }

      $grid->setRowAltClasses('grid-alt');

      if($botoes)
      {

        foreach($botoes as $valor)
        {
          $zengridBotao = new Application_Model_Util_ZendgridBotao;
          $zengridBotao = $valor;
          $column = new Bvb_Grid_Extra_Column();
          $column->position($zengridBotao->getPosicao());
          $column->name($zengridBotao->getNome());
          $column->title($zengridBotao->getTitulo());
          $column->decorator("<a onClick='" . $zengridBotao->getOnClick() . "' style='text-align: middle;' href='" . $zengridBotao->getLink() . "' title='" . $zengridBotao->getTitulo() . "'>" . $zengridBotao->getDecorador() . "</a>");
          $grid->addExtraColumns($column)->addGridColumns(array($zengridBotao->getTitulo()));
        }
      }

      if($array)
      {
        $grid->setRecordsPerPage(30);
        $grid->setPaginationInterval(array(10 => 10, 20 => 20, 50 => 50, 100 => 100));
        return $grid;
      }
    }
    catch (Exception $e)
    {
      echo $e;
      exit;
      throw new Exception($e);
    }
  }
  public function MontarGridGenerico($select, array $campos, array $camposAlias)
  {
    $bvbGrid = new Plugin_BvbConfig();
    $grid = $bvbGrid->grid(); // New Grid 
    $column = new Bvb_Grid_Extra_Column();
    if($select)
    {
      try
      {
        $grid->query($select);
        //Setando as colunas que tenho que mostrar
        $grid->setGridColumns($campos);
        //Posicionamento das colunas.
        $grid->setRowAltClasses('grid-alt');
        //Trocando o titulo das labels da grid

        for($i = 0; $i = count($campos); $i++)
        {
          $grid->updateColumn($campos[$i], array('title' => $camposAlias[$i]));
        }

        //colocando mais colunas a direita
        $aux = $column->position('right')->name("Editar")->title("Editar")->decorator("<a class=\"link-btn\" href='" . $this->view->baseUrl() . "/estacas/editar/" . base64_encode('ID') . "/{{EstacaID}}/" . base64_encode("UltimaPagina") . "/" . base64_encode($_SERVER['REQUEST_URI']) . " ' title='Editar'><img src='/images/Grids/edit.png'/></a>");
        $grid->addExtraColumns($aux)->addGridColumns(array("Editar"));

        $aux = $column->position('right')->name("Excluir")->title("Excluir")->decorator("<a class=\"excluir\" href='" . $this->view->baseUrl() . "/estacas/excluir/" . base64_encode('ID') . "/{{EstacaID}}/" . base64_encode("UltimaPagina") . "/" . base64_encode($_SERVER['REQUEST_URI']) . "' id='excluir' onclick='return confirm(" . '"Deseja mesmo excluir este item?"' . ")' title='Excluir'><img src='/images/Grids/delete.png'/></a>");
        $grid->addExtraColumns($aux)->addGridColumns(array("Excluir"));

        $aux = $column->position('right')->name("Status")->title("Alterar status")->decorator("<a class=\"excluir\" href='#'  onclick='StatusEstaca({{EstacaID}}, \"{{StatusID}}\", \"{{CorteRealizado}}\", \"{{SoldaRealizado}}\", \"{{ProfundidadeRealizado}}\", \"{{DiametroRealizado}}\", \"{{CoroaRealizado}}\", \"{{CortePrevisto}}\", \"{{SoldaPrevisto}}\", \"{{ProfundidadePrevisto}}\", \"{{DiametroPrevisto}}\",\"{{CoroaPrevisto}}\");' title='Status'><img src='/images/Grids/iconnotebook.png'/></a>");
        $grid->addExtraColumns($aux)->addGridColumns(array("Status"));


        //passando para as view


        $grid->setRecordsPerPage(30);
        $grid->setPaginationInterval(array(10 => 10, 20 => 20, 50 => 50, 100 => 100));
        return array('Deploy' => $grid->deploy(), 'TotalRecords' => $grid->getTotalRecords());
      }
      catch (Exception $e)
      {
        throw new Exception($e);
      }
    }
  }
  public function formatarDatas($listaObjetos, $vetor, $formato)
  {
    try{
    $listaRetorno[] = array();
    foreach($listaObjetos as $obj)
    {
      foreach($vetor as $campo)
      {
        $dateTimeStamp = strtotime($obj->$campo);
        if($dateTimeStamp){
          $locale = new Zend_Locale('pt_BR');
          $date = new Zend_Date($dateTimeStamp, false, $locale);
          $obj->$campo = $date->toString($formato);
        }else{
          $vetorN = explode(" ",$obj->$campo);
          $vetorData = explode("-",$vetorN[0]);
          $strFormatada = $vetorData[2] . "/" . $vetorData[1] . "/" . $vetorData[0];
          $obj->$campo = $strFormatada;
        }
        
      }
      

      $listaRetorno[] = $obj;
    }
    }catch(Exception $e){
      echo $e->getMessage();exit;
    }
    return $listaRetorno;
  }
  
  public static function converterDataBrToUsa($dataBr){
    $vetor = explode("/", $dataBr);
    $dataUsa = $vetor[2] . "-" . $vetor[1] . "-" . $vetor[0];
    return $dataUsa;
  }  
  
    
}


