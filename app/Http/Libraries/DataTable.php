<?php

namespace App\Http\Libraries;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;


class DataTable{

    private static $_table;
    private static $_model;
    private static $_primaryKey;
    private static $_columns;
    private static $_requestColumns;
    private static $_query;
    private static $_start;
    private static $_length;
    private static $_order;
    private static $_search;
    private static $_draw;
    private static $_extraColumns;
    private static $_joins;
    private static $_miscellaneous;
    private static $_relations = [];
    private static $_primaryKeyAlias;

    public static function init($tableName, $columns, $primaryKey = 'id', $primaryKeyAlias = 'id') {
        $tableColumns = ['id'];
        foreach ($columns as $key => $value) {
            $tableColumns[] = $value['db'];
        }
        if(is_string($tableName)){
            self::$_table = $tableName;
            self::$_query = DB::table($tableName)->select($tableColumns)->whereNull('deleted_at');
        }else {
            self::$_model = $tableName;
            self::$_query = self::$_model->select($tableColumns);
        }

        self::$_primaryKey = $primaryKey;
        self::$_primaryKeyAlias = $primaryKeyAlias;
        self::$_columns = $columns;
        foreach ($columns as $dbColumn) {
            if (isset($dbColumn['alias'])) {
                self::$_query->addSelect($dbColumn['alias'].'.'.$dbColumn['db'].' as '.$dbColumn['new_name']);
            }
        }
        self::groupActions();
    }

    private static function groupActions() {
        $customActionType = Request::input('customActionType');
        $customActionName = Request::input('customActionName');
        $customActionId = Request::input('customActionId', []);
        if ($customActionType=='group_action' && count($customActionId) > 0) {
            $timestamp = Carbon::now()->format('Y-m-d H:i:s');
            switch ($customActionName) {
                case 'delete':
                    if (is_string(self::$_table)) {
                        DB::table(self::$_table)->withTrashed()->whereIn(self::$_primaryKey, $customActionId)->update(['deleted_at' => $timestamp, 'updated_at' => $timestamp]);
                    }
                    else {
                        self::$_model->withTrashed()->whereIn(self::$_primaryKey, $customActionId)->delete();
                    }
                    break;
                case 'active':
                    if (is_string(self::$_table)) {
                        DB::table(self::$_table)->whereIn(self::$_primaryKey, $customActionId)->update(['is_active' => 1]);
                    }
                    else {
                        self::$_model->withTrashed()->whereIn(self::$_primaryKey, $customActionId)->update(['is_active' => 1]);
                    }
                    break;
                case 'inactive':
                    if (is_string(self::$_table)) {
                        DB::table(self::$_table)->whereIn(self::$_primaryKey, $customActionId)->update(['is_active' => 0]);
                    }
                    else {
                        self::$_model->withTrashed()->whereIn(self::$_primaryKey, $customActionId)->update(['is_active' => 0]);
                    }
                    break;
            }
        }
    }


    public static function get($where = array(), $joins = array(), $extraColumns = array(), $misc = array()) {
        self::$_start = intval(Request::input('datatable.pagination.start', 0));
        self::$_length = intval(Request::input('datatable.pagination.perpage', 10));
        if (self::$_length <= 0) {
            self::$_length = 10;
        }
        if(Request::input('datatable.pagination.page', 1) > 1){
            self::$_start = (Request::input('datatable.pagination.page', 1) * self::$_length) - self::$_length;
        }else{
            self::$_start = 0;
        }
        self::$_order = Request::input('sort');
        self::$_requestColumns = Request::input('columns', []);
        self::$_search = Request::input('search');
        self::$_draw = Request::input('datatable.pagination.page', 1);
        self::$_extraColumns = $extraColumns;
        self::$_joins = $joins;
        self::$_miscellaneous = $misc;

        self::order();
        self::filter();
        self::join();
        if (sizeof($where) > 0) {
            foreach ($where as $key => $value) {
                self::$_query->where($key, '=', $value);
            }
        }
        if (isset(self::$_miscellaneous['callback']) && isset(self::$_miscellaneous['model'])) {
            $query = $misc['model']::$misc['callback'](self::$_query);
            if ($query) {
                self::$_query = $query;
            }
        }
        $queryBeforeLimit = self::$_query;
        $recordsTotal = sizeof($queryBeforeLimit->get());
        self::$_query->take(self::$_length)->skip(self::$_start);
//        return array(
//            "draw" => intval(self::$_draw),
//            "recordsTotal" => intval($recordsTotal),
//            "recordsFiltered" => intval($recordsTotal),
//            "data" => self::dataOutput(),
//        );
        if(self::$_length == 0){
            self::$_length = 10;
        }
        $pages = $recordsTotal/self::$_length;
        $totalPages = $recordsTotal;
        if($pages == 0){
            $pages = 1;
        }
        $perPage = $totalPages/$pages;
        return array(
            'meta' => [
                "page" => intval(self::$_draw),
                "pages" => intval($pages),
                "total" => intval($totalPages),
                "perpage" => $perPage,
                "start" => self::$_start
            ],
            "data" => self::dataOutput(),
        );
    }

    public static function where($column, $operator, $value){
        self::$_query->where($column, $operator, $value);
    }

    public static function whereBetween($column, $range = array()){
        self::$_query->whereBetween($column, $range);
    }

    public static function getOnlyTrashed($where = null){
        if(is_null($where)){
            self::$_query->onlyTrashed();
        }else{
            self::$_query->onlyTrashed()->where($where);
        }
    }

    public static function whereIn($columnName, $valueArray){
        self::$_query->whereIn($columnName, $valueArray);
    }

