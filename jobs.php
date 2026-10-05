<?php 
// Database Configuration and Session Start
require_once 'config.php'; 

// Get filter values from URL
$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
$location = isset($_GET['location']) ? trim($_GET['location']) : '';

// Build dynamic SQL query
$sql = "SELECT * FROM jobs WHERE 1=1";

if (!empty($keyword)) {
    $sql .= " AND (title LIKE '%" . mysqli_real_escape_string($conn, $keyword) . "%' OR company_name LIKE '%" . mysqli_real_escape_string($conn, $keyword) . "%')";
}

if (!empty($location)) {
    $sql .= " AND location LIKE '%" . mysqli_real_escape_string($conn, $location) . "%'";
}

$sql .= " ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find Jobs - JobConnect</title>
    <!-- FontAwesome Icons -->
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
        .left-content { width: 100%; }
        
        /* Hero Banner */
        .hero-section { 
            background: linear-gradient(rgba(15, 23, 42, 0.75), rgba(15, 23, 42, 0.75)), 
                        url('https://images.unsplash.com/photo-1497215728101-856f4ea42174?auto=format&fit=crop&w=1200&q=80'); 
            background-size: cover; 
            background-position: center; 
            border-radius: 16px; 
            padding: 75px 40px; 
            margin-bottom: 30px; 
        }
        .hero-section h1 { font-size: 38px; color: #ffffff; margin-bottom: 10px; font-weight: 700; }
        .hero-section p { color: #e2e8f0; margin-bottom: 30px; font-size: 16px; }
        
        /* Search Bar */
        .search-box { background: #ffffff; padding: 8px; border-radius: 12px; display: flex; gap: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.15); }
        .search-input { flex: 1; display: flex; align-items: center; background: #f8fafc; padding: 12px 15px; border-radius: 8px; border: 1px solid #e2e8f0; }
        .search-input i { color: #94a3b8; margin-right: 10px; }
        .search-input input { border: none; background: transparent; outline: none; width: 100%; font-size: 14px; }
        
        /* Job Cards */
        .job-card { background: #ffffff; border-radius: 12px; padding: 20px; margin-bottom: 15px; display: flex; align-items: center; justify-content: space-between; box-shadow: 0 2px 6px rgba(0,0,0,0.03); }
        .job-info { display: flex; gap: 15px; align-items: center; }
        .company-logo { width: 48px; height: 48px; border-radius: 10px; background: #0f172a; color: #fff; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 15px; }
        .job-details h3 { font-size: 16px; color: #0f172a; margin-bottom: 4px; }
        .job-details p { font-size: 13px; color: #64748b; margin-bottom: 8px; }
        .tags { display: flex; gap: 6px; }
        .tag { background: #f1f5f9; color: #475569; font-size: 11px; padding: 4px 10px; border-radius: 6px; font-weight: 600; }
        
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

    <!-- Header / Navbar Section -->
    <header>
        <a href="index.php" class="logo">JobConnect</a>
        <nav>
            <a href="index.php">Home</a> |
            <a href="jobs.php" class="active">Find Jobs</a> |
            <a href="companies.php">Companies</a> |
            <a href="career-advice.php">Career Advice</a>
        </nav>
        <div class="nav-buttons">
            <a href="post-job.php" class="btn btn-dark">Post a Job</a>
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
        
        <div class="left-content">
            
            <!-- Hero Banner -->
            <div class="hero-section">
                <h1>Explore Available Job Opportunities</h1>
                <p>Filter through active openings and apply directly today.</p>
                
                <form action="jobs.php" method="GET" class="search-box">
                    <div class="search-input">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" name="keyword" placeholder="Job title, keywords, or company" value="<?php echo htmlspecialchars($keyword); ?>">
                    </div>
                    <div class="search-input">
                        <i class="fa-solid fa-location-dot"></i>
                        <input type="text" name="location" placeholder="City, state, or remote" value="<?php echo htmlspecialchars($location); ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Search Jobs</button>
                </form>
            </div>

            <!-- Dynamic Database Jobs Query with Real ID Link -->
            <?php if($result && mysqli_num_rows($result) > 0): ?>
                <?php while($job = mysqli_fetch_assoc($result)): ?>
                    <div class="job-card">
                        <div class="job-info">
                            <div class="company-logo"><?php echo strtoupper(substr($job['company_name'], 0, 2)); ?></div>
                            <div class="job-details">
                                <h3><?php echo htmlspecialchars($job['title']); ?></h3>
                                <p><?php echo htmlspecialchars($job['company_name']); ?> • <?php echo htmlspecialchars($job['location']); ?></p>
                                <div class="tags">
                                    <span class="tag"><?php echo htmlspecialchars($job['job_type']); ?></span>
                                    <span class="tag">$<?php echo htmlspecialchars($job['salary']); ?></span>
                                </div>
                            </div>
                        </div>
                        <a href="job-details.php?id=<?php echo $job['id']; ?>" class="btn btn-primary">Apply Now</a>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>

            <!-- Dummy Job Cards with Clickable Unique ID Links -->
            <div class="job-card">
                <div class="job-info"><div class="company-logo" style="background:#1e1b4b;">G</div><div class="job-details"><h3>Senior Full-Stack Engineer</h3><p>Google • Remote</p><div class="tags"><span class="tag">Remote</span><span class="tag">$130k - $160k</span></div></div></div>
                <a href="job-details.php?id=101" class="btn btn-primary">Apply Now</a>
            </div>

            <div class="job-card">
                <div class="job-info"><div class="company-logo" style="background:#0284c7;">M</div><div class="job-details"><h3>Product UI/UX Designer</h3><p>Microsoft • San Francisco, CA</p><div class="tags"><span class="tag">Full-Time</span><span class="tag">$110k - $140k</span></div></div></div>
                <a href="job-details.php?id=102" class="btn btn-primary">Apply Now</a>
            </div>

            <div class="job-card">
                <div class="job-info"><div class="company-logo" style="background:#ea580c;">A</div><div class="job-details"><h3>React Native Developer</h3><p>Amazon • Remote</p><div class="tags"><span class="tag">Contract</span><span class="tag">$95 / hr</span></div></div></div>
                <a href="job-details.php?id=103" class="btn btn-primary">Apply Now</a>
            </div>

            <div class="job-card">
                <div class="job-info"><div class="company-logo" style="background:#16a34a;">S</div><div class="job-details"><h3>Backend PHP Engineer</h3><p>Spotify • New York, NY</p><div class="tags"><span class="tag">Part-Time</span><span class="tag">$70k - $90k</span></div></div></div>
                <a href="job-details.php?id=104" class="btn btn-primary">Apply Now</a>
            </div>

            <div class="job-card">
                <div class="job-info"><div class="company-logo" style="background:#9333ea;">N</div><div class="job-details"><h3>DevOps Cloud Architect</h3><p>Netflix • Los Gatos, CA</p><div class="tags"><span class="tag">Full-Time</span><span class="tag">$150k - $190k</span></div></div></div>
                <a href="job-details.php?id=105" class="btn btn-primary">Apply Now</a>
            </div>

            <div class="job-card">
                <div class="job-info"><div class="company-logo" style="background:#2563eb;">A</div><div class="job-details"><h3>Data Science Specialist</h3><p>Apple • Cupertino, CA</p><div class="tags"><span class="tag">Remote</span><span class="tag">$140k - $170k</span></div></div></div>
                <a href="job-details.php?id=106" class="btn btn-primary">Apply Now</a>
            </div>

            <div class="job-card">
                <div class="job-info"><div class="company-logo" style="background:#dc2626;">T</div><div class="job-details"><h3>Frontend Web Developer</h3><p>Tesla • Austin, TX</p><div class="tags"><span class="tag">Contract</span><span class="tag">$80 / hr</span></div></div></div>
                <a href="job-details.php?id=107" class="btn btn-primary">Apply Now</a>
            </div>

            <div class="job-card">
                <div class="job-info"><div class="company-logo" style="background:#475569;">G</div><div class="job-details"><h3>Cybersecurity Analyst</h3><p>GitHub • Remote</p><div class="tags"><span class="tag">Remote</span><span class="tag">$120k - $150k</span></div></div></div>
                <a href="job-details.php?id=108" class="btn btn-primary">Apply Now</a>
            </div>

            <div class="job-card">
                <div class="job-info"><div class="company-logo" style="background:#059669;">A</div><div class="job-details"><h3>Digital Marketing Lead</h3><p>Adobe • San Jose, CA</p><div class="tags"><span class="tag">Full-Time</span><span class="tag">$95k - $125k</span></div></div></div>
                <a href="job-details.php?id=109" class="btn btn-primary">Apply Now</a>
            </div>

            <div class="job-card">
                <div class="job-info"><div class="company-logo" style="background:#d97706;">U</div><div class="job-details"><h3>Content Strategist</h3><p>Uber • Chicago, IL</p><div class="tags"><span class="tag">Part-Time</span><span class="tag">$50k - $65k</span></div></div></div>
                <a href="job-details.php?id=110" class="btn btn-primary">Apply Now</a>
            </div>

            <div class="job-card">
                <div class="job-info"><div class="company-logo" style="background:#7c3aed;">D</div><div class="job-details"><h3>Machine Learning Engineer</h3><p>DeepMind • Remote</p><div class="tags"><span class="tag">Remote</span><span class="tag">$160k - $200k</span></div></div></div>
                <a href="job-details.php?id=111" class="btn btn-primary">Apply Now</a>
            </div>

            <div class="job-card">
                <div class="job-info"><div class="company-logo" style="background:#db2777;">S</div><div class="job-details"><h3>QA Automation Tester</h3><p>Stripe • Seattle, WA</p><div class="tags"><span class="tag">Contract</span><span class="tag">$75 / hr</span></div></div></div>
                <a href="job-details.php?id=112" class="btn btn-primary">Apply Now</a>
            </div>

            <div class="job-card">
                <div class="job-info"><div class="company-logo" style="background:#0284c7;">L</div><div class="job-details"><h3>Technical Product Manager</h3><p>LinkedIn • Sunnyvale, CA</p><div class="tags"><span class="tag">Full-Time</span><span class="tag">$140k - $180k</span></div></div></div>
                <a href="job-details.php?id=113" class="btn btn-primary">Apply Now</a>
            </div>

            <div class="job-card">
                <div class="job-info"><div class="company-logo" style="background:#4f46e5;">D</div><div class="job-details"><h3>Database Administrator</h3><p>Discord • Remote</p><div class="tags"><span class="tag">Remote</span><span class="tag">$115k - $145k</span></div></div></div>
                <a href="job-details.php?id=114" class="btn btn-primary">Apply Now</a>
            </div>

            <div class="job-card">
                <div class="job-info"><div class="company-logo" style="background:#0f172a;">Z</div><div class="job-details"><h3>Mobile App Designer</h3><p>Zoom • Denver, CO</p><div class="tags"><span class="tag">Part-Time</span><span class="tag">$60k - $80k</span></div></div></div>
                <a href="job-details.php?id=115" class="btn btn-primary">Apply Now</a>
            </div>

        </div>

    </div>

    <!-- Footer Section -->
<!-- Footer Section -->
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