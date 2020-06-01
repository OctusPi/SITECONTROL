<?php
interface InterfaceDao{

    /**
     * @param $obj
     * @return mixed
     */
    public function isUnique($obj);

    /**
     * @param $id
     * @return mixed
     */
    public function findById($id);

    /**
     * @param $param
     * @return mixed
     */
    public function findByParam($param);

    /**
     * @return mixed
     */
    public function findAll();

    /**
     * @param $obj
     * @return mixed
     */
    public function insere($obj);

    /**
     * @param $obj
     * @return mixed
     */
    public function update($obj);

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id);
}