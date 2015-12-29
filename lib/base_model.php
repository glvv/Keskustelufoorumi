<?php

class BaseModel {

    protected $validators;

    public function __construct($attributes = null) {
        foreach ($attributes as $attribute => $value) {
            if (property_exists($this, $attribute)) {
                $this->{$attribute} = $value;
            }
        }
    }

    public function errors() {
        $errors = array();
        foreach ($this->validators as $validator) {
            $errors = array_merge($errors, $this->{$validator}());
        }
        return $errors;
    }

    protected function queryWithParameters($sql, $parameters) {
        $query = DB::connection()->prepare($sql);
        $query->execute($parameters);
        return $query->fetchAll();
    }

    protected function queryWithoutParameters($sql) {
        $query = DB::connection()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    protected function queryWithParametersLimit1($sql, $parameters) {
        $query = DB::connection()->prepare($sql);
        $query->execute($parameters);
        return $query->fetch();
    }

    protected function queryWithoutParametersLimit1($sql) {
        $query = DB::connection()->prepare($sql);
        $query->execute();
        return $query->fetch();
    }

}
