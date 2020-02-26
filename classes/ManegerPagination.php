<?php
/**
 * Created by PhpStorm.
 * User: octuspi
 * Date: 17/06/2018
 * Time: 07:20
 */

class ManegerPagination
{
    private $maxPages;
    private $minItens;
    private $list;

    /**
     * ManagerListPagination constructor.
     * @param array $list
     * @param $maxPages
     * @param $minItens
     */
    public function __construct($list, $maxPages, $minItens)
    {
        $this->list = $list;
        $this->setMaxPages($maxPages);
        $this->setMinItens($minItens);
    }

    /**
     * @param int $maxPages
     */
    private function setMaxPages(int $maxPages)
    {
        $this->maxPages = $maxPages;
    }

    /**
     * @param int $minItens
     */
    private function setMinItens(int $minItens)
    {
        $this->minItens = $minItens;
    }

    /**
     * @return int
     */
    private function lengList(){
        if($this->list == null){
            return 0;
        }else{
            return count($this->list);
        }
    }

    /**
     * @return float|int
     */
    private function totalItensPage(){
        if($this->lengList() > 0){
            if($this->lengList() <= ($this->maxPages * $this->minItens)){
                return $this->minItens;
            }else{
                return round(($this->lengList()/$this->maxPages), 0);
            }
        }else{
            return 0;
        }

    }

    /**
     * @param $page
     * @return float|int
     */
    public function getIniPageList($page){
        return $this->totalItensPage() * ($page - 1);
    }

    /**
     * @return float|int
     */
    public function getFinPageList($page){
        $page = $page == 0 ? 1 : $page;
        return $this->totalItensPage() * $page;
    }

    /**
     * @param $page
     * @return array|null
     */
    public function getListPagination($page){
        if($this->lengList() > 0){
            $pageList = array();
            foreach($this->list as $k=>$v):
                if($k >= $this->getIniPageList($page) && $k < $this->getFinPageList($page)):
                    array_push($pageList, $v);
                endif;
            endforeach;
            return $pageList;
        }else{
            return null;
        }
    }

    /**
     * @return int
     */
    public function getNumberPages(){
        if($this->lengList() <= $this->minItens){
            return 1;
        }else{
            $p = 0;
            for ($i=0; $i<$this->lengList(); $i+=$this->totalItensPage()){
                $p++;
            }
            return $p;
        }
    }
}