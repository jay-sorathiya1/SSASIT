

<div class="dashboard-grid">
    <div class="dashboard-card">
        <div class="card-header">

            <div class="card-icon"><i class="fa-light fa-user-graduate fa-sm"></i></div>
            <h3 class="card-title">total student</h3>
        </div>
        <div class="card-content">
            <p>The dashboard provides insights into the total number of students and student related all operation for
                admin</p>
            <div class="card-stats">
                <div class="stat-item">
                    <div class="stat-value"><?php
                    echo getTotal('person', 'Student', '');
                    ?></div>
                    <div class="stat-label">Total Student</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value"><?php
                    echo getTotal('person', 'Student', 'Active');
                    ?></div>
                    <div class="stat-label">Active</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value"><?php
                    echo getTotal('person', 'Student', 'Graduated');
                    ?>
                    </div>
                    <div class="stat-label">Graduate</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value"><?php
                    echo getTotal('person', 'Student', 'Terminated');
                    ?>
                    </div>
                    <div class="stat-label">Terminated</div>
                </div>
            </div>
            <div class="card-actions">
                <button class="action-btn view-btn" onclick="viewAllStudents()">
                    View Students
                </button>
                <button class="action-btn add-btn" onclick="addNewStudent()">
                    Add Student
                </button>
            </div>
        </div>
    </div>

    <div class="dashboard-card">
        <div class="card-header">
            <div class="card-icon"><i class="fa-light fa-chalkboard-user fa-sm"></i></div>
            <h3 class="card-title">total facultys</h3>
        </div>
        <div class="card-content">
            <p>Manage faculty members, their profiles, assignments, and academic responsibilities across all
                departments.</p>
            <div class="card-stats">
                <div class="stat-item">
                    <div class="stat-value"><?php
                    echo getTotal('person', '', '');
                    ?></div>
                    <div class="stat-label">Total Faculty</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value"><?php
                    echo getTotal('person', 'Lab Assistant', 'Active');
                    ?></div>
                    <div class="stat-label">Lab Assistant</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">
                        <?php
                        echo getTotal('person', 'Professor', '');
                        ?>
                    </div>
                    <div class="stat-label">Professors</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">
                        <?php
                        echo getTotal('person', 'Assistant Prof.', '');
                        ?>
                    </div>
                    <div class="stat-label">Assistant Prof.</div>
                </div>
            </div>
            <div class="card-actions">
                <button class="action-btn view-btn" onclick="viewAllFaculty()">
                    View Faculty
                </button>
                <button class="action-btn add-btn" onclick="addNewFaculty()">
                    Add Faculty
                </button>
            </div>
        </div>
    </div>

    <div class="dashboard-card">
        <div class="card-header">
            <div class="card-icon"><i class="fa-regular fa-buildings"></i></div>
            <h3 class="card-title">Total Departments</h3>
        </div>
        <div class="card-content">
            <p>The dashboard provides insights into the total number of Departments and Departments related all
                operation for admin</p>
            <div class="card-stats">
                <div class="stat-item">
                    <div class="stat-value">
                        <?php
                        echo getTotal('department', '', '');
                        ?>
                    </div>
                    <div class="stat-label">Total Departments</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">
                        <?php
                        echo getTotal('department', '', 'Active');
                        ?>
                    </div>
                    <div class="stat-label">Active Departments</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">
                        <?php
                        echo getTotal('person', 'HOD', 'Active');
                        ?>
                    </div>
                    <div class="stat-label">Total HOD's</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">1</div>
                    <div class="stat-label">Active buildings</div>
                </div>
            </div>
            <div class="card-actions">
                <button class="action-btn view-btn" onclick="viewAllDepartments()">
                    View Departments
                </button>
                <button class="action-btn add-btn" onclick="addNewDepartment()">
                    Add Department
                </button>
            </div>
        </div>
    </div>

    <!-- <div class="dashboard-card">
        <div class="card-header">
            <div class="card-icon">🔒</div>
            <h3 class="card-title">overall result</h3>
        </div>
        <div class="card-content">
            <p>View comprehensive academic results, performance analytics, and student achievement statistics across all
                programs.</p>
            <div class="card-stats">
                <div class="stat-item">
                    <div class="stat-value">85%</div>
                    <div class="stat-label">Pass Rate</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">7.2</div>
                    <div class="stat-label">Avg CGPA</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">92%</div>
                    <div class="stat-label">Attendance</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">15</div>
                    <div class="stat-label">Toppers</div>
                </div>
            </div>
            <div class="card-actions">
                <button class="action-btn view-btn" onclick="viewAllResults()">
                    View All Results
                </button>
                <button class="action-btn add-btn" onclick="addNewResult()">
                    Add New Result
                </button>
            </div>
        </div>
    </div>

    <div class="dashboard-card">
        <div class="card-header">
            <div class="card-icon"><i class="fa-regular fa-newspaper"></i></div>
            <h3 class="card-title">total recent news</h3>
        </div>
        <div class="card-content">
            <p>Stay updated with latest institutional news, announcements, events, and important notifications for
                students and faculty.</p>
            <div class="card-stats">
                <div class="stat-item">
                    <div class="stat-value">12</div>
                    <div class="stat-label">Recent News</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">5</div>
                    <div class="stat-label">Announcements</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">8</div>
                    <div class="stat-label">Events</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">3</div>
                    <div class="stat-label">Urgent Notices</div>
                </div>
            </div>
            <div class="card-actions">
                <button class="action-btn view-btn" onclick="viewAllNews()">
                    View All News
                </button>
                <button class="action-btn add-btn" onclick="addNewNews()">
                    Add New News
                </button>
            </div>
        </div>
    </div>

    <div class="dashboard-card">
        <div class="card-header">
            <div class="card-icon"><i class="fa-regular fa-file-lines"></i></div>
            <h3 class="card-title">exam related</h3>
        </div>
        <div class="card-content">
            <p>Manage examination schedules, results, hall tickets, and all exam-related administrative tasks and
                student queries.</p>
            <div class="card-stats">
                <div class="stat-item">
                    <div class="stat-value">6</div>
                    <div class="stat-label">Upcoming Exams</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">4</div>
                    <div class="stat-label">Results Pending</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">150</div>
                    <div class="stat-label">Hall Tickets</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">2</div>
                    <div class="stat-label">Exam Halls</div>
                </div>
            </div>
            <div class="card-actions">
                <button class="action-btn view-btn" onclick="viewAllExams()">
                    View All Exams
                </button>
                <button class="action-btn add-btn" onclick="addNewExam()">
                    Add New Exam
                </button>
            </div>
        </div>
    </div> -->
