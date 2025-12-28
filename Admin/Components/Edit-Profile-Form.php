<div class="edit-form-container">
    <!-- Form Header -->
    <div class="form-header">
        <h1>Edit Profile</h1>
        <p>Update your personal and academic information</p>
        
        <!-- Profile Preview -->
        <div class="profile-preview">
            <img src="Public/Uploads/<?php echo !empty($record_data['Photo']) ? htmlspecialchars($record_data['Photo']) : 'SSASIT.png'; ?>" 
                 alt="Profile Picture" class="preview-avatar" id="avatarPreview"
                 onerror="this.src='Public/Icon/SSASIT.png'">
            <div class="preview-info">
                <h3><?php echo htmlspecialchars($record_data['First_Name'] . ' ' . $record_data['Last_Name']); ?></h3>
                <p><?php echo htmlspecialchars($record_data['Designation'] ?? ucfirst($record_type)); ?></p>
            </div>
        </div>
    </div>

    <!-- Form Body -->
    <div class="form-body">
        <form id="editProfileForm" action="Update?type=<?php echo $record_type; ?>&id=<?php echo $record_id; ?>" 
              method="post" enctype="multipart/form-data" novalidate>
            
            <!-- Personal Information Section -->
            <div class="form-section">
                <h2 class="section-title">
                    <i class="fas fa-user"></i>
                    Personal Information
                </h2>

                <div class="form-row">
                    <div class="form-group">
                        <label for="firstName" class="required">First Name</label>
                        <input type="text" id="firstName" name="firstName" 
                               value="<?php echo htmlspecialchars($record_data['First_Name'] ?? ''); ?>"
                               required class="input-fields" placeholder="Enter first name">
                        <span class="error-message"></span>
                    </div>

                    <div class="form-group">
                        <label for="lastName" class="required">Last Name</label>
                        <input type="text" id="lastName" name="lastName" 
                               value="<?php echo htmlspecialchars($record_data['Last_Name'] ?? ''); ?>"
                               required class="input-fields" placeholder="Enter last name">
                        <span class="error-message"></span>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="dob" class="required">Date of Birth</label>
                        <input type="date" id="dob" name="dob" 
                               value="<?php echo htmlspecialchars($record_data['DOB'] ?? ''); ?>"
                               required class="input-fields" min="1950-01-01" max="2010-12-31">
                        <span class="error-message"></span>
                    </div>

                    <div class="form-group">
                        <label for="gender" class="required">Gender</label>
                        <select id="gender" name="gender" required class="input-fields">
                            <option value="">Select Gender</option>
                            <option value="Male" <?php echo (isset($record_data['Gender']) && $record_data['Gender'] === 'Male') ? 'selected' : ''; ?>>Male</option>
                            <option value="Female" <?php echo (isset($record_data['Gender']) && $record_data['Gender'] === 'Female') ? 'selected' : ''; ?>>Female</option>
                            <option value="Other" <?php echo (isset($record_data['Gender']) && $record_data['Gender'] === 'Other') ? 'selected' : ''; ?>>Other</option>
                        </select>
                        <span class="error-message"></span>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="mobile" class="required">Mobile Number</label>
                        <input type="tel" id="mobile" name="mobile" 
                               value="<?php echo htmlspecialchars($record_data['Mobile'] ?? ''); ?>"
                               required class="input-fields" placeholder="Enter mobile number"
                               pattern="[0-9]{10}" title="Please enter a valid 10-digit mobile number">
                        <span class="error-message"></span>
                    </div>

                    <div class="form-group">
                        <label for="email" class="required">Email Address</label>
                        <input type="email" id="email" name="email" 
                               value="<?php echo htmlspecialchars($record_data['Email'] ?? ''); ?>"
                               required class="input-fields" placeholder="Enter email address">
                        <span class="error-message"></span>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="address" class="required">Address</label>
                        <input type="text" id="address" name="address" 
                               value="<?php echo htmlspecialchars($record_data['Address'] ?? ''); ?>"
                               required class="input-fields" placeholder="Enter full address">
                        <span class="error-message"></span>
                    </div>

                    <div class="form-group">
                        <label for="city" class="required">City</label>
                        <select id="city" name="city" required class="input-fields">
                            <option value="">Select City</option>
                        </select>
                        <span class="error-message"></span>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="avatar">Profile Photo</label>
                        <input type="file" id="avatar" name="avatar" 
                               accept="image/jpeg,image/jpg,image/png" class="input-fields">
                        <span class="error-message"></span>
                        <small style="color: #6b7280; font-size: 0.875rem; margin-top: 0.25rem; display: block;">
                            Leave empty to keep current photo. Supported formats: JPG, PNG (Max: 5MB)
                        </small>
                    </div>
                </div>
            </div>

            <!-- Academic Information Section -->
            <div class="form-section">
                <h2 class="section-title">
                    <i class="fas fa-graduation-cap"></i>
                    Academic Information
                </h2>

                <div class="form-row">
                    <div class="form-group">
                        <label for="qualification" class="required">Qualification</label>
                        <input type="text" id="qualification" name="qualification" 
                               value="<?php echo htmlspecialchars($record_data['Qualification'] ?? ''); ?>"
                               required class="input-fields" placeholder="Enter qualification">
                        <span class="error-message"></span>
                    </div>

                    <div class="form-group">
                        <label for="department" class="required">Department</label>
                        <select id="department" name="department" required class="input-fields">
                            <option value="">Select Department</option>
                            <?php foreach ($departments as $dept): ?>
                                <option value="<?php echo $dept['Dept_ID']; ?>" 
                                        <?php echo (isset($record_data['Department_ID']) && $record_data['Department_ID'] == $dept['Dept_ID']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($dept['Dept_Name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <span class="error-message"></span>
                    </div>
                </div>

                <?php if ($record_type === 'faculty'): ?>
                <div class="form-row">
                    <div class="form-group">
                        <label for="designation" class="required">Designation</label>
                        <select id="designation" name="designation" required class="input-fields">
                            <option value="">Select Designation</option>
                            <option value="Professor" <?php echo (isset($record_data['Designation']) && $record_data['Designation'] === 'Professor') ? 'selected' : ''; ?>>Professor</option>
                            <option value="Associate Professor" <?php echo (isset($record_data['Designation']) && $record_data['Designation'] === 'Associate Professor') ? 'selected' : ''; ?>>Associate Professor</option>
                            <option value="Assistant Professor" <?php echo (isset($record_data['Designation']) && $record_data['Designation'] === 'Assistant Professor') ? 'selected' : ''; ?>>Assistant Professor</option>
                            <option value="Lecturer" <?php echo (isset($record_data['Designation']) && $record_data['Designation'] === 'Lecturer') ? 'selected' : ''; ?>>Lecturer</option>
                            <option value="Lab Assistant" <?php echo (isset($record_data['Designation']) && $record_data['Designation'] === 'Lab Assistant') ? 'selected' : ''; ?>>Lab Assistant</option>
                        </select>
                        <span class="error-message"></span>
                    </div>

                    <div class="form-group">
                        <label for="experience">Experience (Years)</label>
                        <input type="number" id="experience" name="experience" 
                               value="<?php echo htmlspecialchars($record_data['Experience'] ?? '0'); ?>"
                               min="0" max="50" class="input-fields" placeholder="Years of experience">
                        <span class="error-message"></span>
                    </div>
                </div>
                <?php endif; ?>

                <div class="form-row">
                    <div class="form-group">
                        <label for="admissionDate" class="required">
                            <?php echo ($record_type === 'faculty') ? 'Joining' : 'Admission'; ?> Date
                        </label>
                        <input type="date" id="admissionDate" name="admissionDate" 
                               value="<?php echo htmlspecialchars($record_data['Joining_Date'] ?? $record_data['Admission_Date'] ?? ''); ?>"
                               required class="input-fields" 
                               min="<?php echo ($record_type === 'faculty') ? '2000-01-01' : '2015-01-01'; ?>" 
                               max="2030-12-31">
                        <span class="error-message"></span>
                    </div>

                    <div class="form-group">
                        <label for="status" class="required">Status</label>
                        <select id="status" name="status" required class="input-fields">
                            <option value="">Select Status</option>
                            <option value="active" <?php echo (isset($record_data['Status']) && $record_data['Status'] === 'Active') ? 'selected' : ''; ?>>Active</option>
                            <option value="inactive" <?php echo (isset($record_data['Status']) && $record_data['Status'] === 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
                            <?php if ($record_type === 'student'): ?>
                                <option value="graduated" <?php echo (isset($record_data['Status']) && $record_data['Status'] === 'Graduated') ? 'selected' : ''; ?>>Graduated</option>
                            <?php endif; ?>
                        </select>
                        <span class="error-message"></span>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    Update Profile
                </button>
                <a href="View-Record?Id=<?php echo $record_id; ?>&type=<?php echo $record_type; ?>" class="btn btn-secondary">
                    <i class="fas fa-times"></i>
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
// Image preview functionality
document.getElementById('avatar').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        // Validate file size (5MB max)
        if (file.size > 5 * 1024 * 1024) {
            alert('File size must be less than 5MB');
            e.target.value = '';
            return;
        }

        // Validate file type
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        if (!allowedTypes.includes(file.type)) {
            alert('Please select a valid image file (JPG, PNG)');
            e.target.value = '';
            return;
        }

        // Show preview
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('avatarPreview').src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
});

// Real-time validation
document.addEventListener('DOMContentLoaded', function() {
    // Populate city dropdown
    const City = ['Ahmedabad', 'Surat', 'Vadodara', 'Rajkot', 'Bhavnagar', 'Jamnagar', 'Junagadh', 'Gandhinagar', 'Anand', 'Nadiad', 'Navsari', 'Valsad', 'Porbandar', 'Mehsana', 'Bhuj', 'Bharuch', 'Surendranagar', 'Morbi', 'Palanpur', 'Godhra', 'Himatnagar', 'Amreli', 'Vapi', 'Gandhidham', 'Veraval', 'Dahod', 'Ankleshwar', 'Vyara', 'Gondal', 'Rajpipla', 'Palitana', 'Dwarka', 'Kodinar', 'Jetpur', 'Botad', 'Patan'];

    const citySelect = document.getElementById('city');
    const currentCity = '<?php echo htmlspecialchars($record_data['City'] ?? ''); ?>';

    City.forEach((city) => {
        const option = document.createElement('option');
        option.value = city.toLowerCase();
        option.textContent = city;

        // Set selected if this matches the current city
        if (city.toLowerCase() === currentCity.toLowerCase()) {
            option.selected = true;
        }

        citySelect.appendChild(option);
    });

    const form = document.getElementById('editProfileForm');
    const inputs = form.querySelectorAll('input, select');

    inputs.forEach(input => {
        input.addEventListener('blur', validateField);
        input.addEventListener('input', clearError);
    });

    function validateField(e) {
        const field = e.target;
        const value = field.value.trim();
        const errorSpan = field.parentNode.querySelector('.error-message');

        // Clear previous error
        field.classList.remove('error');
        if (errorSpan) errorSpan.style.display = 'none';

        // Validate required fields
        if (field.hasAttribute('required') && !value) {
            showError(field, 'This field is required');
            return false;
        }

        // Validate email
        if (field.type === 'email' && value) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(value)) {
                showError(field, 'Please enter a valid email address');
                return false;
            }
        }

        // Validate mobile
        if (field.name === 'mobile' && value) {
            const mobileRegex = /^[0-9]{10}$/;
            if (!mobileRegex.test(value)) {
                showError(field, 'Please enter a valid 10-digit mobile number');
                return false;
            }
        }

        return true;
    }

    function clearError(e) {
        const field = e.target;
        field.classList.remove('error');
        const errorSpan = field.parentNode.querySelector('.error-message');
        if (errorSpan) errorSpan.style.display = 'none';
    }

    function showError(field, message) {
        field.classList.add('error');
        const errorSpan = field.parentNode.querySelector('.error-message');
        if (errorSpan) {
            errorSpan.textContent = message;
            errorSpan.style.display = 'block';
            errorSpan.classList.add('show');
        }
    }

    // Form submission with loading state
    form.addEventListener('submit', function(e) {
        const submitBtn = form.querySelector('button[type="submit"]');
        let isValid = true;

        // Validate all fields
        inputs.forEach(input => {
            if (!validateField({ target: input })) {
                isValid = false;
            }
        });

        if (!isValid) {
            e.preventDefault();
            const firstError = form.querySelector('.error');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstError.focus();
            }
            return;
        }

        // Show loading state
        submitBtn.classList.add('loading');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Updating...';
    });
});
</script>
