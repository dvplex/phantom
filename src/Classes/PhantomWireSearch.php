<?php

namespace dvplex\Phantom\Classes;

use App\Support\Collection;
use Livewire\Component;
use Livewire\WithPagination;

abstract class PhantomWireSearch extends Component {
    use WithPagination;

    protected $listeners = ['phantomSearch' => 'search'];
    public $request;
    private $ssid;
    public $qry;
    private $model;
    private $obFields;
    private $sFields;
    private $objName;
    private $renderTo;
    public $order = [];

    public function paginationView() {
        return 'phantom::layouts.paginate-wire';
    }

    public function orderBy($name) {
        $this->order['name'] = $name;
        if ($this->orderDir == '') {
            $this->order['dir'] = 'asc';
            $this->orderDir = '-up';
        }
        elseif ($this->orderDir == '-up') {
            $this->orderDir = '-down';
            $this->order['dir'] = 'desc';
        }
        else {
            $this->orderDir = '';
            $this->order['dir'] = '';
        }
        return $this;
    }

    public function prepare($sid, $qry, $model, $order = false) {
        $request = [];
        $request['q'] = $qry ?? session('search.' . $sid . '.query');
        $this->request = $request;
        $this->ssid = $sid;
        $this->qry = $qry;
        $this->model = $model;
        $this->order = $order;

        return $this;
    }

    public function searchFields($fields) {
        $this->sFields = $fields;

        return $this;
    }

    public function orderByFields($fields) {
        $this->obFields = $fields;

        return $this;
    }

    public function paginate($per_page = false) {
        $mod = $this->model::
        searchInit($this->request, $this->ssid, $this->order)
            ->searchFields($this->sFields)
            ->orderByFields($this->obFields)
            ->search($per_page);

        return $mod;
    }

    public function render() {
        $modules = $this->result ?? $this->search($this->sid, NULL, $this->order);

        return view('livewire.module-search', compact('modules'));
    }


}
