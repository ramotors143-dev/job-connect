<?php 
require_once 'config.php'; 

$error = '';
$success = '';

// Handle Login Form Submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    if (!empty($email) && !empty($password)) {
        $query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);
            // Verify Password
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_role'] = $user['role'];

                header("Location: index.php");
                exit();
            } else {
                $error = "Invalid email or password.";
            }
        } else {
            $error = "No account found with this email.";
        }
    } else {
        $error = "Please fill in all fields.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In - JobConnect</title>
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
                        url('https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=1200&q=80'); 
            background-size: cover; 
            background-position: center; 
            border-radius: 16px; 
            padding: 60px 40px; 
            margin-bottom: 30px; 
        }
        .hero-section h1 { font-size: 36px; color: #ffffff; margin-bottom: 10px; font-weight: 700; }
        .hero-section p { color: #e2e8f0; margin-bottom: 0px; font-size: 15px; }
        
        .section-title { font-size: 20px; font-weight: 700; color: #0f172a; margin-bottom: 18px; }
        
        /* Form Card Styling */
        .form-card { background: #ffffff; border-radius: 12px; padding: 35px; box-shadow: 0 2px 6px rgba(0,0,0,0.03); margin-bottom: 25px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-size: 14px; font-weight: 600; color: #334155; margin-bottom: 8px; }
        .form-control { width: 100%; padding: 12px 15px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 14px; outline: none; background: #f8fafc; }
        .form-control:focus { border-color: #2563eb; background: #fff; }
        
        .form-options { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; font-size: 13px; color: #475569; }
        .form-options a { color: #2563eb; text-decoration: none; font-weight: 600; }
        
        /* Alerts */
        .alert-error { background: #fee2e2; color: #991b1b; padding: 12px 15px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; }
        
        /* Sidebar Widgets */
        .widget-box { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 25px 20px; margin-bottom: 20px; }
        .widget-box h4 { font-size: 16px; color: #0f172a; margin-bottom: 12px; }
        .widget-item { margin-bottom: 12px; font-size: 13px; color: #475569; display: flex; gap: 10px; align-items: center; }
        .widget-item i { color: #2563eb; }
        
        .cta-card { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 25px 20px; text-align: center; margin-bottom: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.02); }
        .cta-card h4 { font-size: 14px; color: #0f172a; margin-bottom: 15px; line-height: 1.4; }
        
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
            <a href="post-job.php" class="btn btn-dark">Post a Job</a>
            <a href="login.php" class="btn btn-primary">Log In</a>
            <a href="signup.php" class="btn btn-light">Sign Up</a>
        </div>
    </header>

    <!-- Main Content Layout -->
    <div class="main-layout">
        
        <!-- Left Content Area -->
        <div class="left-content">
            
            <!-- Dark Overlay Hero Banner -->
            <div class="hero-section">
                <h1>Welcome Back to JobConnect</h1>
                <p>Log in to access saved jobs, applications, and personalized recommendations.</p>
            </div>

            <h2 class="section-title">Sign In to Your Account</h2>

            <!-- Error Message -->
            <?php if(!empty($error)): ?>
                <div class="alert-error"><i class="fa-solid fa-circle-exclamation"></i> <?php echo $error; ?></div>
            <?php endif; ?>

            <!-- Login Form Card -->
            <div class="form-card">
                <form action="login.php" method="POST">
                    
                    <div class="form-group">
                        <label>Email Address *</label>
                        <input type="email" name="email" class="form-control" placeholder="e.g. reesa@example.com" required>
                    </div>

                    <div class="form-group">
                        <label>Password *</label>
                        <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                    </div>

                    <div class="form-options">
                        <label><input type="checkbox" name="remember"> Remember me</label>
                        <a href="#">Forgot password?</a>
                    </div>

                    <button type="submit" name="login" class="btn btn-primary" style="width:100%; padding: 12px; font-size:15px;">Log In</button>
                </form>
            </div>

        </div>

        <!-- Right Sidebar Area -->
        <div class="right-sidebar">
            
            <div class="widget-box">
                <h4>Why Log In?</h4>
                <div class="widget-item"><i class="fa-solid fa-circle-check"></i> <span>Track job applications easily</span></div>
                <div class="widget-item"><i class="fa-solid fa-circle-check"></i> <span>Receive instant job alerts</span></div>
                <div class="widget-item"><i class="fa-solid fa-circle-check"></i> <span>Save favorite job postings</span></div>
                <div class="widget-item"><i class="fa-solid fa-circle-check"></i> <span>Apply with 1-click resume</span></div>
            </div>

            <div class="cta-card">
                <h4>Don't have an account yet?</h4>
                <p style="font-size:13px; color:#64748b; margin-bottom:15px;">Create a free profile in less than 2 minutes.</p>
                <a href="signup.php" class="btn btn-dark" style="width:100%;">Create Account</a>
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