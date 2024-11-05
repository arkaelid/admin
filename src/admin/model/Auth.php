<?php
namespace Model;

class Auth extends Db
{
    
    public function createUser($login, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO admin (login, password) VALUES (:login, :password)";
        $this->query($sql, [':login' => $login, ':password' => $hashedPassword]);
        return $this->lastInsertId();
    }

    public function getUserByUsername($login)
    {
        try {
            $sql = "SELECT * FROM admin WHERE login = :login";
            $stmt = $this->query($sql, [':login' => $login]);
            $result = $stmt->fetch();
            error_log("Utilisateur trouvé dans la BDD : " . ($result ? 'oui' : 'non'));
            return $result;
        } catch (\PDOException $e) {
            error_log("Erreur de connexion à la BDD : " . $e->getMessage());
            return false;
        }
    }

    public function verifyPassword($password, $hashedPassword)
    {
        return password_verify($password, $hashedPassword);
    }

    public function getUserProfiles($userId)
    {
        $sql = "SELECT p.* FROM profile p 
                JOIN user_profile up ON p.id = up.profile_id 
                WHERE up.user_id = :userId";
        return $this->query($sql, [':userId' => $userId])->fetchAll();
    }

    public function getUserPermissions($userId)
    {
        $sql = "SELECT DISTINCT perm.* FROM permission perm 
                JOIN profile_permission pp ON perm.id = pp.permission_id 
                JOIN user_profile up ON pp.profile_id = up.profile_id 
                WHERE up.user_id = :userId";
        return $this->query($sql, [':userId' => $userId])->fetchAll();
    }

    public function addUserProfile($userId, $profileName)
    {
        // Vérifier si le profil existe déjà
        $profileId = $this->getProfileIdByName($profileName);
        
        // Si le profil n'existe pas, le créer
        if (!$profileId) {
            $profileId = $this->createProfile($profileName);
        }

        // Vérifier si l'association utilisateur-profil existe déjà
        if (!$this->userProfileExists($userId, $profileId)) {
            $sql = "INSERT INTO user_profile (user_id, profile_id) VALUES (:userId, :profileId)";
            $this->query($sql, [':userId' => $userId, ':profileId' => $profileId]);
        }
    }

    private function getProfileIdByName($profileName)
    {
        $sql = "SELECT id FROM profile WHERE name = :name";
        $result = $this->query($sql, [':name' => $profileName])->fetch();
        return $result ? $result['id'] : null;
    }

    private function createProfile($profileName)
    {
        $sql = "INSERT INTO profile (name) VALUES (:name)";
        $this->query($sql, [':name' => $profileName]);
        return $this->lastInsertId();
    }

    private function userProfileExists($userId, $profileId)
    {
        $sql = "SELECT COUNT(*) FROM user_profile WHERE user_id = :userId AND profile_id = :profileId";
        $count = $this->query($sql, [':userId' => $userId, ':profileId' => $profileId])->fetchColumn();
        return $count > 0;
    }

    public function verifyMySQLPassword($password, $hashedPassword)
    {
        $sql = "SELECT PASSWORD(:password) = :hashedPassword AS is_valid";
        $result = $this->query($sql, [
            ':password' => $password,
            ':hashedPassword' => $hashedPassword
        ])->fetch();
        return $result['is_valid'] == 1;
    }
}
