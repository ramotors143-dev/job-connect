<?php 
require_once 'config.php'; 

$message = '';
$error = '';

// Handle Job Post Form Submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_job'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $company_name = mysqli_real_escape_string($conn, $_POST['company_name']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $category_id = intval($_POST['category_id']);
    $job_type = mysqli_real_escape_string($conn, $_POST['job_type']);
    $salary = mysqli_real_escape_string($conn, $_POST['salary']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $employer_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 1; // Default fallback to ID 1

    if(!empty($title) && !empty($company_name) && !empty($location) && !empty($description)) {
        $query = "INSERT INTO jobs (employer_id, title, company_name, location, category_id, job_type, salary, description) 
                  VALUES ('$employer_id', '$title', '$company_name', '$location', '$category_id', '$job_type', '$salary', '$description')";
        
        if (mysqli_query($conn, $query)) {
            $message = "Job posted successfully!";
        } else {
            $error = "Failed to post job: " . mysqli_error($conn);
        }
    } else {
        $error = "Please fill in all required fields.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post a Job - JobConnect</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background-color: #0d1b2a; display: flex; justify-content: center; padding: 20px 0; }
        
        .app-container { 
            width: 92%; 
            max-width: 1280px; 
            background-color: #f4f7fe; 
            border-radius: 20px; 
            overflow: hidden; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.3); 
        }
        
        /* Header / Navbar */
        header { 
            background: #ffffff; 
            padding: 18px 40px; 
            display: flex; 
            align-items: center; 
            justify-content: space-between; 
            border-bottom: 1px solid #e2e8f0; 
        }
        .logo { font-size: 22px; font-weight: 700; color: #0b2545; text-decoration: none; }
        nav a { margin: 0 12px; text-decoration: none; color: #4a5568; font-size: 14px; font-weight: 600; }
        nav a.active { color: #2563eb; }
        
        .nav-buttons { display: flex; gap: 10px; }
        .btn { padding: 8px 18px; border-radius: 8px; text-decoration: none; font-size: 14px; font-weight: 600; cursor: pointer; border: none; display: inline-block; }
        .btn-dark { background-color: #1e293b; color: #fff; }
        .btn-light { background-color: #f1f5f9; color: #334155; border: 1px solid #cbd5e1; }
        .btn-primary { background-color: #2563eb; color: #fff; }
        .btn-primary:hover { background-color: #1d4ed8; }
        
        /* Layout Structure */
        .main-layout { display: flex; gap: 20px; padding: 25px; }
        .left-content { flex: 2; }
        .right-sidebar { flex: 1; }
        
        /* Darkened Hero Banner */
        .hero-section { 
            background: linear-gradient(rgba(15, 23, 42, 0.75), rgba(15, 23, 42, 0.75)), 
                        url('https://images.unsplash.com/photo-1521737711867-e3b97375f902?auto=format&fit=crop&w=1200&q=80'); 
            background-size: cover; 
            background-position: center; 
            border-radius: 16px; 
            padding: 70px 40px; 
            margin-bottom: 30px; 
        }
        .hero-section h1 { font-size: 38px; color: #ffffff; margin-bottom: 10px; font-weight: 700; }
        .hero-section p { color: #e2e8f0; margin-bottom: 0px; font-size: 16px; }
        
        .section-title { font-size: 20px; font-weight: 700; color: #0f172a; margin-bottom: 18px; }
        
        /* Form Card Styling */
        .form-card { background: #ffffff; border-radius: 12px; padding: 30px; box-shadow: 0 2px 6px rgba(0,0,0,0.03); margin-bottom: 25px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-size: 14px; font-weight: 600; color: #334155; margin-bottom: 8px; }
        .form-control { width: 100%; padding: 12px 15px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 14px; outline: none; background: #f8fafc; }
        .form-control:focus { border-color: #2563eb; background: #fff; }
        textarea.form-control { resize: vertical; min-height: 120px; }
        
        .form-row { display: flex; gap: 15px; }
        .form-row .form-group { flex: 1; }
        
        /* Alerts */
        .alert-success { background: #dcfce7; color: #166534; padding: 12px 15px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; }
        .alert-error { background: #fee2e2; color: #991b1b; padding: 12px 15px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; }
        
        /* Sidebar Widgets */
        .pricing-card { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 25px 20px; margin-bottom: 20px; }
        .pricing-card h4 { font-size: 16px; color: #0f172a; margin-bottom: 8px; }
        .pricing-card .price { font-size: 24px; font-weight: 700; color: #2563eb; margin-bottom: 15px; }
        .pricing-features { list-style: none; margin-bottom: 15px; }
        .pricing-features li { font-size: 13px; color: #475569; margin-bottom: 8px; display: flex; gap: 8px; align-items: center; }
        .pricing-features li i { color: #16a34a; }
        
        /* Footer */
        footer { background: #0b1329; color: #94a3b8; padding: 50px 20px 20px 20px; font-size: 13px; }
        .footer-content { display: flex; justify-content: space-around; margin-bottom: 40px; }
        .footer-col h5 { color: #fff; margin-bottom: 12px; font-size: 14px; }
        .footer-col a { display: block; color: #94a3b8; text-decoration: none; margin-bottom: 8px; }
        .copyright { text-align: center; border-top: 1px solid #1e293b; padding-top: 20px; font-size: 12px; }
    </style>
</head>
<body>

<div class="app-container">

    <!-- Header / Navbar -->
    <header>
        <a href="index.php" class="logo">JobConnect</a>
        <nav>
            <a href="index.php">Home</a> |
            <a href="jobs.php">Find Jobs</a> |
            <a href="companies.php">Companies</a> |
            <a href="career-advice.php">Career Advice</a>
        </nav>
        <div class="nav-buttons">
            <a href="post-job.php" class="btn btn-dark active">Post a Job</a>
            <?php if(isset($_SESSION['user_id'])): ?>
                <a href="logout.php" class="btn btn-light">Logout</a>
            <?php else: ?>
                <a href="login.php" class="btn btn-light">Log In</a>
                <a href="signup.php" class="btn btn-light">Sign Up</a>
            <?php endif; ?>
        </div>
    </header>

    <!-- Main Content Layout -->
    <div class="main-layout">
        
        <!-- Left Content Area -->
        <div class="left-content">
            
            <!-- Dark Overlay Hero Banner -->
            <div class="hero-section">
                <h1>Hire Top Talent Fast</h1>
                <p>Reach thousands of qualified job seekers and software engineers today.</p>
            </div>

            <h2 class="section-title">Post a New Job Opportunity</h2>

            <!-- Success/Error Messages -->
            <?php if(!empty($message)): ?>
                <div class="alert-success"><i class="fa-solid fa-circle-check"></i> <?php echo $message; ?></div>
            <?php endif; ?>
            <?php if(!empty($error)): ?>
                <div class="alert-error"><i class="fa-solid fa-circle-exclamation"></i> <?php echo $error; ?></div>
            <?php endif; ?>

            <!-- Job Posting Form Card -->
            <div class="form-card">
                <form action="post-job.php" method="POST">
                    
                    <div class="form-group">
                        <label>Job Title *</label>
                        <input type="text" name="title" class="form-control" placeholder="e.g. Senior Software Engineer" required>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Company Name *</label>
                            <input type="text" name="company_name" class="form-control" placeholder="e.g. Google Inc." required>
                        </div>
                        <div class="form-group">
                            <label>Job Location *</label>
                            <input type="text" name="location" class="form-control" placeholder="e.g. New York, NY or Remote" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Category *</label>
                            <select name="category_id" class="form-control" required>
                                <option value="1">Software Engineering</option>
                                <option value="2">Marketing & Sales</option>
                                <option value="3">Healthcare</option>
                                <option value="4">Finance</option>
                                <option value="5">Design & Creative</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Job Type *</label>
                            <select name="job_type" class="form-control" required>
                                <option value="Full-Time">Full-Time</option>
                                <option value="Part-Time">Part-Time</option>
                                <option value="Remote">Remote</option>
                                <option value="Contract">Contract</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Salary Range *</label>
                        <input type="text" name="salary" class="form-control" placeholder="e.g. $90k - $120k" required>
                    </div>

                    <div class="form-group">
                        <label>Job Description & Requirements *</label>
                        <textarea name="description" class="form-control" placeholder="Write comprehensive details about job responsibilities, skills, and qualifications..." required></textarea>
                    </div>

                    <button type="submit" name="submit_job" class="btn btn-primary" style="padding: 12px 30px; font-size:15px;">Publish Job Listing</button>
                </form>
            </div>

        </div>

        <!-- Right Sidebar Area -->
        <div class="right-sidebar">
            
            <div class="pricing-card">
                <h4>Standard Employer Listing</h4>
                <div class="price">Free Plan</div>
                <ul class="pricing-features">
                    <li><i class="fa-solid fa-check"></i> Live for 30 Days</li>
                    <li><i class="fa-solid fa-check"></i> Direct Candidate Applications</li>
                    <li><i class="fa-solid fa-check"></i> Instant Search Indexing</li>
                    <li><i class="fa-solid fa-check"></i> Unlimited Updates</li>
                </ul>
            </div>

            <div class="pricing-card" style="border: 2px solid #2563eb;">
                <h4 style="color:#2563eb;">Featured Premium Package</h4>
                <div class="price">$99 <span style="font-size:12px; color:#64748b;">/ listing</span></div>
                <ul class="pricing-features">
                    <li><i class="fa-solid fa-check"></i> Pinned to Top of Search</li>
                    <li><i class="fa-solid fa-check"></i> Highlighted Logo Badge</li>
                    <li><i class="fa-solid fa-check"></i> Email Blast to Job Seekers</li>
                    <li><i class="fa-solid fa-check"></i> Dedicated Hiring Manager Support</li>
                </ul>
                <button class="btn btn-primary" style="width:100%;">Upgrade to Featured</button>
            </div>

        </div>

    </div>

    <!-- Footer -->
   <!-- Footer -->
    <footer>
        <div class="footer-content">
            <div class="footer-col">
                <h5>About Us</h5>
                <a href="about.php">About Us</a>
                       <li><a href="profiles.php">My Profile</a></li>
                <a href="terms.php">Terms of Service</a>
            </div>
            <div class="footer-col">
                <h5>Contact</h5>
                <a href="contact.php">Contact Us</a>
                <a href="privacy.php">Privacy Policy</a>
            </div>
            <div class="footer-col">
                <h5>Privacy Policy</h5>
                <a href="privacy.php">Privacy Policy</a>
                <a href="terms.php">Terms of Use</a>
            </div>
            <div class="footer-col">
                <h5>Terms of Service</h5>
                <a href="terms.php">Terms & Conditions</a>
            </div>
        </div>
        <div class="copyright">
            © 2026 JobConnect. All rights reserved.
        </div>
    </footer>
</div>

</body>
</html>