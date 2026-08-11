<?php

class Task extends Model{

    public function create($userId, $title, $description): bool
{
    try {
        $stmt = $this->db->prepare(
            "INSERT INTO tasks (user_id, title, description, status)
             VALUES (:user_id, :title, :description, 'pending')"
        );

        $stmt->execute([
            'user_id' => $userId,
            'title' => $title,
            'description' => $description
        ]);

        return true;

    } catch (PDOException $e) {
        return false;
    }
}
public function getById($id, $userId): array|null
{
    $stmt = $this->db->prepare(
        "SELECT * FROM tasks
         WHERE id = :id
         AND user_id = :user_id"
    );

    $stmt->execute([
        'id' => $id,
        'user_id' => $userId
    ]);

    $task = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$task) {
        return null;
    }

    return $task;
}
}