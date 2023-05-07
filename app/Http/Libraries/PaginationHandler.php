<?php

namespace App\Http\Libraries;

class PaginationBuilder {

    public static function build($paginatedData) {
        $data = $paginatedData->toArray();
        $response = ['data' => $data['data']];
        unset($data['data']);
        $response['pagination'] = self::manipulatePaginationData($data);
        return $response;
    }

    public static function manipulatePaginationData($pagination) {
        $pagination = (!is_array($pagination)) ? (array) $pagination:$pagination;
        if (count($pagination) <= 0) {
            return new \stdClass();
        }
        if ($pagination['current_page']==NULL) {
            $pagination['current_page'] = 0;
        }
        if ($pagination['from']==NULL) {
            $pagination['from'] = 0;
        }
        if ($pagination['last_page']==NULL) {
            $pagination['last_page'] = 0;
        }
        if ($pagination['next_page_url']==NULL) {
            $pagination['next_page_url'] = '';
        }
        if ($pagination['path']==NULL) {
            $pagination['path'] = '';
        }
        if ($pagination['per_page']==NULL) {
            $pagination['per_page'] = 0;
        }
        if ($pagination['prev_page_url']==NULL) {
            $pagination['prev_page_url'] = '';
        }
        if ($pagination['to']==NULL) {
            $pagination['to'] = 0;
        }
        if ($pagination['total']==NULL) {
            $pagination['total'] = 0;
        }
        return $pagination;
    }

}
