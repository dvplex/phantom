<?php

namespace dvplex\Phantom\Traits;


trait PhantomSearch {

    protected $fields = [];
    protected $oFields = [];
    protected $query;
    protected $field;
    protected $request;
    protected $element;
    protected $order;


    public function scopeSearchInit($query, $request, $element, $order = false) {
        if (is_array($request)) {
            $rq = $request;
            $request = new \stdClass();
            $request->q = $rq['q'];
        }
        $this->request = $request;
        if ($order)
            $this->order = $order;
        $this->element = $element;
        if ($request->q) {
            \Session::put('search.' . $element . '.query', $request->q);
            \Session::put('search.hasSearch', true);
        }
        else {
            \Session::put('search.hasSearch', false);
            \Session::put('search.' . $element . '.query', '');

        }
        if (isset($request->page))
            \Session::put('search.' . $element . '.page', $request->page);
        else
            \Session::put('search.' . $element . '.page', '1');

        if (isset($request->orderByName) && isset($request->orderByDir)) {
            \Session::put('search.' . $element . '.order.name', $request->orderByName);
            \Session::put('search.' . $element . '.order.dir', $request->orderByDir);
        }
        else
            \Session::forget('search.' . $element . '.order');

        return $query;
    }

    public function scopeSearchFields($query, $fields = []) {
        $this->fields = $fields;

        return $query;
    }

    public function scopeOrderByFields($query, $fields = []) {
        foreach ($fields as $field) {
            \Session::put('search.' . $this->element . '.orderFields.' . $field, ['fa-sort']);
        }

        return $query;
    }

    public function scopeSearch($query, $perPage = false) {
        if (isset($this->request->per_page)) {
            \Session::put('search.' . $this->element . '.perPage', $this->request->per_page);
            $perPage = $this->request->per_page;
        }
        if ($this->request->q) {
	        $query->where(function ($query) {
		        $rq = $this->request;
		        $table = $query->first();
		        if ($table)
			        $table = $table->getTable() . '.';
		        else
			        $table = '';
		        foreach ($this->fields as $field) {
			        if (preg_match('/::/', $field)) {
				        $fld = explode('::', $field);
				        $query->orWhereHas($fld[0], function ($query) use ($fld, $rq) {
					        $query->Where($fld[1], 'LIKE', "%{$rq->q}%");
				        });
			        }
			        else {
				        $query->orWhere($table . $field, 'LIKE', "%{$this->request->q}%");
			        }
		        }
	        });
        }
	    if (isset($this->request->orderByName) && isset($this->request->orderByDir)) {
		    $query->getQuery()->orders = null;
		    if (preg_match('/::/', $this->request->orderByName)) {
                $fld = explode('::', $this->request->orderByName);
                $rel = $query->first()->company();
                $table = $rel->getRelated()->getTable();
                $query->join($table, $rel->getQualifiedOwnerKeyName(), '=', $rel->getQualifiedForeignKeyName())->orderBy($table . '.' . $fld[1], $this->request->orderByDir);
            }
            else
                $query->orderBy($this->request->orderByName, $this->request->orderByDir);
        }
        /*
        if (isset($this->order['name'])&& isset($this->order['dir'])&&$this->order['dir']) {
            $query->getQuery()->orders = null;
            if (preg_match('/::/', $this->order['name'])) {
                $fld = explode('::', $this->order['name']);
                $rel = $query->first()->company();
                $table = $rel->getRelated()->getTable();
                $query->join($table, $rel->getQualifiedOwnerKeyName(), '=', $rel->getQualifiedForeignKeyName())->orderBy($table . '.' . $fld[1], $this->request->orderByDir);
            }
            else
                $query->orderBy($this->order['name'], $this->order['dir']);
        }
        */
        if ($this->request->q)
            return $query->paginate($perPage)->appends(['q' => $this->request->q]);
        else
            return $query->paginate($perPage);

    }

}
