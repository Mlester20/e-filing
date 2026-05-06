<?php
require_once __DIR__ . '/../BaseModel.php';

class StudentRecordsModel extends BaseModel {
    protected $table = 'graduate_students';

    /* ── READ ALL ──────────────────────────────────────────── */
    public function index() {
        try {
            $stmt = $this->con->prepare(
                "SELECT * FROM {$this->table} ORDER BY created_at DESC"
            );
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    /* ── GET PAGINATED RECORDS ─────────────────────────────── */
    public function getPaginated($page = 1, $limit = 10) {
        try {
            $offset = ($page - 1) * $limit;
            $stmt = $this->con->prepare(
                "SELECT * FROM {$this->table} ORDER BY created_at DESC LIMIT ? OFFSET ?"
            );
            $stmt->bind_param('ii', $limit, $offset);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    /* ── GET TOTAL COUNT ──────────────────────────────────── */
    public function getTotalCount() {
        try {
            $stmt = $this->con->prepare(
                "SELECT COUNT(*) as count FROM {$this->table}"
            );
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();
            return $result['count'] ?? 0;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return 0;
        }
    }

    /* ── GET BY ID ─────────────────────────────────────────── */
    public function getById($id) {
        try {
            $stmt = $this->con->prepare(
                "SELECT * FROM {$this->table} WHERE id = ?"
            );
            $stmt->bind_param('i', $id);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
        } catch (Exception $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    /* ── CREATE ────────────────────────────────────────────── */
    public function create($data) {
        try {
            $stmt = $this->con->prepare("
                INSERT INTO {$this->table}
                    (student_no, first_name, middle_name, last_name, suffix,
                     sex, year_section, academic_year, graduated_date,
                     diploma_no, form137_no, remarks, created_at, updated_at)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
            ");

            $stmt->bind_param(
                'ssssssssssss',
                $data['student_no'],
                $data['first_name'],
                $data['middle_name'],
                $data['last_name'],
                $data['suffix'],
                $data['sex'],
                $data['year_section'],
                $data['academic_year'],
                $data['graduated_date'],
                $data['diploma_no'],
                $data['form137_no'],
                $data['remarks']
            );

            $stmt->execute();
            return $stmt->affected_rows > 0;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    /* ── UPDATE ────────────────────────────────────────────── */
    public function update($id, $data) {
        try {
            $stmt = $this->con->prepare("
                UPDATE {$this->table}
                SET student_no      = ?,
                    first_name      = ?,
                    middle_name     = ?,
                    last_name       = ?,
                    suffix          = ?,
                    sex             = ?,
                    year_section    = ?,
                    academic_year   = ?,
                    graduated_date  = ?,
                    diploma_no      = ?,
                    form137_no      = ?,
                    remarks         = ?,
                    updated_at      = NOW()
                WHERE id = ?
            ");

            $stmt->bind_param(
                'ssssssssssssi',
                $data['student_no'],
                $data['first_name'],
                $data['middle_name'],
                $data['last_name'],
                $data['suffix'],
                $data['sex'],
                $data['year_section'],
                $data['academic_year'],
                $data['graduated_date'],
                $data['diploma_no'],
                $data['form137_no'],
                $data['remarks'],
                $id
            );

            $stmt->execute();
            return $stmt->affected_rows > 0;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    /* ── DELETE ────────────────────────────────────────────── */
    public function delete($id) {
        try {
            $stmt = $this->con->prepare(
                "DELETE FROM {$this->table} WHERE id = ?"
            );
            $stmt->bind_param('i', $id);
            $stmt->execute();
            return $stmt->affected_rows > 0;
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}
?>