</div>

<script>

    const dashboardCards = document.querySelectorAll('.dashboard-card');
    dashboardCards.forEach(card => {
        card.addEventListener('mouseenter', function () {
            this.style.transform = 'translateY(-5px) scale(1.02)';
        });

        card.addEventListener('mouseleave', function () {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Student Functions
    function viewAllStudents() {
        window.location.href = 'Entities_Record?type=student';
        // showSuccessMessage('View All Students functionality will be implemented soon!');
    }

    function addNewStudent() {
        window.location.href = 'entities?type=student';
        // showSuccessMessage('Add New Student functionality will be implemented soon!');
    }

    // Faculty Functions
    function viewAllFaculty() {
        window.location.href = 'Entities_Record?type=faculty';

        // showSuccessMessage('View All Faculty functionality will be implemented soon!');
        // console.log('View All Faculty clicked');
    }

    function addNewFaculty() {
        window.location.href = 'entities?type=faculty';
        // showSuccessMessage('Add New Faculty functionality will be implemented soon!');
        console.log('Add New Faculty clicked');
    }

    // Department Functions
    function viewAllDepartments() {
        window.location.href = 'View_Departments';
        console.log('View All Departments clicked');
    }

    function addNewDepartment() {
        window.location.href = 'entities?type=department';
        console.log('Add New Department clicked');
    }

    // Result Functions
    function viewAllResults() {
        showSuccessMessage('View All Results functionality will be implemented soon!');
        console.log('View All Results clicked');
    }

    function addNewResult() {
        showSuccessMessage('Add New Result functionality will be implemented soon!');
        console.log('Add New Result clicked');
    }

    // News Functions
    function viewAllNews() {
        showSuccessMessage('View All News functionality will be implemented soon!');
        console.log('View All News clicked');
    }

    function addNewNews() {
        showSuccessMessage('Add New News functionality will be implemented soon!');
        console.log('Add New News clicked');
    }

    // Exam Functions
    function viewAllExams() {
        showSuccessMessage('View All Exams functionality will be implemented soon!');
        console.log('View All Exams clicked');
    }

    function addNewExam() {
        showSuccessMessage('Add New Exam functionality will be implemented soon!');
        console.log('Add New Exam clicked');
    }

</script>