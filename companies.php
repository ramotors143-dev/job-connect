<?php 
require_once 'config.php'; 

// Company Search & Category Filter Handler
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$category = isset($_GET['category']) ? mysqli_real_escape_string($conn, $_GET['category']) : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Companies - JobConnect</title>
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
        .btn { padding: 8px 18px; border-radius: 8px; text-decoration: none; font-size: 14px; font-weight: 600; cursor: pointer; border: none; display: inline-block; text-align: center; }
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
                        url('https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=1200&q=80'); 
            background-size: cover; 
            background-position: center; 
            border-radius: 16px; 
            padding: 60px 40px; 
            margin-bottom: 30px; 
        }
        .hero-section h1 { font-size: 36px; color: #ffffff; margin-bottom: 10px; font-weight: 700; }
        .hero-section p { color: #e2e8f0; margin-bottom: 25px; font-size: 15px; }
        
        /* Search Box */
        .search-box { background: #ffffff; padding: 8px; border-radius: 12px; display: flex; gap: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.15); }
        .search-input { flex: 1; display: flex; align-items: center; background: #f8fafc; padding: 12px 15px; border-radius: 8px; border: 1px solid #e2e8f0; }
        .search-input i { color: #94a3b8; margin-right: 10px; }
        .search-input input { border: none; background: transparent; outline: none; width: 100%; font-size: 14px; }
        
        .section-title { font-size: 20px; font-weight: 700; color: #0f172a; margin-bottom: 18px; }
        
        /* Company Cards Grid Layout */
        .company-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; margin-bottom: 25px; }
        .company-card { background: #ffffff; border-radius: 12px; padding: 20px; box-shadow: 0 2px 6px rgba(0,0,0,0.03); display: flex; flex-direction: column; justify-content: space-between; border: 1px solid #e2e8f0; transition: transform 0.2s; }
        .company-card:hover { transform: translateY(-3px); box-shadow: 0 6px 15px rgba(0,0,0,0.08); }
        
        /* Modern Dark Image Banner Header */
        .company-header-bg { 
            background: linear-gradient(rgba(15, 23, 42, 0.85), rgba(15, 23, 42, 0.85)), 
                        url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=600&q=80'); 
            background-size: cover; 
            background-position: center; 
            border-radius: 10px; 
            padding: 18px; 
            margin-bottom: 15px; 
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .company-meta h3 { font-size: 16px; color: #ffffff; margin-bottom: 2px; font-weight: 700; }
        .company-meta p { font-size: 12px; color: #cbd5e1; }
        .dark-badge { background: rgba(255, 255, 255, 0.15); padding: 5px 10px; border-radius: 6px; font-size: 11px; font-weight: 600; color: #fff; backdrop-filter: blur(4px); }

        .company-desc { font-size: 13px; color: #475569; margin-bottom: 15px; line-height: 1.4; }
        .company-footer { display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #f1f5f9; padding-top: 12px; }
        .job-count { font-size: 12px; font-weight: 600; color: #2563eb; background: #eff6ff; padding: 4px 10px; border-radius: 6px; }
        
        /* Sidebar Widgets */
        .widget-box { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px; margin-bottom: 20px; }
        .widget-box h4 { font-size: 15px; color: #0f172a; margin-bottom: 12px; }
        .widget-item { margin-bottom: 10px; font-size: 13px; color: #475569; display: flex; justify-content: space-between; text-decoration: none; transition: color 0.2s; }
        .widget-item:hover { color: #2563eb; }
        
        .cta-card { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 25px 20px; text-align: center; margin-bottom: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.02); }
        .cta-card h4 { font-size: 14px; color: #0f172a; margin-bottom: 15px; line-height: 1.4; }
        
        /* Footer matching user's custom layout */
        footer { background: #0b1329; color: #94a3b8; padding: 50px 20px 20px 20px; font-size: 13px; }
        .footer-content { display: flex; justify-content: space-around; margin-bottom: 40px; }
        .footer-col h5 { color: #fff; margin-bottom: 12px; font-size: 14px; }
        .footer-col a { display: block; color: #94a3b8; text-decoration: none; margin-bottom: 8px; }
        .copyright { text-align: center; border-top: 1px solid #1e293b; padding-top: 20px; font-size: 12px; }
    </style>
</head>
<body>

<div class="app-container">

    <!-- Header -->
    <header>
        <a href="index.php" class="logo">JobConnect</a>
        <nav>
            <a href="index.php">Home</a> |
            <a href="jobs.php">Find Jobs</a> |
            <a href="companies.php" class="active">Companies</a> |
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

    <!-- Main Layout -->
    <div class="main-layout">
        
        <!-- Left Main Content Area -->
        <div class="left-content">
            
            <!-- Dark Overlay Hero Banner -->
            <div class="hero-section">
                <h1>Discover Top Rated Companies</h1>
                <p>Explore elite organizations across Software, Healthcare, Finance, Marketing, and Design.</p>
                
                <form action="companies.php" method="GET" class="search-box">
                    <div class="search-input">
                        <i class="fa-solid fa-building"></i>
                        <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Search company by name or industry...">
                    </div>
                    <button type="submit" class="btn btn-primary">Search Company</button>
                </form>
            </div>

            <h2 class="section-title">Featured Industry Leaders & Employers</h2>

            <!-- Modern Companies Grid -->
            <div class="company-grid">
                
                <!-- 1. Software Engineering -->
                <div class="company-card">
                    <div>
                        <div class="company-header-bg">
                            <div class="company-meta">
                                <h3>Google Engineering</h3>
                                <p>Software Engineering • Global</p>
                            </div>
                            <span class="dark-badge">Verified</span>
                        </div>
                        <p class="company-desc">Developing scalable cloud systems, AI architectures, and core software solutions.</p>
                    </div>
                    <div class="company-footer">
                        <span class="job-count">28 Active Jobs</span>
                        <a href="company-details.php?id=1" class="btn btn-light" style="padding:4px 12px; font-size:12px;">View Jobs</a>
                    </div>
                </div>

                <!-- 2. Marketing & Sales -->
                <div class="company-card">
                    <div>
                        <div class="company-header-bg" style="background: linear-gradient(rgba(15, 23, 42, 0.85), rgba(15, 23, 42, 0.85)), url('https://images.unsplash.com/photo-1533750349033-62f469527e40?auto=format&fit=crop&w=600&q=80') center/cover;">
                            <div class="company-meta">
                                <h3>Ogilvy Global</h3>
                                <p>Marketing & Sales • New York, NY</p>
                            </div>
                            <span class="dark-badge">Verified</span>
                        </div>
                        <p class="company-desc">Crafting iconic brand strategies, global marketing campaigns, and digital growth solutions.</p>
                    </div>
                    <div class="company-footer">
                        <span class="job-count">14 Active Jobs</span>
                        <a href="company-details.php?id=2" class="btn btn-light" style="padding:4px 12px; font-size:12px;">View Jobs</a>
                    </div>
                </div>

                <!-- 3. Healthcare -->
                <div class="company-card">
                    <div>
                        <div class="company-header-bg" style="background: linear-gradient(rgba(15, 23, 42, 0.85), rgba(15, 23, 42, 0.85)), url('https://images.unsplash.com/photo-1584515979956-d9f6e5d09982?auto=format&fit=crop&w=600&q=80') center/cover;">
                            <div class="company-meta">
                                <h3>Mayo Clinic Health</h3>
                                <p>Healthcare & Biotech • Rochester, MN</p>
                            </div>
                            <span class="dark-badge">Verified</span>
                        </div>
                        <p class="company-desc">Leading medical research, patient-first care technology, and health infrastructure.</p>
                    </div>
                    <div class="company-footer">
                        <span class="job-count">22 Active Jobs</span>
                        <a href="company-details.php?id=3" class="btn btn-light" style="padding:4px 12px; font-size:12px;">View Jobs</a>
                    </div>
                </div>

                <!-- 4. Finance -->
                <div class="company-card">
                    <div>
                        <div class="company-header-bg" style="background: linear-gradient(rgba(15, 23, 42, 0.85), rgba(15, 23, 42, 0.85)), url('https://images.unsplash.com/photo-1559526324-4b87b5e36e44?auto=format&fit=crop&w=600&q=80') center/cover;">
                            <div class="company-meta">
                                <h3>Stripe Financial</h3>
                                <p>Finance & Fintech • San Francisco, CA</p>
                            </div>
                            <span class="dark-badge">Verified</span>
                        </div>
                        <p class="company-desc">Building robust economic infrastructure and modern financial payment architecture for internet businesses.</p>
                    </div>
                    <div class="company-footer">
                        <span class="job-count">19 Active Jobs</span>
                        <a href="company-details.php?id=4" class="btn btn-light" style="padding:4px 12px; font-size:12px;">View Jobs</a>
                    </div>
                </div>

                <!-- 5. Design & Creative -->
                <div class="company-card">
                    <div>
                        <div class="company-header-bg" style="background: linear-gradient(rgba(15, 23, 42, 0.85), rgba(15, 23, 42, 0.85)), url('https://images.unsplash.com/photo-1551836022-d5d88e9218df?auto=format&fit=crop&w=600&q=80') center/cover;">
                            <div class="company-meta">
                                <h3>Adobe Creative</h3>
                                <p>Design & Creative • San Jose, CA</p>
                            </div>
                            <span class="dark-badge">Verified</span>
                        </div>
                        <p class="company-desc">Empowering visual creators worldwide with industry-standard digital media and design software.</p>
                    </div>
                    <div class="company-footer">
                        <span class="job-count">11 Active Jobs</span>
                        <a href="company-details.php?id=5" class="btn btn-light" style="padding:4px 12px; font-size:12px;">View Jobs</a>
                    </div>
                </div>

                <!-- 6. Software & Cloud Infrastructure -->
                <div class="company-card">
                    <div>
                        <div class="company-header-bg" style="background: linear-gradient(rgba(15, 23, 42, 0.85), rgba(15, 23, 42, 0.85)), url('https://images.unsplash.com/photo-1521737711867-e3b97375f902?auto=format&fit=crop&w=600&q=80') center/cover;">
                            <div class="company-meta">
                                <h3>Amazon Web Services</h3>
                                <p>Software & Cloud • Seattle, WA</p>
                            </div>
                            <span class="dark-badge">Verified</span>
                        </div>
                        <p class="company-desc">Providing high-performance cloud computing platforms, databases, and deployment APIs.</p>
                    </div>
                    <div class="company-footer">
                        <span class="job-count">35 Active Jobs</span>
                        <a href="company-details.php?id=6" class="btn btn-light" style="padding:4px 12px; font-size:12px;">View Jobs</a>
                    </div>
                </div>

            </div>

        </div>

        <!-- Right Sidebar Area -->
        <div class="right-sidebar">
            
            <div class="widget-box">
                <h4>Top Industries</h4>
                <a href="companies.php?category=Software" class="widget-item"><span>Software Engineering</span> <span>120+</span></a>
                <a href="companies.php?category=Marketing" class="widget-item"><span>Marketing & Sales</span> <span>60+</span></a>
                <a href="companies.php?category=Healthcare" class="widget-item"><span>Healthcare</span> <span>30+</span></a>
                <a href="companies.php?category=Finance" class="widget-item"><span>Finance</span> <span>45+</span></a>
                <a href="companies.php?category=Design" class="widget-item"><span>Design & Creative</span> <span>50+</span></a>
            </div>

            <div class="cta-card">
                <h4>Are you an employer looking to hire?</h4>
                <a href="post-job.php" class="btn btn-dark" style="width:100%;">Create Employer Account</a>
            </div>

            <div class="cta-card">
                <h4>Get your resume noticed by top tech leaders.</h4>
                <a href="signup.php" class="btn btn-primary" style="width:100%;">Join JobConnect</a>
            </div>

        </div>

    </div>

    <!-- Footer matching exact template style -->
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