<?php
class TaskEntity {

    public int $id;
    public string $title;
    public string $description;
    public bool $completed;
    public string $createdAt;
    public string $updatedAt;
    public ?string $completedAt;

    public function setId(int $id) {$this -> id = $id; return $this;}
    public function getId() {return $this -> id ?? null;}

    public function setTitle(string $title) {$this -> title = $title; return $this;}
    public function getTitle() {return $this -> title ?? null;}

    public function setDescription(string $description) {$this -> description = $description; return $this;}
    public function getDescription() {return $this -> description ?? null;}

    public function setCompleted(bool $completed) {$this -> completed = $completed; return $this;}
    public function isCompleted() {return $this -> completed ?? null;}

    public function setCreatedAt(string $createdAt) {$this -> createdAt = $createdAt; return $this;}
    public function getCreatedAt() {return $this -> createdAt ?? null;}

    public function setUpdatedAt(string $updatedAt) {$this -> updatedAt = $updatedAt; return $this;}
    public function getUpdatedAt() {return $this -> updatedAt ?? null;}

    public function setCompletedAt(?string $completedAt) {$this -> completedAt = $completedAt; return $this;}
    public function getCompletedAt() {return $this -> completedAt ?? null;}


}