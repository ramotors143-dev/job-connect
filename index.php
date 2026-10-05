<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JobConnect - Find Your Dream Job Today</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        body { background-color: #0d1b2a; color: #1e293b; display: flex; justify-content: center; padding: 20px 0; }
        
        .app-container { width: 92%; max-width: 1280px; background-color: #f4f7fe; border-radius: 20px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.3); display: flex; flex-direction: column; }
        
        header { background: #ffffff; padding: 18px 40px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #e2e8f0; }
        .logo { font-size: 22px; font-weight: 700; color: #0b2545; text-decoration: none; }
        
        .nav-center { display: flex; align-items: center; gap: 15px; font-size: 15px; font-weight: 500; color: #475569; }
        .nav-center a { text-decoration: none; color: #475569; transition: color 0.2s; }
        .nav-center a:hover { color: #2563eb; }
        
        /* Updated Dividers for better visibility */
        .nav-divider { color: #94a3b8; font-weight: 400; font-size: 16px; }

        .nav-right { display: flex; align-items: center; gap: 12px; }
        .btn-post { background: #0f172a; color: #fff; padding: 9px 18px; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 14px; }
        
        /* Updated Log In button styling to match Sign Up style */
        .btn-login { background: #f1f5f9; color: #0f172a; padding: 8px 14px; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 14px; border: 1px solid #e2e8f0; }
        .btn-signup { background: #f1f5f9; color: #0f172a; padding: 8px 16px; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 14px; border: 1px solid #e2e8f0; }

        .main-content { padding: 40px; flex: 1; }

        .hero-section { 
            background: linear-gradient(rgba(15, 23, 42, 0.8), rgba(15, 23, 42, 0.8)), url('https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=1200&q=80') center/cover no-repeat; 
            border-radius: 16px; 
            padding: 70px 40px; 
            color: white; 
            margin-bottom: 40px;
        }
        .hero-title { font-size: 42px; font-weight: 700; margin-bottom: 12px; }
        .hero-subtitle { font-size: 17px; color: #cbd5e1; margin-bottom: 30px; }

        /* Search Form Container */
        .search-box-container {
            background: #ffffff;
            border-radius: 12px;
            padding: 8px 12px;
            display: flex;
            align-items: center;
            max-width: 850px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        .search-input-group {
            display: flex;
            align-items: center;
            flex: 1;
            padding: 10px 15px;
        }
        .search-input-group i { color: #64748b; margin-right: 10px; font-size: 16px; }
        .search-input-group input {
            border: none;
            outline: none;
            width: 100%;
            font-size: 15px;
            color: #0f172a;
            background: transparent;
        }
        .search-divider { width: 1px; height: 30px; background: #cbd5e1; }
        .search-btn {
            background: #2563eb;
            color: white;
            border: none;
            padding: 14px 28px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            transition: background 0.2s;
        }
        .search-btn:hover { background: #1d4ed8; }

        .section-title { font-size: 24px; font-weight: 700; color: #0f172a; margin-bottom: 20px; }
        .categories-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 50px; }
        .category-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            padding: 25px 20px;
            border-radius: 12px;
            text-align: center;
            text-decoration: none;
            color: #334155;
            transition: all 0.2s;
            box-shadow: 0 2px 8px rgba(0,0,0,0.02);
        }
        .category-card:hover { border-color: #2563eb; box-shadow: 0 6px 15px rgba(37,99,235,0.08); transform: translateY(-3px); }
        .category-card i { font-size: 28px; color: #2563eb; margin-bottom: 12px; display: block; }
        .category-card span { font-size: 15px; font-weight: 600; }

        .features-section { background: #ffffff; border-radius: 16px; padding: 40px; border: 1px solid #e2e8f0; margin-bottom: 50px; }
        .features-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 30px; margin-top: 25px; }
        .feature-item h4 { font-size: 18px; color: #0f172a; margin-bottom: 8px; display: flex; align-items: center; gap: 10px; }
        .feature-item h4 i { color: #2563eb; }
        .feature-item p { font-size: 14px; color: #64748b; line-height: 1.6; }

        footer {
            background: #0f172a;
            color: #94a3b8;
            padding: 50px 40px 30px 40px;
            border-top: 1px solid #1e293b;
        }
        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }
        .footer-col h3 { color: #ffffff; font-size: 16px; font-weight: 600; margin-bottom: 18px; }
        .footer-col ul { list-style: none; }
        .footer-col ul li { margin-bottom: 10px; }
        .footer-col ul li a { color: #94a3b8; text-decoration: none; font-size: 14px; transition: color 0.2s; }
        .footer-col ul li a:hover { color: #ffffff; }
        .footer-bottom { text-align: center; border-top: 1px solid #1e293b; padding-top: 20px; font-size: 13px; color: #64748b; }
    </style>
</head>
<body>

<div class="app-container">
    <header>
        <a href="index.php" class="logo">JobConnect</a>
        
        <div class="nav-center">
            <a href="index.php" style="color: #2563eb; font-weight: 600;">Home</a>
            <span class="nav-divider">|</span>
            <a href="jobs.php">Find Jobs</a>
            <span class="nav-divider">|</span>
            <a href="companies.php">Companies</a>
            <span class="nav-divider">|</span>
            <a href="career-advice.php">Career Advice</a>
        </div>

        <div class="nav-right">
            <a href="post-job.php" class="btn-post">Post a Job</a>
            <a href="login.php" class="btn-login">Log In</a>
            <a href="signup.php" class="btn-signup">Sign Up</a>
        </div>
    </header>

    <div class="main-content">
        <!-- Hero Section with Working Search Form -->
        <div class="hero-section">
            <h1 class="hero-title">Find Your Dream Job Today</h1>
            <p class="hero-subtitle">Discover thousands of career opportunities & high-paying jobs from top global companies.</p>
            
            <!-- Search Form sending keyword (Job title) & location (City) to jobs.php -->
            <form action="jobs.php" method="GET" class="search-box-container">
                <div class="search-input-group">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" name="keyword" placeholder="Job title, keywords, or company" required>
                </div>
                <div class="search-divider"></div>
                <div class="search-input-group">
                    <i class="fa-solid fa-location-dot"></i>
                    <input type="text" name="location" placeholder="City, state, or remote" required>
                </div>
                <button type="submit" class="search-btn">Search Jobs</button>
            </form>
        </div>

        <h2 class="section-title">Most Popular Job Categories</h2>
        <div class="categories-grid">
            <a href="jobs.php?category=Software" class="category-card">
                <i class="fa-solid fa-laptop-code"></i>
                <span>Software Engineering</span>
            </a>
            <a href="jobs.php?category=Marketing" class="category-card">
                <i class="fa-solid fa-bullhorn"></i>
                <span>Marketing & Sales</span>
            </a>
            <a href="jobs.php?category=Healthcare" class="category-card">
                <i class="fa-solid fa-house-medical"></i>
                <span>Healthcare</span>
            </a>
            <a href="jobs.php?category=Finance" class="category-card">
                <i class="fa-solid fa-wallet"></i>
                <span>Finance</span>
            </a>
            <a href="jobs.php?category=Design" class="category-card">
                <i class="fa-solid fa-pen-nib"></i>
                <span>Design & Creative</span>
            </a>
        </div>

        <div class="features-section">
            <h2 class="section-title" style="margin-bottom: 10px;">Why Professionals Choose JobConnect</h2>
            <p style="color: #64748b; font-size: 15px; margin-bottom: 20px;">We connect top-tier talent with world-class organizations seamlessly.</p>
            
            <div class="features-grid">
                <div class="feature-item">
                    <h4><i class="fa-solid fa-circle-check"></i> Verified Companies</h4>
                    <p>Every single employer and organization on our portal is verified to guarantee complete security and genuine career growth.</p>
                </div>
                <div class="feature-item">
                    <h4><i class="fa-solid fa-bolt"></i> Instant Application</h4>
                    <p>Apply to your dream jobs with just a single click using our high-speed, streamlined application submission system.</p>
                </div>
                <div class="feature-item">
                    <h4><i class="fa-solid fa-headset"></i> 24/7 Career Support</h4>
                    <p>Access specialized career advice, resume-building guides, and expert tips to accelerate your professional journey.</p>
                </div>
            </div>
        </div>
    </div>

   <footer>
        <div class="footer-grid">
            <div class="footer-col">
                <h3>About Us</h3>
                <ul>
                    <li><a href="about.php">About Us</a></li>
                         <li><a href="profiles.php">My Profile</a></li>
                    <li><a href="terms.php">Terms of Service</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h3>Contact</h3>
                <ul>
                    <li><a href="contact.php">Contact Us</a></li>
                    <li><a href="privacy.php">Privacy Policy</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h3>Privacy Policy</h3>
                <ul>
                    <li><a href="privacy.php">Privacy Policy</a></li>
                    <li><a href="terms.php">Terms of Use</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h3>Terms of Service</h3>
                <ul>
                    <li><a href="terms.php">Terms & Conditions</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            &copy; 2026 JobConnect. All rights reserved.
        </div>
    </footer>
</div>

</body>
</html>