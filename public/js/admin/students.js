// Load students data from the embedded JSON
const studentsDataArray = JSON.parse(document.getElementById('studentsData').textContent);
const studentsData = {};

studentsDataArray.forEach(student => {
    studentsData[student.id] = student;
});

// Initialize event listeners when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    initializeEditButtons();
    initializeViewButtons();
    initializeDeleteButtons();
});

/**
 * Initialize Edit button functionality
 */
function initializeEditButtons() {
    document.querySelectorAll('.edit-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const studentId = this.getAttribute('data-student-id');
            const student = studentsData[studentId];
            
            if (student) {
                populateEditForm(student);
                const modal = new bootstrap.Modal(document.getElementById('editGraduateModal'));
                modal.show();
            }
        });
    });
}

/**
 * Initialize View button functionality
 */
function initializeViewButtons() {
    document.querySelectorAll('.view-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const studentId = this.getAttribute('data-student-id');
            const student = studentsData[studentId];
            
            if (student) {
                populateViewModal(student);
                const modal = new bootstrap.Modal(document.getElementById('viewGraduateModal'));
                modal.show();
            }
        });
    });
}

/**
 * Initialize Delete button functionality
 */
function initializeDeleteButtons() {
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const studentId = this.getAttribute('data-student-id');
            document.getElementById('delete_student_id').value = studentId;
            const modal = new bootstrap.Modal(document.getElementById('deleteGraduateModal'));
            modal.show();
        });
    });
}

/**
 * Populate the edit form with student data
 * @param {Object} student - Student data object
 */
function populateEditForm(student) {
    document.getElementById('edit_student_id').value = student.id;
    document.getElementById('edit_student_no').value = student.student_no;
    document.getElementById('edit_first_name').value = student.first_name;
    document.getElementById('edit_middle_name').value = student.middle_name || '';
    document.getElementById('edit_last_name').value = student.last_name;
    document.getElementById('edit_suffix').value = student.suffix || '';
    document.getElementById('edit_sex').value = student.sex;
    document.getElementById('edit_year_section').value = student.year_section;
    document.getElementById('edit_academic_year').value = student.academic_year;
    document.getElementById('edit_graduation_date').value = student.graduated_date;
    document.getElementById('edit_diploma_no').value = student.diploma_no || '';
    document.getElementById('edit_form137_no').value = student.form137_no || '';
    document.getElementById('edit_remarks').value = student.remarks || '';
}

/**
 * Populate the view modal with student details
 * @param {Object} student - Student data object
 */
function populateViewModal(student) {
    document.getElementById('view_full_name').textContent = student.full_name;
    document.getElementById('view_student_no').textContent = student.student_no;
    document.getElementById('view_section').textContent = student.year_section;
    document.getElementById('view_academic_year').textContent = student.academic_year;
    document.getElementById('view_sex').textContent = student.sex;
    document.getElementById('view_graduated_date').textContent = formatDate(student.graduated_date);
    document.getElementById('view_diploma_no').textContent = student.diploma_no || 'N/A';
    document.getElementById('view_form137_no').textContent = student.form137_no || 'N/A';
    document.getElementById('view_remarks').textContent = student.remarks || 'N/A';
}

/**
 * Format date to readable format
 * @param {string} dateString - Date string to format
 * @returns {string} Formatted date
 */
function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', { 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric' 
    });
}
