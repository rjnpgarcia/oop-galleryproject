<?php

class Pagination
{
    // Properties
    public $currentPage;
    public $itemsPerPage;
    public $itemsTotalCount;

    public function __construct($page = 1, $itemsPerPage = 4, $itemsTotalCount = 0)
    {
        $this->currentPage = (int)$page;
        $this->itemsPerPage = (int)$itemsPerPage;
        $this->itemsTotalCount = (int)$itemsTotalCount;
    }

    // Next page method
    public function nextPage()
    {
        return $this->currentPage + 1;
    }

    // Previous Page method
    public function previousPage()
    {
        return $this->currentPage - 1;
    }

    // Page Total Counter
    public function pageTotal()
    {
        return ceil($this->itemsTotalCount / $this->itemsPerPage);
    }

    // Detect if need NEXT
    public function hasNext()
    {
        return $this->nextPage() <= $this->pageTotal() ? true : false;
    }

    // Detect if need PREVIOUS
    public function hasPrevious()
    {
        return $this->previousPage() >= 1 ? true : false;
    }

    // Offset page value
    public function offset()
    {
        return ($this->currentPage - 1) * $this->itemsPerPage;
    }

    // Pagination Query
    public function findPhotosPaginate()
    {
        $limitCount = $this->itemsPerPage;
        $offsetNum = $this->offset();
        $sql = "SELECT * FROM photos LIMIT $offsetNum, $limitCount";
        return Photo::findThisQuery($sql);
    }
} // End of Pagination Class
