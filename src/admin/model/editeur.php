<?php
namespace Model;

class editeur extends Db{
    public function getEditeurProfiles($userId = null)
    {
        $sql = "SELECT * FROM editeur";
        $params = [];
        
        if ($userId) {
            $sql .= " WHERE id_editeur = :editId";
            $params[':editId'] = $userId;
        }
        
        return $this->query($sql, $params)->fetchAll();
    }

    public function updateEditeur($userId, $data)
    {
        $sql = "UPDATE editeur SET ";
        $params = [];

        if (isset($data['nom_societe'])) {
            $sql .= "nom_societe = :nom_societe, ";
            $params[':nom_societe'] = $data['nom_societe'];
        }
        if (isset($data['mail_editeur'])) {
            $sql .= "mail_editeur = :mail_edit, ";
            $params[':mail_edit'] = $data['mail_editeur'];
        }
        if (isset($data['adresse_editeur'])) {
            $sql .= "adresse_editeur = :adresse_editeur, ";
            $params[':adresse_editeur'] = $data['adresse_editeur'];
        }
        if (isset($data['chemin_img_editeur'])) {
            $sql .= "chemin_img_editeur = :chemin_img_editeur, ";
            $params[':chemin_img_editeur'] = $data['chemin_img_editeur'];
        }
        if (isset($data['siret'])) {
            $sql .= "siret = :siret, ";
            $params[':siret'] = $data['siret'];
        }

        $sql = rtrim($sql, ", "); // Enlever la dernière virgule
        $sql .= " WHERE id_editeur = :editId";
        $params[':editId'] = $userId;

        return $this->query($sql, $params);
    }

    

    public function getUserById($userId)
    {
        $sql = "SELECT * FROM utilisateur WHERE id_utilisateur = :userId";
        $result = $this->query($sql, [':userId' => $userId])->fetch();
        return $result ?: null;
    }

    

    public function getTotalEditeurCount()
    {
        $sql = "SELECT COUNT(*) as count FROM editeur";
        $result = $this->query($sql)->fetch();
        return $result['count'];
    }

    public function addEditeur($data)
    {
        $sql = "INSERT INTO editeur (nom_societe, mail_editeur, adresse_editeur, siret, chemin_img_editeur) 
                VALUES (:nom_societe, :mail_editeur, :adresse_editeur, :siret, :chemin_img_editeur)";
        
        $params = [
            ':nom_societe' => $data['nom_societe'],
            ':mail_editeur' => $data['mail_editeur'],
            ':adresse_editeur' => $data['adresse_editeur'],
            ':siret' => $data['siret'],
            ':chemin_img_editeur' => $data['chemin_img_editeur']
        ];
    
        return $this->query($sql, $params);
    }
    public function deleteEditeur($editeurId)
    {
        $sql = "DELETE FROM editeur WHERE id_editeur = :id";
        $params = [':id' => $editeurId];
        
        return $this->query($sql, $params);
    }
}
