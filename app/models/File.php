<?php

class File
{
    private $conn;
    private $table = 'files';

    private $id;
    private $name;
    private $path;
    private $file_type;
    private $created_at;


    public function __construct($name = null, $path = null, $file_type = null)
    {
        $this->name = $name;
        $this->path = $path;
        $this->file_type = $file_type;
    }
    // Getters
    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getFileType()
    {
        return $this->file_type;
    }

    // Setters
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
    public function setPath($path)
    {
        $this->path = $path;
    }
    public function setFileType($file_type)
    {
        $this->file_type = $file_type;
    }

    public function upload($courseId, $file ,$content = false)
    {
        $this->conn = Database::getInstance();

        // If it's a Markdown document, handle it separately
        if ($content) {
            return $this->uploadMarkdown($courseId, $file);
        }
        $uploadDir = "uploads/courses/$courseId/";
        // Create directory if it doesn't exist
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }


        // Get the file extension
        $fileName = basename($file['name']);
        $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));  // Get the extension

        // Determine the file type, sanitize it to remove slash ("/")
        $fileType = $this->getFileTypeFor($file['type']);
        $sanitizedFileType = str_replace('/', '_', $fileType); // Replace slash with underscore

        // Generate a unique file name
        $newFileName = $sanitizedFileType . '_' . uniqid($courseId . '_') . '.' . $extension; // Unique name based on file type and course ID
        $newFilePath = $uploadDir . $newFileName; // Full file path

        if (move_uploaded_file($file['tmp_name'], $newFilePath)) {


            $fileId = $this->saveMetadata($courseId, $newFileName, $newFilePath, $fileType);

            if ($fileId) {

                return $fileId;
            }
        }

        return false;
    }


    private function uploadMarkdown($courseId, $file)
    {

        $markdownContent = $file['document'];


        $markdownFileName = "document_{$courseId}_" . uniqid() . ".md";
        $uploadDir = "uploads/courses/$courseId/";

        // Create directory if it doesn't exist
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }


        $markdownFilePath = $uploadDir . $markdownFileName;


        if (file_put_contents($markdownFilePath, $markdownContent)) {
            // Save the metadata for the Markdown file
            $fileType = 'markdown';
            $this->saveMetadata($courseId, $markdownFileName, $markdownFilePath, $fileType);

            return true;
        }

        return false;
    }

    // Get file type based on MIME type
    private function getFileTypeFor($mimeType)
    {
        if (strpos($mimeType, 'image') !== false) {
            return 'photo';
        } elseif (strpos($mimeType, 'video') !== false) {
            return 'video';
        } elseif ($mimeType === 'text/markdown' || $mimeType === 'text/x-markdown') {
            return 'markdown';
        } else {
            return 'other';
        }
    }


    private function saveMetadata($courseId, $fileName, $filePath, $fileType)
    {
        // Get file type ID
        $this->conn = Database::getInstance();
        $query = "SELECT id FROM file_types WHERE name = :fileType";
        $params = [':fileType' => $fileType];
        $fileTypeId = $this->conn->query($query, $params)->fetchColumn();

        if ($fileTypeId) {
            // Insert file metadata
            $query = "INSERT INTO $this->table (name, path, file_type_id) VALUES (:name, :path, :file_type_id)";
            $params = [
                ':name' => $fileName,
                ':path' => $filePath,
                ':file_type_id' => $fileTypeId
            ];
            $this->conn->query($query, $params);

            // Link file to course
            $fileId = $this->conn->lastInsertId();
            $query = "INSERT INTO course_files (course_id, file_id) VALUES (:course_id, :file_id)";
            $params = [
                ':course_id' => $courseId,
                ':file_id' => $fileId
            ];
            $this->conn->query($query, $params);

            return $fileId;
        }

        return false;
    }

    // Delete a file
    public function delete($fileId)
    {
        $this->conn = Database::getInstance();


        $query = "SELECT path FROM $this->table WHERE id = :id";
        $params = [':id' => $fileId];
        $filePath = $this->conn->query($query, $params)->fetchColumn();

        if ($filePath && file_exists($filePath)) {

            unlink($filePath);

            $query = "DELETE FROM $this->table WHERE id = :id";
            $params = [':id' => $fileId];
            $this->conn->query($query, $params);

            return true;
        }

        return false;
    }

    // Get all files for a course
    public function getByCourseId($courseId)
    {
        $this->conn = Database::getInstance();
        $query = "SELECT f.name, f.path, ft.name AS file_type 
                  FROM $this->table f 
                  JOIN file_types ft ON f.file_type_id = ft.id 
                  JOIN course_files cf ON f.id = cf.file_id 
                  WHERE cf.course_id = :course_id and ft.name != 'photo' ";
        $params = [':course_id' => $courseId];

        $result = $this->conn->query($query, $params)->fetch();
        if($result){
            $this->setPath($result['path']);
            $this->setName($result['name']);
            $this->setFileType($result['file_type']);
            return true ;
        }
        return false ;
    }
}
