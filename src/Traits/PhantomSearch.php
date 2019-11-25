<?php

namespace dvplex\Phantom\Traits;


use function foo\func;

trait PhantomSearch {

	protected $fields = [];
	protected $oFields = [];
	protected $query;
	protected $field;
	protected $request;
	protected $element;


	public function scopeSearchInit($query, $request, $element) {
		$this->request = $request;
		$this->element = $element;
		if ($request->q) {
			\Session::put('search.' . $element . '.query', $request->q);
			\Session::put('search.hasSearch', true);
		}
		else {
			\Session::put('search.hasSearch', false);
			\Session::put('search.' . $element . '.query', '');

		}
		if ($request->page)
			\Session::put('search.' . $element . '.page', $request->page);
		else
			\Session::put('search.' . $element . '.page', '1');

		if ($request->orderBy0Name && $request->orderByDir) {
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
			\Session::put('search.' . $this->element . '.orderFields.' . $field, ['wb-sort-vertical']);
		}

		return $query;
	}

	public function scopeSearch($query, $perPage = false) {
		if ($this->request->per_page) {
			\Session::put('search.' . $this->element . '.perPage', $this->request->per_page);
			$perPage = $this->request->per_page;
		}
		$query->where(function ($query) {
			$rq = $this->request;
			$table = $query->first();
			if ($table)
				$table = $table->getTable() . '.';
			else
				$table='';
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
		if ($this->request->orderByName && $this->request->orderByDir) {
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
		if ($this->request->q)
			return $query->paginate($perPage)->appends(['q' => $this->request->q]);
		else
			return $query->paginate($perPage);

	}
}
