<?php
    class UserManagement{
        public static function addUser($username,$key,$role,&$conn){
            //comprobar que no exista usuario con ese nombre
            $sql = "SELECT id FROM users WHERE username=? LIMIT 1";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s",$username);
            $stmt->execute();
            $rs = $stmt->get_result();
            if($rs && $rs->num_rows > 0){
                return false;
            }
            //ingresar los datos a la base de datos
            $sql = "INSERT INTO users (username, user_key, id_role) VALUES (?,?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssi",$username,$key,$role);
            if(!$stmt->execute()){
                $stmt->close();
                return false;
            }
            $stmt->close();
            return true;
        }

        public static function updateUser($newRoleId,$userId,&$conn){
            $sql = "UPDATE users SET id_role = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii",$newRoleId,$userId);
            if(!$stmt->execute()){
                return false;
            }
            return true;
        }

        public static function deleteUser($userId,&$conn){
            $sql = "DELETE FROM users WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i",$userId);
            if(!$stmt->execute()){
                return false;
            }
            return true;
        }

        public static function checkActive($sessionID,&$conn){
            $id = $sessionID;
            $sql = "SELECT * FROM users WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i",$id);
            $stmt->execute();

            $rs = $stmt->get_result();
            $row = $rs->fetch_all(MYSQLI_ASSOC);
            $stmt->close();

            //comprobar si el usuario fue eliminado
            if($rs && $rs->num_rows === 0){
                unset($_SESSION['access']);
                return false;
            //comprobar si el usuario cambio de rol
            }else if(isset($_SESSION['id_role'])){
                if($rs && $row[0]['id_role'] != $_SESSION['id_role']){
                    $_SESSION['id_role'] = $row[0]['id_role'];
                    return false;
                }
            }       
            return true;
        }
    }
?>