<?php
namespace Model;

class User extends Db{
    public function getUserProfiles($userId = null)
    {
        $sql = "SELECT * FROM utilisateur";
        $params = [];
        
        if ($userId) {
            $sql .= " WHERE id_utilisateur = :userId";
            $params[':userId'] = $userId;
        }
        
        return $this->query($sql, $params)->fetchAll();
    }

    public function updateUser($userId, $data)
    {
        $sql = "UPDATE utilisateur SET ";
        $params = [];

        if (isset($data['pseudo'])) {
            $sql .= "pseudo_utilisateur = :pseudo, ";
            $params[':pseudo'] = $data['pseudo'];
        }
        if (isset($data['mail'])) {
            $sql .= "mail = :mail, ";
            $params[':mail'] = $data['mail'];
        }
        if (isset($data['chemin_img_user'])) {
            $sql .= "chemin_img_user = :chemin_img_user, ";
            $params[':chemin_img_user'] = $data['chemin_img_user'];
        }

        $sql = rtrim($sql, ", "); // Enlever la dernière virgule
        $sql .= " WHERE id_utilisateur = :userId";
        $params[':userId'] = $userId;

        return $this->query($sql, $params);
    }

    public function banUser($userId, $data)
    {
        $sql = "INSERT INTO bannis (id_utilisateur, date_debutBan, date_finBan, ban_perma, raison_ban) 
                VALUES (:userId, :dateDebut, :dateFin, :banPerma, :raison)";
        
        $params = [
            ':userId' => $userId,
            ':dateDebut' => $data['date_debut'],
            ':dateFin' => $data['date_fin'] ?? null,
            ':banPerma' => $data['ban_perma'] ? 1 : 0,
            ':raison' => $data['raison']
        ];
        
        return $this->query($sql, $params);
    }

    public function getUserById($userId)
    {
        $sql = "SELECT * FROM utilisateur WHERE id_utilisateur = :userId";
        $result = $this->query($sql, [':userId' => $userId])->fetch();
        return $result ?: null;
    }

    public function getBannedUsers()
    {
        $sql = "SELECT u.*, b.date_debutBan, b.date_finBan, b.ban_perma, b.raison_ban
                FROM utilisateur u 
                JOIN bannis b ON u.id_utilisateur = b.id_utilisateur";
        return $this->query($sql)->fetchAll();
    }

    public function unbanUser($userId)
    {
        $sql = "DELETE FROM bannis WHERE id_utilisateur = :userId";
        return $this->query($sql, [':userId' => $userId]);
    }

    public function getTotalUsersCount()
    {
        $sql = "SELECT COUNT(*) as count FROM utilisateur";
        $result = $this->query($sql)->fetch();
        return $result['count'];
    }

    public function getBannedUsersCount()
    {
        $sql = "SELECT COUNT(*) as count FROM bannis";
        $result = $this->query($sql)->fetch();
        return $result['count'];
    }
    public function unbanExpiredUsers()
{
    // Vérifier et débannir les utilisateurs dont la date de fin de ban est dépassée
    $sql = "DELETE FROM bannis WHERE date_finBan IS NOT NULL AND date_finBan < NOW()";
    return $this->query($sql);
}
}
