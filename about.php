<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - JobConnect</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }
    </style>
</head>
<body class="bg-[#f8f9fa] text-gray-800">

    <!-- Header / Navbar -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <div class="flex items-center space-x-2">
                <span class="text-2xl font-bold text-slate-800 tracking-tight">JobConnect</span>
            </div>

            <nav class="hidden md:flex items-center space-x-8 text-sm font-medium text-gray-600">
                <a href="index.php" class="hover:text-blue-600 transition">Home</a>
                <a href="jobs.php" class="hover:text-blue-600 transition">Find Jobs</a>
                <a href="companies.php" class="hover:text-blue-600 transition">Companies</a>
                <a href="career-advice.php" class="hover:text-blue-600 transition">Career Advice</a>
                <a href="about.php" class="text-blue-600 font-semibold">About Us</a>
            </nav>

            <div class="flex items-center space-x-4">
                <a href="post-job.php" class="bg-slate-200 hover:bg-slate-300 text-slate-800 px-4 py-2 rounded-lg text-sm font-medium transition">Post a Job</a>
                <a href="login.php" class="text-sm font-medium text-gray-600 hover:text-blue-600 transition">Log In</a>
                <a href="signup.php" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">Sign Up</a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
        <div class="bg-slate-900 rounded-2xl overflow-hidden text-white py-20 px-8 md:px-16 text-center relative shadow-xl">
            <h1 class="text-3xl md:text-5xl font-bold mb-4">Empowering Careers, Connecting Futures</h1>
            <p class="text-gray-300 max-w-2xl mx-auto text-base md:text-lg leading-relaxed">
                JobConnect is dedicated to bridging the gap between talented professionals and top global enterprises. Your dream career path starts right here.
            </p>
        </div>
    </section>

    <!-- Who We Are Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-2xl md:text-3xl font-bold text-slate-900 mb-6">Who We Are</h2>
                <p class="text-gray-600 mb-4 leading-relaxed">
                    Founded with a vision to simplify the job search process, JobConnect leverages cutting-edge technology to match job seekers with employers who value their unique skills and potential.
                </p>
                <p class="text-gray-600 leading-relaxed mb-6">
                    Whether you are an entry-level professional looking to kickstart your career or an experienced expert aiming for leadership roles, our platform provides the tools, resources, and listings you need to succeed.
                </p>
                <div class="flex space-x-4">
                    <a href="jobs.php" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-medium transition">Explore Jobs</a>
                    <a href="contact.php" class="bg-white border border-gray-300 hover:bg-gray-50 text-slate-800 px-6 py-3 rounded-xl font-medium transition">Contact Us</a>
                </div>
            </div>
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                <div class="grid grid-cols-2 gap-6 text-center">
                    <div class="p-6 bg-blue-50 rounded-xl">
                        <h3 class="text-3xl font-bold text-blue-600 mb-1">10k+</h3>
                        <p class="text-sm text-gray-600">Active Jobs</p>
                    </div>
                    <div class="p-6 bg-blue-50 rounded-xl">
                        <h3 class="text-3xl font-bold text-blue-600 mb-1">500+</h3>
                        <p class="text-sm text-gray-600">Global Companies</p>
                    </div>
                    <div class="p-6 bg-blue-50 rounded-xl">
                        <h3 class="text-3xl font-bold text-blue-600 mb-1">50k+</h3>
                        <p class="text-sm text-gray-600">Job Seekers</p>
                    </div>
                    <div class="p-6 bg-blue-50 rounded-xl">
                        <h3 class="text-3xl font-bold text-blue-600 mb-1">95%</h3>
                        <p class="text-sm text-gray-600">Success Rate</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission & Vision Section -->
    <section class="bg-white py-16 border-y border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <div class="p-8 bg-slate-50 rounded-2xl border border-gray-100">
                    <h3 class="text-2xl font-bold text-slate-900 mb-4">Our Mission</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Our mission is to remove friction from the hiring process by creating a transparent, fast, and reliable marketplace. We empower job seekers with direct access to quality employment opportunities while helping organizations build phenomenal teams without hassle.
                    </p>
                </div>
                <div class="p-8 bg-slate-50 rounded-2xl border border-gray-100">
                    <h3 class="text-2xl font-bold text-slate-900 mb-4">Our Vision</h3>
                    <p class="text-gray-600 leading-relaxed">
                        To become the world's most trusted career advancement ecosystem. We envision a future where talent is recognized globally irrespective of boundaries, and finding the right job or candidate takes minutes instead of months.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="text-center max-w-3xl mx-auto mb-12">
            <h2 class="text-3xl font-bold text-slate-900 mb-4">Why Choose JobConnect?</h2>
            <p class="text-gray-600">We stand out because we put our community first, offering unmatched features designed for your growth.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center font-bold text-xl mb-4">✓</div>
                <h4 class="text-xl font-bold text-slate-900 mb-2">Verified Companies</h4>
                <p class="text-gray-600 text-sm leading-relaxed">Every company listing on our platform goes through strict vetting to ensure safe and authentic employment offers.</p>
            </div>
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center font-bold text-xl mb-4">⚡</div>
                <h4 class="text-xl font-bold text-slate-900 mb-2">Instant Applications</h4>
                <p class="text-gray-600 text-sm leading-relaxed">Apply to multiple high-paying job openings with just a single click using your uploaded master resume.</p>
            </div>
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center font-bold text-xl mb-4">🔒</div>
                <h4 class="text-xl font-bold text-slate-900 mb-2">Privacy Control</h4>
                <p class="text-gray-600 text-sm leading-relaxed">You have complete control over who sees your personal information and professional history.</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-16 py-8 text-center text-sm text-gray-500">
        <p>&copy; 2026 JobConnect. All rights reserved.</p>
    </footer>

</body>
</html>