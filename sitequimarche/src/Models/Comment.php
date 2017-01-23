<?php

namespace DUT\Models;

class Comment
{
    protected $id;
    protected $id_article;
    protected $pseudo;
    protected $texte_com;
    protected $date;

    public function __construct($id_article, $pseudo, $texte_com, $date){
        $this->id_article = $id_article;
        $this->pseudo = $pseudo;
        $this->texte_com = $texte_com;
        $this->date = $date;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getId_article()
    {
        return $this->id_article;
    }

    public function getPseudo()
    {
        return $this->pseudo;
    }

    public function getTexteCom()
    {
        return $this->texte_com;
    }

    public function getDate()
    {
        return $this->date;
    }
}