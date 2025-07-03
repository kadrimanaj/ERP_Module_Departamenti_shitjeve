<?php

namespace Modules\DepartamentiShitjes\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class CalendarSales extends Component
{
    /**
     * Create a new component instance.
     */
    public $id;
    public $ajaxUrl;
    public $headers;
    public $columns;
    public $modalType;
    public $addModal;
    public $editModal;
    public $addnewTarget;
    public $tableName;
    public $filterNames;
    public $linkTarget;
    public $action;
    public $addDownload;
    public $downloadLink;
    public $notification;
    public $view;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $id = null,
        $ajaxUrl = null,
        $headers = [],
        $columns = [],
        $modalType = null,
        $addModal = null,
        $editModal = null,
        $addnewTarget = null,
        $tableName = null,
        $filterNames = null,
        $linkTarget = null,
        $action = null,
        $addDownload = null,
        $downloadLink = null,
        $notification = false,
        $view = null
    ) {
        $this->id = $id;
        $this->ajaxUrl = $ajaxUrl;
        $this->headers = $headers;
        $this->columns = $columns;
        $this->modalType = $modalType;
        $this->addModal = $addModal;
        $this->editModal = $editModal;
        $this->addnewTarget = $addnewTarget;
        $this->tableName = $tableName;
        $this->filterNames = $filterNames;
        $this->linkTarget = $linkTarget;
        $this->action = $action;
        $this->addDownload = $addDownload;
        $this->downloadLink = $downloadLink;
        $this->notification = $notification;
        $this->view = $view;
    }
    /**
     * Get the view/contents that represent the component.
     */
    public function render(): View|string
    {
        return view('departamentishitjes::components.calendarsales');
    }
}
