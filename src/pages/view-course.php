<?php
require_once '../config/config.php';
require_once '../Controllers/SubjectController.php';
require_once '../Controllers/IntroductionController.php';
require_once '../Controllers/PracticalController.php';
include '../components/header.php';

// Initialize Controllers
$subjectController = new SubjectController(GetPDO());
$introductionController = new IntroductionController(GetPDO());
$practicalController = new PracticalController(GetPDO());

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$subject = $id ? $subjectController->getById($id) : null;

// Get introductions and practicals if subject exists
$introductions = $subject ? $introductionController->getBySubjectId($id) : [];
$practicals = $subject ? $practicalController->getBySubjectId($id) : [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Erasmus KA1 Course - TETRA</title>

    <meta name="description" content="Explore the comprehensive details of this training course">
    
    <link rel="icon" type="image/png" href="https://new.tetra.com.mt/public/assets/images/favicon.png">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'tetra-green': '#00ff88',
                        'tetra-dark': '#111',
                        'tetra-gray': '#ccc',
                        'tetra-border': '#333',
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.8s ease-out forwards',
                        'slide-up': 'slideUp 0.6s ease-out forwards',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' }
                        },
                        slideUp: {
                            '0%': { 
                                transform: 'translateY(30px)',
                                opacity: '0'
                            },
                            '100%': { 
                                transform: 'translateY(0)',
                                opacity: '1'
                            }
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/solid.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* Remove initial body opacity transition */
        body {
            background-color: #111;
        }

        [data-animate] {
            opacity: 0;
            transform: translateY(30px);
        }
        
        [data-animate].animate-fade-in {
            animation: fadeIn 0.8s ease-out forwards;
        }
        
        [data-animate].animate-slide-up {
            animation: slideUp 0.6s ease-out forwards;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes slideUp {
            from {
                transform: translateY(30px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        
        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
        .delay-400 { animation-delay: 0.4s; }
    </style>
</head>
<body class="bg-tetra-dark text-tetra-gray font-['Inter']">
    <main>
        <!-- Hero Section -->
        <section class="relative min-h-[50vh] flex flex-col items-center justify-center px-4 sm:px-6 lg:px-8 overflow-hidden">
            <div class="absolute inset-0 z-0">
                <img src="../../public/assets/images/home/edu-books.jpg" alt="Education Background" 
                     class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black/60"></div>
            </div>
            
            <div class="relative z-10 w-20 h-20 mb-8 filter drop-shadow-[0_0_10px_rgba(255,255,255,0.3)]" data-animate="fade-in">
                <img src="../../public/assets/images/favicon.png" alt="TETRA Logo" class="w-full h-full object-contain">
            </div>
            
            <div class="relative z-10 text-center">
                <h1 class="text-[clamp(2rem,5vw,3.5rem)] leading-tight mb-4 text-white font-light tracking-wider" data-animate="fade-in">
                    Erasmus KA1 Course Details
                </h1>
                <p class="text-[clamp(1rem,2vw,1.2rem)] leading-relaxed text-white/90" data-animate="slide-up">
                    Explore the comprehensive details of this training course
                </p>
            </div>
        </section>

        <div class="container mx-auto px-4 py-8">
            <!-- Back Button -->
            <a href="erasmusCourses.php" 
               class="inline-flex items-center gap-3 px-6 py-3 bg-[rgba(0,255,136,0.1)] text-tetra-green border border-tetra-green rounded-full hover:bg-[rgba(0,255,136,0.2)] transition-all duration-300 mb-8 group" 
               data-animate="slide-up">
                <i class="fas fa-arrow-left transform group-hover:-translate-x-1 transition-transform"></i> 
                Back to Course Offerings
            </a>

            <?php if ($subject): ?>
                <div class="bg-gradient-to-br from-[#1a1a1a] to-[#2d2d2d] rounded-xl border-2 border-tetra-border hover:border-tetra-green transition-all duration-300 shadow-[0_10px_30px_rgba(0,255,136,0.08)] max-w-[1400px] mx-auto" data-animate="slide-up">
                    <div class="p-8 lg:p-10">
                        <div class="space-y-8">
                            <div class="border-b border-tetra-border pb-6">
                                <h3 class="text-4xl font-semibold text-white mb-6"><?php echo htmlspecialchars($subject['name']); ?></h3>
                                
                                <!-- Course Meta Information -->
                                <div class="flex flex-wrap gap-4">
                                    <div class="flex items-center gap-3 bg-[rgba(0,255,136,0.1)] px-6 py-3 rounded-full">
                                        <i class="fas fa-graduation-cap text-tetra-green"></i>
                                        <span class="text-tetra-green">KA1 Course</span>
                                    </div>
                                    <div class="flex items-center gap-3 bg-[rgba(0,255,136,0.1)] px-6 py-3 rounded-full">
                                        <i class="fas fa-book text-tetra-green"></i>
                                        <span class="text-tetra-green"><?php echo count($introductions); ?> Modules</span>
                                    </div>
                                    <div class="flex items-center gap-3 bg-[rgba(0,255,136,0.1)] px-6 py-3 rounded-full">
                                        <i class="fas fa-flask text-tetra-green"></i>
                                        <span class="text-tetra-green"><?php echo count($practicals); ?> Activities</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Course Description -->
                            <div class="bg-[rgba(255,255,255,0.05)] p-8 rounded-xl border-l-4 border-tetra-green">
                                <h4 class="text-tetra-green text-2xl font-semibold mb-6 flex items-center gap-3">
                                    <i class="fas fa-info-circle"></i> Course Description
                                </h4>
                                <p class="text-tetra-gray text-lg leading-relaxed"><?php echo nl2br(htmlspecialchars($subject['description'])); ?></p>
                            </div>

                            <!-- Course Modules -->
                            <?php if (!empty($introductions)): ?>
                                <div class="bg-[rgba(255,255,255,0.05)] p-8 rounded-xl border-l-4 border-tetra-green">
                                    <h4 class="text-tetra-green text-2xl font-semibold mb-6 flex items-center justify-between">
                                        <span class="flex items-center gap-3">
                                            <i class="fas fa-book-open"></i>
                                            Course Modules
                                        </span>
                                        <span class="bg-[rgba(0,255,136,0.1)] px-4 py-2 rounded-full text-base">
                                            <?php echo count($introductions); ?>
                                        </span>
                                    </h4>
                                    <div class="space-y-6">
                                        <?php foreach ($introductions as $intro): ?>
                                            <div class="bg-[rgba(0,0,0,0.3)] p-6 rounded-xl hover:border-tetra-green border border-transparent transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_10px_30px_rgba(0,255,136,0.2)]">
                                                <h4 class="text-tetra-green text-xl font-semibold mb-4"><?php echo htmlspecialchars($intro['title']); ?></h4>
                                                <p class="text-tetra-gray text-lg leading-relaxed"><?php echo nl2br(htmlspecialchars($intro['content'])); ?></p>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Practical Activities -->
                            <?php if (!empty($practicals)): ?>
                                <div class="bg-[rgba(255,255,255,0.05)] p-8 rounded-xl border-l-4 border-tetra-green">
                                    <h4 class="text-tetra-green text-2xl font-semibold mb-6 flex items-center justify-between">
                                        <span class="flex items-center gap-3">
                                            <i class="fas fa-flask"></i>
                                            Practical Activities
                                        </span>
                                        <span class="bg-[rgba(0,255,136,0.1)] px-4 py-2 rounded-full text-base">
                                            <?php echo count($practicals); ?>
                                        </span>
                                    </h4>
                                    <div class="space-y-6">
                                        <?php foreach ($practicals as $practical): ?>
                                            <div class="bg-[rgba(0,0,0,0.3)] p-6 rounded-xl hover:border-tetra-green border border-transparent transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_10px_30px_rgba(0,255,136,0.2)]">
                                                <h4 class="text-tetra-green text-xl font-semibold mb-4"><?php echo htmlspecialchars($practical['title']); ?></h4>
                                                <p class="text-tetra-gray text-lg leading-relaxed"><?php echo nl2br(htmlspecialchars($practical['description'])); ?></p>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="bg-[rgba(0,255,136,0.1)] p-8 rounded-xl flex items-center justify-center gap-4 max-w-[1400px] mx-auto" data-animate="slide-up">
                    <i class="fas fa-exclamation-circle text-3xl text-tetra-green"></i>
                    <p class="text-tetra-gray text-xl">Course not found. The requested Erasmus KA1 course may have been removed or is no longer available.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Registration Section -->
        <section class="bg-tetra-dark py-16 mt-16">
            <div class="container mx-auto px-4">
                <h2 class="text-4xl font-bold text-center text-tetra-green mb-12" data-animate="fade-in">
                    How to Register for This Course
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 max-w-[1400px] mx-auto">
                    <!-- Step 1 -->
                    <div class="bg-gradient-to-br from-[#1a1a1a] to-[#2d2d2d] rounded-lg p-6 relative border border-tetra-border hover:border-tetra-green transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_10px_30px_rgba(0,255,136,0.2)]" data-animate="slide-up">
                        <div class="absolute -top-4 -left-4 w-10 h-10 bg-tetra-green rounded-full flex items-center justify-center text-tetra-dark font-bold">1</div>
                        <div class="text-center mb-4">
                            <i class="fas fa-check-circle text-3xl text-tetra-green"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-tetra-green mb-3">Confirm Selection</h3>
                        <p class="text-tetra-gray">Review the course details and ensure it meets your professional development needs.</p>
                    </div>

                    <!-- Step 2 -->
                    <div class="bg-gradient-to-br from-[#1a1a1a] to-[#2d2d2d] rounded-lg p-6 relative border border-tetra-border hover:border-tetra-green transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_10px_30px_rgba(0,255,136,0.2)]" data-animate="slide-up" data-delay="0.1">
                        <div class="absolute -top-4 -left-4 w-10 h-10 bg-tetra-green rounded-full flex items-center justify-center text-tetra-dark font-bold">2</div>
                        <div class="text-center mb-4">
                            <i class="fas fa-handshake text-3xl text-tetra-green"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-tetra-green mb-3">Contact Us</h3>
                        <p class="text-tetra-gray">Get in touch to discuss your interest and check availability.</p>
                        <div class="mt-4 space-y-2">
                            <p class="text-tetra-gray"><i class="fas fa-phone mr-2 text-tetra-green"></i>+356 99660124</p>
                            <p class="text-tetra-gray"><i class="fas fa-envelope mr-2 text-tetra-green"></i>
                                <a href="mailto:info@tetra.com.mt" class="text-tetra-green hover:text-[#33ff9f]">info@tetra.com.mt</a>
                            </p>
                            <a href="https://docs.google.com/forms/d/e/1FAIpQLScTUMNadcZFNP_iAmqsR7WLJ8291Eg3rRqdjaC4wEk0tyimiA/viewform?usp=header" 
                               class="inline-block mt-3 px-4 py-2 bg-[rgba(0,255,136,0.1)] text-tetra-green rounded-full border border-tetra-green hover:bg-[rgba(0,255,136,0.2)] transition-colors duration-200"
                               target="_blank">
                                <i class="fas fa-info-circle mr-2"></i>Request Info
                            </a>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="bg-gradient-to-br from-[#1a1a1a] to-[#2d2d2d] rounded-lg p-6 relative border border-tetra-border hover:border-tetra-green transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_10px_30px_rgba(0,255,136,0.2)]" data-animate="slide-up" data-delay="0.2">
                        <div class="absolute -top-4 -left-4 w-10 h-10 bg-tetra-green rounded-full flex items-center justify-center text-tetra-dark font-bold">3</div>
                        <div class="text-center mb-4">
                            <i class="fas fa-file-contract text-3xl text-tetra-green"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-tetra-green mb-3">Application Process</h3>
                        <p class="text-tetra-gray">We'll guide you through the Erasmus+ KA1 funding application process and provide necessary documentation.</p>
                    </div>

                    <!-- Step 4 -->
                    <div class="bg-gradient-to-br from-[#1a1a1a] to-[#2d2d2d] rounded-lg p-6 relative border border-tetra-border hover:border-tetra-green transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_10px_30px_rgba(0,255,136,0.2)]" data-animate="slide-up" data-delay="0.3">
                        <div class="absolute -top-4 -left-4 w-10 h-10 bg-tetra-green rounded-full flex items-center justify-center text-tetra-dark font-bold">4</div>
                        <div class="text-center mb-4">
                            <i class="fas fa-graduation-cap text-3xl text-tetra-green"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-tetra-green mb-3">Start Learning</h3>
                        <p class="text-tetra-gray">Once approved, join us in Malta for your professional development journey.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include '../components/footer.php'; ?>

    <!-- JavaScript -->
    <script>
        // Remove the body opacity manipulation
        document.addEventListener('DOMContentLoaded', function() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const element = entry.target;
                        const animationType = element.getAttribute('data-animate');
                        const delay = element.getAttribute('data-delay');
                        
                        if (delay) {
                            element.style.animationDelay = delay + 's';
                        }
                        
                        element.classList.add(`animate-${animationType}`);
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '50px'
            });

            document.querySelectorAll('[data-animate]').forEach(element => {
                observer.observe(element);
            });
        });
    </script>
</body>
</html> 