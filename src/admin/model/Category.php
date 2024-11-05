<?php
namespace Model;

class Category extends Db {
    public function getAllCategories() {
        $sql = "SELECT * FROM categorie";
        return $this->query($sql)->fetchAll();
    }

    public function addCategory($libelle) {
        $sql = "INSERT INTO categorie (libelle_categorie) VALUES (:libelle)";
        return $this->query($sql, [':libelle' => $libelle]);
    }

    public function updateCategory($id, $libelle) {
        $sql = "UPDATE categorie SET libelle_categorie = :libelle WHERE id_categorie = :id";
        return $this->query($sql, [':libelle' => $libelle, ':id' => $id]);
    }

    public function deleteCategory($id) {
        $sql = "DELETE FROM categorie WHERE id_categorie = :id";
        return $this->query($sql, [':id' => $id]);
        if ($result && $result->rowCount() > 0) {
            return true;  // suppression réussie
        } else {
            return false; // suppression échouée ou rien à supprimer
        }
        
    }
    public function getCategoryById($id) {
        $sql = "SELECT * FROM categorie WHERE id_categorie = :id";
        return $this->query($sql, [':id' => $id])->fetch();
    }
}