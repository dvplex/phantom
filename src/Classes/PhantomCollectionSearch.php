<?php
/**
 * Created by PhpStorm.
 * User: rehash
 * Date: 5.09.18 г.
 * Time: 11:10
 */

namespace dvplex\Phantom\Classes;


use Illuminate\Support\Collection;

class PhantomCollectionSearch {
    protected $collection;
    protected $request;
    protected $element;
    protected $fields;

    public function __construct() {
    }

    public function searchInit($collection, $request, $element) {

        $this->collection = $collection;
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

        return true;
    }

    public function searchFields($fields = []) {
        $this->fields = $fields;

        return true;
    }

    public function search($perPage = false) {
        if (isset($this->request->orderByName) && isset($this->request->orderByDir)) {
            if ($this->request->orderByDir == 'asc')
                $this->collection = $this->collection->sortBy($this->request->orderByName);
            elseif ($this->request->orderByDir=='desc')
                $this->collection = $this->collection->sortByDesc($this->request->orderByName);
        }
        if ($this->request->per_page) {
            \Session::put('search.' . $this->element . '.perPage', $this->request->per_page);
            $perPage = $this->request->per_page;
        }
        $search = '';
        if ($this->request->q)
            $search = $this->request->q;
        if ($search) {
            foreach ($this->fields as $word) {
                $filtered[] = $this->collection->filter(function ($item) use ($search, $word) {
                    return stripos($item[$word], $search) !== false;
                });
            }
            $fll = new Collection();
            foreach ($filtered as $fl) {
                $fll = $fll->merge($fl);
            }
        }
        else
            $fll = $this->collection;
        if ($this->request->q)
            return $fll->paginate($perPage)->appends(['q' => $this->request->q]);
        else
            return $fll->paginate($perPage);
    }


}
