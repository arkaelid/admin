<?php
namespace Model;

class Category extends Db {
    public function getAllCategories() {
        $sql = "SELECT * FROM categorie ORDER BY id_categorie";
        return $this->query($sql)->fetchAll();
    }

    public function getCategoryById($id) {
        $sql = "SELECT * FROM categorie WHERE id_categorie = :id";
        return $this->query($sql, [':id' => $id])->fetch();
    }

    public function addCategory($libelle) {
        $sql = "INSERT INTO categorie (libelle_categorie) VALUES (:libelle)";
        return $this->query($sql, [':libelle' => $libelle]);
    }

    public function updateCategory($id, $libelle) {
        $sql = "UPDATE categorie SET libelle_categorie = :libelle WHERE id_categorie = :id";
        return $this->query($sql, [
            ':id' => $id,
            ':libelle' => $libelle
        ]);
    }

    public function deleteCategory($id) {
        try {
            // Supprimer d'abord les références dans posseder_2
            $sql1 = "DELETE FROM posseder_2 WHERE id_categorie = :id";
            $this->query($sql1, [':id' => $id]);
            
            // Supprimer les références dans preferer_2
            $sql2 = "DELETE FROM preferer_2 WHERE id_categorie = :id";
            $this->query($sql2, [':id' => $id]);
            
            // Enfin, supprimer la catégorie
            $sql3 = "DELETE FROM categorie WHERE id_categorie = :id";
            return $this->query($sql3, [':id' => $id]);
            
        } catch (\PDOException $e) {
            error_log("Erreur PDO lors de la suppression: " . $e->getMessage());
            throw $e;
        }
    }

    public function getTotalCategorycount()
    {
        $sql = "SELECT COUNT(*) as count FROM categorie";
        $result = $this->query($sql)->fetch();
        return $result['count'];
    }
}