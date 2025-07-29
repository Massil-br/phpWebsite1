<?php 

class UserRole{
    public static string $user = 'user';
    public static string $admin = 'admin';
    public static string $dev = 'dev';
}



class User {
    private int $id;
    private string $created_at;
    private string $first_name;
    private string $last_name;
    private string $email;
    private string $phone_number;
    private string $role;

    public function __construct(int $id, string $created_at, 
    string $first_name, string $last_name, string $email, string $phone_number, string $role  )
    {
        $this->id = $id;
        $this->created_at = $created_at;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->email = $email;
        $this->phone_number = $phone_number;
        $this->role = $role;
    }


    public function getId():int{
        return $this->id;
    }
    public function getCreatedAt() : string{
        return $this->created_at;
    }

    public function getFirstName(): string{
        return $this->first_name;
    }

    public function getLastName(): string {
        return $this->last_name;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getPhoneNumber(): string{
        return $this->phone_number;
    }
    
    public function getRole(): string{
        return $this->role;
    }


    public static function CheckIfEmailExist(Database $db, string $email): bool {
        $query = "SELECT 1 FROM user WHERE email = :email LIMIT 1";
        $params = [':email' => $email];
        $result = $db->executeQuery($query, $params);
        
        return !empty($result);
    }

    public static function CreateUser(Database $db,string $first_name, string $last_name, string $email , string $password, string $phone_number ): void{
        $query = "INSERT into user (first_name,last_name,email, password, phone_number) values (:first_name,:last_name,:email,:password,:phone_number)";
        $params =[
            ':first_name'=>$first_name,
            ':last_name'=>$last_name,
            ':email'=>$email,
            ':password'=>$password,
            ':phone_number'=>$phone_number
        ];

        $db->executeQuery($query,$params);
    }

    public static function GetPasswordHashByEmail(Database $db, string $email):string{
        $query = "SELECT password from user where email = :email";
        $params = [':email'=>$email];

        $result = $db->executeQuery($query,$params);
        return $result[0]['password'];
    }

    public static function GetUserByEmail(Database $db, string $email):User{
        $query = "SELECT * from user where email = :email";
        $params = [':email'=>$email];

        $results = $db->executeQuery($query, $params);
        $row = $results[0];
        $user = new User($row['id'],$row['created_at'],$row['first_name'], $row['last_name'], $row['email'], $row['phone_number'], $row['role']);
        
        return $user;
    }
    public static function GetUserByID(Database $db, int $id):User{
        $query = "SELECT * FROM user where id = :id";
        $params = [':id'=>$id];
        $results = $db->executeQuery($query,$params);
        if(empty($results)){
            throw new ErrorException("no user found");
        }
        $row = $results[0];
        $user = new User($row['id'], $row['created_at'], $row['first_name'], $row['last_name'], $row['email'], $row['phone_number'], $row['role']);
        return $user;
    }
    public static function GetUserRoleByID(Database $db, int $id):string{
        $query = "SELECT role FROM user where id = :id";
        $params =[':id'=>$id];
        $results = $db->executeQuery($query,$params);
        if(empty($results)){
            throw new ErrorException("no user found");
        }
        $role = $results[0]['role'];
        return $role;        
    }


}