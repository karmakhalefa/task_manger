<?php


class User extends Model
{
    public function register($username, $email, $password): array
    {
        // 1. التأكد إن username أو email مش مكررين
        $stmt = $this->db->prepare(
            "SELECT id FROM users
             WHERE username = :username OR email = :email"
        );

        $stmt->execute([
            'username' => $username,
            'email' => $email
        ]);

        if ($stmt->fetch()) {
            return [
                'success' => false,
                'message' => 'Username or email already exists'
            ];
        }

        // 2. تشفير الباسورد
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // 3. إضافة المستخدم
        try {
            $stmt = $this->db->prepare(
                "INSERT INTO users (username, email, password)
                 VALUES (:username, :email, :password)"
            );

            $stmt->execute([
                'username' => $username,
                'email' => $email,
                'password' => $passwordHash
            ]);

            return [
                'success' => true,
                'message' => 'User registered successfully'
            ];

        } catch (PDOException $e) {

            return [
                'success' => false,
                'message' => 'Registration failed'
            ];
        }
    }
    
public function login($email, $password): array
{
    $stmt = $this->db->prepare(
        "SELECT * FROM users WHERE email = :email"
    );

    $stmt->execute([
        'email' => $email
    ]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        return [
            'success' => false,
            'message' => 'Invalid email or password'
        ];
    }

    if (!password_verify($password, $user['password'])) {
        return [
            'success' => false,
            'message' => 'Invalid email or password'
        ];
    }

$_SESSION['user_id'] = $user['id'];

    return [
        'success' => true,
        'message' => 'Login successful'
    ];
}
}