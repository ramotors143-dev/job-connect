<?php 
require_once 'config.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Career Advice - JobConnect</title>
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
                        url('https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=1200&q=80'); 
            background-size: cover; 
            background-position: center; 
            border-radius: 16px; 
            padding: 70px 40px; 
            margin-bottom: 30px; 
        }
        .hero-section h1 { font-size: 38px; color: #ffffff; margin-bottom: 10px; font-weight: 700; }
        .hero-section p { color: #e2e8f0; margin-bottom: 25px; font-size: 16px; }
        
        /* Search Box */
        .search-box { background: #ffffff; padding: 8px; border-radius: 12px; display: flex; gap: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.15); }
        .search-input { flex: 1; display: flex; align-items: center; background: #f8fafc; padding: 12px 15px; border-radius: 8px; border: 1px solid #e2e8f0; }
        .search-input i { color: #94a3b8; margin-right: 10px; }
        .search-input input { border: none; background: transparent; outline: none; width: 100%; font-size: 14px; }
        
        .section-title { font-size: 20px; font-weight: 700; color: #0f172a; margin-bottom: 18px; }
        
        /* Article Cards Grid */
        .article-card { background: #ffffff; border-radius: 12px; padding: 20px; margin-bottom: 20px; box-shadow: 0 2px 6px rgba(0,0,0,0.03); display: flex; gap: 20px; align-items: center; }
        .article-img { width: 140px; height: 100px; border-radius: 10px; object-fit: cover; background: #1e293b; }
        .article-body h3 { font-size: 17px; color: #0f172a; margin-bottom: 6px; }
        .article-body p { font-size: 13px; color: #64748b; margin-bottom: 12px; line-height: 1.5; }
        .article-meta { font-size: 11px; color: #94a3b8; font-weight: 600; }
        
        /* Categories Cards */
        .advice-cat-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 30px; }
        .advice-cat-card { background: #ffffff; padding: 20px; border-radius: 12px; text-align: center; border: 1px solid #e2e8f0; }
        .advice-cat-card i { font-size: 28px; color: #2563eb; margin-bottom: 10px; }
        .advice-cat-card h4 { font-size: 15px; color: #0f172a; margin-bottom: 4px; }
        .advice-cat-card p { font-size: 12px; color: #64748b; }
        
        /* Sidebar Widgets */
        .widget-box { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px; margin-bottom: 20px; }
        .widget-box h4 { font-size: 15px; color: #0f172a; margin-bottom: 12px; }
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
            <a href="career-advice.php" class="active">Career Advice</a>
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
        
        <!-- Left Main Content Column -->
        <div class="left-content">
            
            <!-- Dark Overlay Hero Banner -->
            <div class="hero-section">
                <h1>Expert Career Advice & Resources</h1>
                <p>Grow your career with industry guides, resume tips, and interview preparation.</p>
                
                <form action="career-advice.php" method="GET" class="search-box">
                    <div class="search-input">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" name="search" placeholder="Search articles, resume guides, interview tips...">
                    </div>
                    <button type="submit" class="btn btn-primary">Search Advice</button>
                </form>
            </div>

            <!-- Advice Categories Grid -->
            <h2 class="section-title">Explore Topics</h2>
            <div class="advice-cat-grid">
                <div class="advice-cat-card">
                    <i class="fa-solid fa-file-contract"></i>
                    <h4>Resume Building</h4>
                    <p>Templates & Pro Tips</p>
                </div>
                <div class="advice-cat-card">
                    <i class="fa-solid fa-user-check"></i>
                    <h4>Interview Prep</h4>
                    <p>Questions & Answers</p>
                </div>
                <div class="advice-cat-card">
                    <i class="fa-solid fa-chart-line"></i>
                    <h4>Career Growth</h4>
                    <p>Salary & Promotions</p>
                </div>
            </div>

            <h2 class="section-title">Latest Articles & Guides</h2>

            <!-- Long List of Articles -->
            <div class="article-card">
                <img src="https://images.unsplash.com/photo-1586281380349-632531db7ed4?auto=format&fit=crop&w=400&q=80" class="article-img" alt="Resume">
                <div class="article-body">
                    <h3>10 Secrets to Write a Standout Software Developer Resume</h3>
                    <p>Learn how to highlight your technical skills, projects, and work experience to catch recruiters' attention instantly.</p>
                    <span class="article-meta">5 min read • Resume Tips</span>
                </div>
            </div>

            <div class="article-card">
                <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=400&q=80" class="article-img" alt="Interview">
                <div class="article-body">
                    <h3>How to Crack Technical & Behavioral Job Interviews</h3>
                    <p>Master the STAR method to answer tough interview questions with confidence and land your dream job offer.</p>
                    <span class="article-meta">8 min read • Interview Preparation</span>
                </div>
            </div>

            <div class="article-card">
                <img src="https://images.unsplash.com/photo-1551836022-d5d88e9218df?auto=format&fit=crop&w=400&q=80" class="article-img" alt="Salary">
                <div class="article-body">
                    <h3>Negotiating Your Salary: Tips for Tech Professionals</h3>
                    <p>Strategies for asking for a higher salary, equity, and remote work perks during job offer negotiations.</p>
                    <span class="article-meta">6 min read • Career Growth</span>
                </div>
            </div>

            <div class="article-card">
                <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=400&q=80" class="article-img" alt="Remote Work">
                <div class="article-body">
                    <h3>How to Transition to a High-Paying Remote Role</h3>
                    <p>Discover top platforms and habits that top developers use to get hired by international remote companies.</p>
                    <span class="article-meta">7 min read • Remote Work</span>
                </div>
            </div>

        </div>

        <!-- Right Sidebar Area -->
        <div class="right-sidebar">
            
            <div class="widget-box">
                <h4>Popular Career Guides</h4>
                <div class="widget-item"><i class="fa-solid fa-circle-check"></i> <span>Full-Stack Roadmap 2026</span></div>
                <div class="widget-item"><i class="fa-solid fa-circle-check"></i> <span>PHP/MySQL Project Portfolio Guide</span></div>
                <div class="widget-item"><i class="fa-solid fa-circle-check"></i> <span>LinkedIn Profile Optimization</span></div>
                <div class="widget-item"><i class="fa-solid fa-circle-check"></i> <span>A/B Testing Your Cover Letter</span></div>
            </div>

            <div class="cta-card">
                <h4>Ready to take the next step in your career?</h4>
                <a href="signup.php" class="btn btn-primary" style="width:100%;">Create Free Account</a>
            </div>

            <div class="cta-card">
                <h4>Explore top hiring tech companies.</h4>
                <a href="companies.php" class="btn btn-dark" style="width:100%;">View Directory</a>
            </div>

        </div>

    </div>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <div class="footer-col">
                <h5>About Us</h5>
                <a href="about.php">About Us</a>
                     <li><a href="profiles.php">My Profile</a></li>
            </div>
            <div class="footer-col">
                <h5>Contact</h5>
                <a href="contact.php">Contact Us</a>
            </div>
            <div class="footer-col">
                <h5>Privacy Policy</h5>
                <a href="privacy.php">Privacy Policy</a>
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