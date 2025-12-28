<?php
require 'DB/connection.php';
require 'Doe/ViewAll-Query.php';

$department = viewAll($conn, 'department');
$faculty = viewAll($conn, '');
$dept = [];
$fac = [];
while ($result = $department->fetch_assoc()) {
    $dept[] = $result;
}
while ($result = $faculty->fetch_assoc()) {
    $fac[] = $result;
}
?>


<div class="container">
    <div class="form-header">
        <h1>Add New <?php echo $entity_type; ?></h1>
        <p>Fill in the <?php echo $entity_type; ?> details below</p>
    </div>

    <form class="student-form" action="Insert?type=<?php echo $entity_type; ?>" id="studentForm" novalidate
        enctype='multipart/form-data' method="post">
        <!-- Personal Information Section -->
        <!-- Insert?type=<?php echo $entity_type; ?> -->
        <?php if ($entity_type == 'student' || $entity_type == 'faculty') { ?>
            <div class="form-section">
                <h2 class="section-title">Personal Information</h2>

                <div class="form-row">
                    <div class="form-group">
                        <label for="firstName">First Name *</label>
                        <input type="text" id="firstName" name="firstName" required pattern="[A-Za-z]{2,30}"
                            title="First name should contain only letters (2-30 characters)" class="input-fields">
                        <span class="error-message"></span>
                    </div>

                    <div class="form-group">
                        <label for="lastName">Last Name *</label>
                        <input type="text" id="lastName" name="lastName" required pattern="[A-Za-z]{2,30}"
                            title="Last name should contain only letters (2-30 characters)" class="input-fields">
                        <span class="error-message"></span>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="dob">Date of Birth *</label>
                        <input type="date" id="dob" name="dob" min="1990-01-01" max="2010-12-31" required
                            class="input-fields">
                        <span class="error-message"></span>
                    </div>

                    <div class="form-group">
                        <label for="gender">Gender *</label>
                        <select id="gender" name="gender" required>
                            <option value="">Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                        <span class="error-message"></span>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group full-width">
                        <label for="address">Address *</label>
                        <textarea id="address" name="address" pattern=".{10,200}"
                            title="Address should be 10-200 characters long" placeholder="Enter complete address"
                            required></textarea>
                        <span class="error-message"></span>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="city">City *</label>
                        <select id="city" name="city" required>
                            <option value="" selected>Select City</option>
                            <!-- <input type="text" id="city" name="city"  placeholder="Search"> -->
                        </select>
                        <span class="error-message"></span>
                    </div>

                    <div class="form-group">
                        <label for="mobile">Mobile Number *</label>
                        <input type="tel" id="mobile" name="mobile" pattern="[6-9][0-9]{9}"
                            title="Mobile number should be 10 digits starting with 6-9"
                            placeholder="Enter 10-digit mobile number" required class="input-fields">
                        <span class="error-message"></span>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="email">Email Address *</label>
                        <input type="email" id="email" name="email" title="Please enter a valid email address"
                            placeholder="abc@example.com" required class="input-fields">
                        <span class="error-message"></span>
                    </div>

                    <div class="form-group">
                        <label for="photo"><?php echo $entity_type; ?> Photo</label>
                        <input type="file" id="avatar" name="avatar" accept="image/jpeg,image/jpg,image/png"
                            title="Please select a JPG or PNG image" class="input-fields">
                        <span class="error-message"></span>
                    </div>
                </div>
            </div>

            <!-- Academic Information Section -->
            <div class="form-section">
                <h2 class="section-title">Academic Information</h2>

                <div class="form-row">
                    <div class="form-group">
                        <label for="qualification">Qualification *</label>
                        <select id="qualification" name="qualification" required>
                            <option value="">Select Qualification</option>

                            <?php if ($entity_type == 'faculty'): ?>

                                <option value="Bachelor s Degree">Bachelor's Degree</option>
                                <option value="Master s Degree">Master's Degree</option>
                                <option value="Ph.D.">Ph.D.</option>
                                <option value="Post Doctorate">Post Doctorate</option>

                            <?php else: ?>

                                <option value="10th">10th Pass</option>
                                <option value="12th">12th Pass</option>
                                <option value="Diploma">Diploma</option>
                                <option value="Under Graduate">Under Graduate</option>

                            <?php endif; ?>
                        </select>
                        <span class="error-message"></span>
                    </div>

                    <div class="form-group">
                        <label for="department">Department *</label>
                        <select id="department" name="department" required>
                            <option value="">Select Department</option>
                            <?php foreach ($dept as $key => $value) { ?>
                                <option value="<?php echo $value['Dept_ID']; ?>"><?php echo $value['Dept_Name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                        <span class="error-message"></span>
                    </div>
                </div>

                <?php if ($entity_type == 'faculty'): ?>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="designation">Designation *</label>
                            <select id="designation" name="designation" required>
                                <option value="">Select Designation</option>
                                <option value="Professor">Professor</option>
                                <option value="Assistant Prof.">Assistant Professor</option>
                                <option value="Lab Assistant">Lab Assistant</option>
                                <option value="HOD">Head of Department</option>
                                <option value="Dean">Dean</option>
                                <option value="Principal">Principal</option>
                            </select>
                            <span class="error-message"></span>
                        </div>

                        <div class="form-group">
                            <label for="experience">Experience (Years)</label>
                            <input type="number" id="experience" name="experience" min="0" max="50"
                                placeholder="Years of experience" class="input-fields">
                            <span class="error-message"></span>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="form-row">
                    <div class="form-group">
                        <label
                            for="admissionDate"><?php ($entity_type == 'faculty') ? print ('Joining') : print ('Admission'); ?>
                            Date *</label>
                        <input type="date" id="admissionDate" name="admissionDate" required min=<?php ($entity_type == 'faculty') ? print ("2010-01-01") : print ("2020-01-01"); ?> max="2030-12-31"
                            class="input-fields">
                        <span class="error-message"></span>
                    </div>

                    <div class="form-group">
                        <label for="status">Status *</label>
                        <select id="status" name="status" required>
                            <option value="">Select Status</option>
                            <option value="Active">Active</option>
                            <option value="Terminated">Terminated</option>
                            <?php if ($entity_type == 'faculty'): ?>
                                <option value="Resigned">Resigned</option>
                            <?php else: ?>
                                <option value="Inactive">Inactive</option>
                                <option value="Detained">Detained</option>
                                <option value="Graduated">Graduated</option>
                                <option value="Under Graduation">Under Graduation</option>
                                <option value="Post Graduation">Post Graduation</option>
                            <?php endif; ?>
                        </select>
                        <span class="error-message"></span>
                    </div>
                </div>
            </div>
        <?php } ?>
        <?php if ($entity_type == 'department'): ?>
            <!-- Department Information Section -->
            <div class="form-section">
                <h2 class="section-title">Department Information</h2>

                <div class="form-row">
                    <div class="form-group">
                        <label for="departmentName">Department Name *</label>
                        <input type="text" id="departmentName" name="departmentName" required pattern="[A-Za-z\s&]{3,100}"
                            title="Department name should contain only letters, spaces and & (3-100 characters)"
                            placeholder="e.g., Computer Science Engineering" class="input-fields">
                        <span class="error-message"></span>
                    </div>
                    <div class="form-group">
                        <label for="hodName">Head of Department (HOD) *</label>
                        <select id="hodName" name="hodName" required>
                            <option value="">Select HOD</option>
                            <?php foreach ($fac as $key => $value) { ?>
                                <option value="<?php echo $value['ID']; ?>">
                                    <?php echo $value['First_Name'] . ' ' . $value['Last_Name'] . ' (' . $value['Designation'] . ')'; ?>
                                </option>
                            <?php } ?>
                        </select>
                        <span class="error-message"></span>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group full-width">
                        <label for="departmentDescription">Department Description</label>
                        <textarea id="departmentDescription" name="departmentDescription" pattern=".{10,500}"
                            title="Description should be 10-500 characters long"
                            placeholder="Brief description about the department, its vision, mission, and specializations..."
                            required></textarea>
                        <span class="error-message"></span>
                    </div>
                </div>
                <div class="form-row">


                    <div class="form-group">
                        <label for="establishedYear">Established Year</label>
                        <input type="number" id="establishedYear" name="establishedYear" min="1950" max="2024"
                            placeholder="e.g., 2010" class="input-fields" required>
                        <span class="error-message"></span>
                    </div>
                    <div class="form-group">
                        <label for="departmentStatus">Department Status *</label>
                        <select id="departmentStatus" name="departmentStatus" required>
                            <option value="">Select Status</option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                            <option value="Under Development">Under Development</option>
                            <option value="Merged">Merged</option>
                            <option value="Discontinued">Discontinued</option>
                        </select>
                        <span class="error-message"></span>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Form Buttons -->
        <div class="form-buttons">
            <button type="button" class="btn btn-secondary" onclick="resetForm()">Reset Form</button>
            <button type="submit" class="btn btn-primary" name="btn">Add
                <?php echo $entity_type; ?></button>
            <!-- <input type="submit" name="btn" id="btn" value="Add <?php echo $entity_type; ?>" class="btn btn-primary"> -->
        </div>
    </form>
</div>

<script>
    // Simple form validation
    const form = document.getElementById('studentForm');
    const inputs = form.querySelectorAll('.input-fields, select, textarea');

    // Add event listeners for real-time validation
    inputs.forEach(input => {
        input.addEventListener('blur', validateField);
        input.addEventListener('input', clearError);
    });

    function validateField(e) {
        const field = e.target;
        const errorSpan = field.nextElementSibling;

        if (field.hasAttribute('required') && !field.value.trim()) {
            showError(field, errorSpan, 'This field is required');
            return false;
        }

        if (field.hasAttribute('pattern') && field.value && !field.checkValidity()) {
            showError(field, errorSpan, field.getAttribute('title'));
            return false;
        }

        if (field.type === 'email' && field.value && !field.checkValidity()) {
            showError(field, errorSpan, 'Please enter a valid email address');
            return false;
        }

        clearError(e);
        return true;
    }

    function showError(field, errorSpan, message) {
        field.classList.add('error');
        errorSpan.textContent = message;
        errorSpan.style.display = 'block';
    }

    function clearError(e) {
        const field = e.target;
        const errorSpan = field.nextElementSibling;
        field.classList.remove('error');
        errorSpan.style.display = 'none';
    }

    // Form submission
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        let isValid = true;
        inputs.forEach(input => {
            if (!validateField({ target: input })) {
                isValid = false;
            }
        });

        if (isValid) {
            form.submit();
        }
        else {

            alert('Please fix the errors in the form');
        }
    });

    // Reset form function
    function resetForm() {
        if (confirm('Are you sure you want to reset the form? All data will be lost.')) {
            form.reset();
            inputs.forEach(input => {
                input.classList.remove('error');
                const errorSpan = input.nextElementSibling;
                if (errorSpan) errorSpan.style.display = 'none';
            });
        }
    }

    // Set today's date as default for admission date
    document.getElementById('admissionDate').valueAsDate = new Date();

    // ...existing code...
    const City = ['Ahmedabad', 'Surat', 'Vadodara', 'Rajkot', 'Bhavnagar', 'Jamnagar', 'Junagadh', 'Gandhinagar', 'Anand', 'Nadiad', 'Navsari', 'Valsad', 'Porbandar', 'Mehsana', 'Bhuj', 'Bharuch', 'Surendranagar', 'Morbi', 'Palanpur', 'Godhra', 'Himatnagar', 'Amreli', 'Vapi', 'Gandhidham', 'Veraval', 'Dahod', 'Ankleshwar', 'Vyara', 'Gondal', 'Rajpipla', 'Palitana', 'Dwarka', 'Kodinar', 'Jetpur', 'Botad', 'Patan'
    ];
    // ...existing code...

    const select = document.getElementById('city');
    const options = City.forEach((city) => {
        const option = document.createElement('option');
        option.value = city.toLowerCase();
        option.textContent = city;
        select.appendChild(option);
    })

    const dates = document.querySelectorAll('[type="date"]');
    dates.forEach(date => {
        const [day, month, year] = new Date().toLocaleDateString('en-IN').split('-');
        date.value = `${year}-${month}-${day}`;
    })
</script>