<?php 


enum role : string{
    case User = 'user';
    case Admin = 'admin';
    case Dev = 'dev';
}


class User {
    private int $id;
    private DateTime $created_at;
    private string $first_name;
    private string $last_name;
    private string $email;
    private string $phone_number;
    private role $role;

    public function __construct(int $id, DateTime $created_at, 
    string $first_name, string $last_name, string $email, string $phone_number, role $role  )
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
    public function getCreatedAt() : DateTime{
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
    
    public function getRole(): role{
        return $this->role;
    }


    public static function getUserFromId(int $id, PDO $pdo): User{
        try{
            $sql = $pdo->prepare("SELECT * FROM user WHERE id = :id");
            $sql->bindParam(':id', $id);
            $sql->execute();

            $userData = $sql->fetch(PDO::FETCH_ASSOC);
            if($userData === false){
                throw new Exception("User with ID {$id} not found");
            }
            return new User(
                id: (int) $userData['id'],
                created_at : new DateTime($userData['created_at']),
                first_name : $userData['first_name'],
                last_name : $userData['last_name'],
                email : $userData['email'],
                phone_number: $userData['phone_number'],
                role : $userData['role']
            );
        }catch(PDOException $e){
            throw new Exception("Database error : " . $e->getMessage());
        }
    }


}