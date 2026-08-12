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
public function getAllByUser($userId): array
{
    $stmt = $this->db->prepare(
        "SELECT * FROM tasks
         WHERE user_id = :user_id
         ORDER BY id DESC"
    );

    $stmt->execute([
        'user_id' => $userId
    ]);

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function getById($id, $userId): ?array
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

    return $task ?: null;
}

public function update($id, $userId, $title, $description, $status): bool
{
    try {
        $stmt = $this->db->prepare(
            "UPDATE tasks
             SET title = :title,
                 description = :description,
                 status = :status
             WHERE id = :id
             AND user_id = :user_id"
        );

        $stmt->execute([
            'title' => $title,
            'description' => $description,
            'status' => $status,
            'id' => $id,
            'user_id' => $userId
        ]);

        return $stmt->rowCount() > 0;

    } catch (PDOException $e) {
        return false;
    }
}

public function delete($id, $userId): bool
{
    try {
        $stmt = $this->db->prepare(
            "DELETE FROM tasks
             WHERE id = :id
             AND user_id = :user_id"
        );

        $stmt->execute([
            'id' => $id,
            'user_id' => $userId
        ]);

        return $stmt->rowCount() > 0;

    } catch (PDOException $e) {
        return false;
    }
}
}