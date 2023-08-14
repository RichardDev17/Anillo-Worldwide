<?php
  class QueryProcessor
  {
    public $result,$var;
    public function __construct ($query, $connection) {
      $this->query = $query;
      $this->connection = $connection;
    }
    public function defineVar($trgt) {
      $this->var = $trgt;
      $this->query = $this->query."'".$this->var."'";
      return $this;
    }
    public function runQuery() {
      $this->result = mysqli_query($this->connection, $this->query);
      return $this;
    }
    public function getResult() {
      $this->runQuery();
      return $this->result;
    }
  }
  class QueryProcessorUpdate
  {
    public $result;
    public function __construct($first_query_part, $second_query_part, $connection) {
      $this->first_query_part = $first_query_part;
      $this->second_query_part = $second_query_part;
      $this->connection = $connection;
    }

    public function defineVarforWhere($trgt) {
      $this->second_query_part = $this->second_query_part."'".$trgt."'";
      return $this;
    }

    public function defineVarforSet($trgt) {
      $this->first_query_part = $this->first_query_part."'".$trgt."'";
      return $this;
    }

    public function makeQuery() {
      $this->query = $this->first_query_part." ".$this->second_query_part;
      return $this->query;
    }
    public function runQuery() {
      $this->actualquery = $this->makeQuery();
      $this->result = mysqli_query($this->connection, $this->actualquery);
      return $this->result;
    }
  }
  