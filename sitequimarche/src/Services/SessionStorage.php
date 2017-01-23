<?php

namespace DUT\Services;

session_start();

class SessionStorage
{
    public function __construct()
    {
        if (!isset($_SESSION['collection'])) {
            $_SESSION['collection'] = [];
        }
        if (!isset($_SESSION['admin'])) {
            $_SESSION['admin'] = 0;
        }
    }

    public function setAdmin($element){
        $_SESSION['admin'] = $element;
        return $this;
    }

    /**
     * @param mixed $element
     * @return SessionStorage
     */
    public function addElement($element){
        $_SESSION['collection'][] = $element;
        return $this;
    }

    /**
     * @return []
     */
    public function getElements()
    {
        return $_SESSION['collection'];
    }

    /**
     * @param int $index
     * @return [];
     */
    public function removeElement($index)
    {
        if (isset($_SESSION['collection'][$index])) {
            unset($_SESSION['collection'][$index]);
        }

        return $_SESSION['collection'];
    }
}