    public static function with($relation, $where = null, $count = false) {
        if (is_null($where)) {
            if ($count) {
                self::$_query->withCount($relation);
                $relation .= '_count';
            }
            else {
                self::$_query->with($relation);
            }
        }
        else {
            if ($count) {
                self::$_query->withCount([$relation => $where]);
                $relation .= '_count';
            }
            else {
                self::$_query->with([$relation => $where]);
            }
        }
        self::$_relations[] = $relation;
    }

    public static function whereHas($relation, $condition = NULL) {
        self::$_query->whereHas($relation, $condition);
    }
    public static function orderBy($column, $orderBy) {
        self::$_query->orderBy($column, $orderBy);
    }

    private static function dataOutput() {
        $out = array();
        $query = self::$_query;
        $data = $query->get();
        $extra = sizeof(self::$_extraColumns);
        for ($i = 0, $ien = count($data); $i < $ien; $i++) {
            $row = array();
            for ($j = 0, $jen = count(self::$_columns); $j < $jen; $j++) {
                $column = self::$_columns[$j];
                $fieldName = (isset(self::$_columns[$j]['alias'])) ? self::$_columns[$j]['new_name']:self::$_columns[$j]['db'];
                // Is there a formatter?
                if (isset($column['formatter'])) {
                    $row[$column['dt']] = $column['formatter']($data[$i]->$fieldName, $data[$i]);
                }
                else {
                    $row[$column['dt']] = $data[$i]->$fieldName;
                }
                if (sizeof(self::$_relations) > 0) {
                    foreach (self::$_relations as $relation) {
                        $row[$relation] = $data[$i]->$relation;
                    }
                }
            }
            if ($extra > 0) {
                foreach (self::$_extraColumns as $extraColumn) {
                    if (isset($data[$i]->$extraColumn)) {
                        $row[$extraColumn] = $data[$i]->$extraColumn;
                    }
                }
            }
            $row['actions'] = '';
            $primaryKey = self::$_primaryKeyAlias;
            $row[self::$_primaryKey] = $data[$i]->$primaryKey;
            $out[] = $row;
        }
        return $out;
    }

    private static function join() {
        if (sizeof(self::$_joins) > 0) {
            foreach (self::$_joins as $joinData) {
                if (!isset($joinData['alias'])) {
                    self::$_query->addSelect($joinData['table'].'.*');
                }
                self::$_query->$joinData['type']($joinData['table'].(isset($joinData['alias']) ? ' as '.$joinData['alias']:''), $joinData['first_column'], $joinData['operator'], $joinData['second_column']);
            }
        }
    }

    private static function order() {
        if (self::$_order && count(self::$_order)) {
            $dtColumns = self::pluck(self::$_columns, 'dt');
            for ($i = 0, $ien = count(self::$_order); $i < $ien; $i++) {
                // Convert the column index into the column data property
                $columnIdx = intval(self::$_order[$i]['column']);
                $requestColumn = self::$_requestColumns[$columnIdx];
                $columnIdx = array_search($requestColumn['data'], $dtColumns);
                $column = self::$_columns[$columnIdx];
                if ($requestColumn['orderable'] == 'true') {
                    $index = (isset($column['alias'])) ? $column['alias'].'.'.$column['db']:$column['db'];
                    self::$_query->orderBy($index, self::$_order[$i]['dir']);
                }
            }
        }
        else {
            if (isset(self::$_miscellaneous['orderBy'])) {
                self::$_query->orderBy(self::$_miscellaneous['orderBy']);
            }
            else {
                if (self::$_model) {
                    self::$_query->orderBy('id', 'DESC');
                }
                else {
                    self::$_query->orderBy(self::$_table.'.'.self::$_primaryKey, 'DESC');
                }
            }
        }
    }

    private static function filter() {
        $globalSearch = array();
        $columnSearch = array();
        $dtColumns = self::pluck(self::$_columns, 'dt');
        if (self::$_search && self::$_search['value'] != '') {
            $str = self::$_search['value'];
            for ($i = 0, $ien = count(self::$_requestColumns); $i < $ien; $i++) {
                $requestColumn = self::$_requestColumns[$i];
                $columnIdx = array_search($requestColumn['data'], $dtColumns);
                $column = self::$_columns[$columnIdx];
                if ($requestColumn['searchable'] == 'true') {
                    $index = (isset($column['alias'])) ? $column['alias'].'.'.$column['db']:$column['db'];
                    $globalSearch[$index] = '%'.$str.'%';
                }
            }
        }
        // Individual column filtering
        for ($i = 0, $ien = count(self::$_requestColumns); $i < $ien; $i++) {
            $requestColumn = self::$_requestColumns[$i];
            $columnIdx = array_search($requestColumn['data'], $dtColumns);
            $column = self::$_columns[$columnIdx];
            $str = $requestColumn['search']['value'];
            if ($requestColumn['searchable'] == 'true' && $str != '') {
                $index = (isset($column['alias'])) ? $column['alias'].'.'.$column['db']:$column['db'];
                $columnSearch[$index] = '%'.$str.'%';
            }
        }
        if (count($globalSearch)) {
            self::$_query->where(function($q) use($globalSearch) {
                $count = 1;
                foreach ($globalSearch as $key => $value) {
                    if ($count==1) {
                        $q->where($key, 'LIKE', $value);
                    }
                    else {
                        $q->orWhere($key, 'LIKE', $value);
                    }
                    ++$count;
                }
            });
        }
        if (count($columnSearch)) {
            self::$_query->where(function($q) use($columnSearch) {
                foreach ($columnSearch as $key => $value) {
                    $q->where($key, 'LIKE', $value);
                }
            });
        }
    }



    private static function pluck($a, $prop) {
        $out = array();
        for ($i = 0, $len = count($a); $i < $len; $i++) {
            $out[] = $a[$i][$prop];
        }
        return $out;
    }

}