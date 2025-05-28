<?php
require_once '../config/config.php';
require_once '../Controllers/SubjectController.php';
require_once '../Controllers/IntroductionController.php';
require_once '../Controllers/PracticalController.php';

// Initialize Controllers
$subjectController = new SubjectController(GetPDO());
$introductionController = new IntroductionController(GetPDO());
$practicalController = new PracticalController(GetPDO());

// Get all subjects (courses)
$subjects = $subjectController->getAll();

// Get total counts
$totalIntroductions = $introductionController->getTotalIntroductions();
$totalPracticals = $practicalController->getTotalPracticals();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erasmus KA1 Course Offerings - TETRA</title>
    <link rel="icon" type="image/png" href="https://tetra.com.mt/public/assets/images/favicon.png">
    
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
                        'fade-in': 'fade-in 0.6s ease-out forwards',
                        'slide-up': 'slide-up 0.6s ease-out forwards',
                    },
                    keyframes: {
                        'fade-in': {
                            '0%': { 
                                opacity: '0'
                            },
                            '100%': { 
                                opacity: '1'
                            }
                        },
                        'slide-up': {
                            '0%': { 
                                transform: 'translateY(20px)',
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { 
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
        }
        [data-animate] {
            opacity: 0;
            transform: translateY(20px);
        }
        [data-animate].animate-fade-in {
            animation: fade-in 0.6s ease-out forwards;
        }
        [data-animate].animate-slide-up {
            animation: slide-up 0.6s ease-out forwards;
        }
        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
        .delay-400 { animation-delay: 0.4s; }
        .expandable-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }
        
        .expandable-content.hidden {
            display: none;
        }

        .fa-chevron-down {
            transition: transform 0.3s ease;
        }
    </style>
</head>
<body class="bg-tetra-dark text-tetra-gray">
    <?php include '../components/header.php'; ?>
    
    <main class="min-h-screen">
        <!-- Hero Section -->
        <section class="relative min-h-screen flex flex-col items-center justify-center px-4 sm:px-6 lg:px-8 overflow-hidden">
            <!-- Background Image -->
            <div class="absolute inset-0 z-0">
                <img src="../../public/assets/images/home/edu-books.jpg" alt="Education Background" 
                     class="w-full h-full object-cover">
                <!-- Dark Overlay -->
                <div class="absolute inset-0 bg-black/60"></div>
            </div>

            <!-- Logo -->
            <div class="relative z-10 w-20 h-20 mb-16 sm:mb-14 md:mb-[60px] filter drop-shadow-[0_0_10px_rgba(255,255,255,0.3)]" data-animate>
                <img src="../../public/assets/images/favicon.png" 
                     alt="TETRA Logo" 
                     class="w-full h-full object-contain">
            </div>

            <!-- Content -->
            <div class="relative z-10 text-center max-w-3xl mx-auto px-4">
                <h1 class="text-[clamp(2rem,5vw,3.5rem)] leading-tight mb-6 text-white font-light tracking-wider" data-animate>
                    Erasmus KA1 Course Offerings
                </h1>
                <p class="text-[clamp(1rem,2vw,1.2rem)] leading-relaxed text-white/90 mb-12" data-animate>
                    Discover our comprehensive range of Erasmus KA1 training courses designed for professional development
                </p>
                <div class="flex flex-wrap justify-center gap-6" data-animate>
                    <div class="flex items-center gap-3 bg-white/10 backdrop-blur-sm px-6 py-3 rounded-full">
                        <i class="fas fa-book text-tetra-green text-xl"></i>
                        <span class="text-white text-lg"><?php echo $totalIntroductions; ?> Learning Modules</span>
                    </div>
                    <div class="flex items-center gap-3 bg-white/10 backdrop-blur-sm px-6 py-3 rounded-full">
                        <i class="fas fa-flask text-tetra-green text-xl"></i>
                        <span class="text-white text-lg"><?php echo $totalPracticals; ?> Practical Activities</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Course Info Section -->
        <section class="py-16">
            <div class="container mx-auto px-4">
                <h2 class="text-4xl font-bold text-center text-tetra-green mb-12" data-animate>Available KA1 Courses</h2>
                <div class="bg-[rgba(0,255,136,0.1)] p-6 rounded-lg mb-12 flex items-start gap-4 delay-100" data-animate>
                    <i class="fas fa-info-circle text-2xl text-tetra-green mt-1"></i>
                    <p class="text-tetra-gray">TETRA offers a diverse range of Erasmus KA1 courses designed to enhance professional development in education. Each course includes comprehensive learning modules and hands-on practical activities.</p>
                </div>

                <div class="flex flex-col gap-12 max-w-[1400px] mx-auto">
                    <?php if (!empty($subjects)): ?>
                        <?php foreach ($subjects as $index => $subject): ?>
                            <?php 
                            $introductions = $introductionController->getBySubjectId($subject['id']);
                            $practicals = $practicalController->getBySubjectId($subject['id']);
                            $totalSubjectIntros = $introductionController->getTotalIntroductionsForSubject($subject['id']);
                            $totalSubjectPracticals = $practicalController->getTotalPracticalsForSubject($subject['id']);
                            $delay = ($index % 3 + 1) * 100;
                            ?>
                            <div class="bg-gradient-to-br from-[#1a1a1a] to-[#2d2d2d] rounded-xl border-2 border-tetra-border hover:border-tetra-green transition-all duration-300 hover:-translate-y-2 hover:shadow-[0_10px_30px_rgba(0,255,136,0.2)] w-full delay-<?php echo $delay; ?>" data-animate>
                                <div class="p-10">
                                    <div>
                                        <h3 class="text-4xl font-semibold text-tetra-green mb-8"><?php echo htmlspecialchars($subject['name']); ?></h3>
                                        
                                        <!-- Course Meta Information -->
                                        <div class="flex flex-wrap gap-4 mb-10">
                                            <div class="flex items-center gap-3 bg-[rgba(0,255,136,0.1)] px-6 py-3 rounded-full">
                                                <i class="fas fa-graduation-cap text-tetra-green text-xl"></i>
                                                <span class="text-tetra-green text-lg">KA1 Course</span>
                                            </div>
                                            <div class="flex items-center gap-3 bg-[rgba(0,255,136,0.1)] px-6 py-3 rounded-full">
                                                <i class="fas fa-book text-tetra-green text-xl"></i>
                                                <span class="text-tetra-green text-lg"><?php echo $totalSubjectIntros; ?> Modules</span>
                                            </div>
                                            <div class="flex items-center gap-3 bg-[rgba(0,255,136,0.1)] px-6 py-3 rounded-full">
                                                <i class="fas fa-flask text-tetra-green text-xl"></i>
                                                <span class="text-tetra-green text-lg"><?php echo $totalSubjectPracticals; ?> Activities</span>
                                            </div>
                                        </div>

                                        <!-- Course Overview -->
                                        <div class="bg-[rgba(255,255,255,0.05)] p-8 rounded-xl border-l-4 border-tetra-green mb-10">
                                            <h4 class="text-tetra-green text-2xl font-semibold mb-6 flex items-center gap-3">
                                                <i class="fas fa-info-circle"></i> Course Overview
                                            </h4>
                                            <p class="text-tetra-gray leading-relaxed text-lg">
                                                <?php echo nl2br(htmlspecialchars(substr($subject['description'], 0, 500))); ?>
                                                <?php if (strlen($subject['description']) > 500): ?>...</p>
                                            <?php endif; ?>
                                        </div>

                                        <div class="flex flex-col sm:flex-row gap-6">
                                            <!-- Expand button -->
                                            <button class="expand-details-btn flex-1 bg-[rgba(0,255,136,0.1)] text-tetra-green border-2 border-tetra-green px-8 py-4 rounded-xl hover:bg-[rgba(0,255,136,0.2)] transition-all duration-300 flex items-center justify-center gap-3 text-lg font-medium">
                                                <i class="fas fa-chevron-down transition-transform duration-300"></i> 
                                                <span class="button-text">Show Full Details</span>
                                            </button>

                                            <!-- More Details Button -->
                                            <a href="view-course.php?id=<?php echo urlencode($subject['id']); ?>" 
                                               class="flex-1 inline-flex items-center justify-center bg-tetra-green text-tetra-dark px-8 py-4 rounded-xl font-semibold hover:bg-[#33ff9f] transition-all duration-300 text-lg">
                                                View Course Details <i class="fas fa-arrow-right ml-3"></i>
                                            </a>
                                        </div>

                                        <!-- Expandable Content -->
                                        <div class="expandable-content hidden mt-10 space-y-8 overflow-hidden transition-all duration-300" style="max-height: 0;">
                                            <!-- Full Course Description -->
                                            <?php if (strlen($subject['description']) > 500): ?>
                                                <div class="bg-[rgba(255,255,255,0.05)] p-8 rounded-xl border-l-4 border-tetra-green">
                                                    <h4 class="text-tetra-green text-2xl font-semibold mb-6 flex items-center gap-3">
                                                        <i class="fas fa-info-circle"></i> Full Course Description
                                                    </h4>
                                                    <p class="text-tetra-gray leading-relaxed text-lg"><?php echo nl2br(htmlspecialchars($subject['description'])); ?></p>
                                                </div>
                                            <?php endif; ?>

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
                                                    <ul class="space-y-6">
                                                        <?php foreach ($introductions as $intro): ?>
                                                            <li class="bg-[rgba(0,0,0,0.3)] p-6 rounded-xl">
                                                                <h4 class="text-tetra-green text-xl font-semibold mb-4"><?php echo htmlspecialchars($intro['title']); ?></h4>
                                                                <p class="text-tetra-gray text-lg leading-relaxed"><?php echo nl2br(htmlspecialchars($intro['content'])); ?></p>
                                                            </li>
                                                        <?php endforeach; ?>
                                                    </ul>
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
                                                    <ul class="space-y-6">
                                                        <?php foreach ($practicals as $practical): ?>
                                                            <li class="bg-[rgba(0,0,0,0.3)] p-6 rounded-xl">
                                                                <h4 class="text-tetra-green text-xl font-semibold mb-4"><?php echo htmlspecialchars($practical['title']); ?></h4>
                                                                <p class="text-tetra-gray text-lg leading-relaxed"><?php echo nl2br(htmlspecialchars($practical['description'])); ?></p>
                                                            </li>
                                                        <?php endforeach; ?>
                                                    </ul>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="bg-[rgba(0,255,136,0.1)] p-8 rounded-xl flex items-center justify-center gap-4 delay-100" data-animate>
                            <i class="fas fa-info-circle text-3xl text-tetra-green"></i>
                            <p class="text-tetra-gray text-xl">No Erasmus KA1 courses are currently available. Please check back later.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- Benefits Section -->
        <section class="py-16 bg-gradient-to-br from-[#1a1a1a] to-[#2d2d2d]">
            <div class="container mx-auto px-4">
                <h2 class="text-4xl font-bold text-center text-tetra-green mb-12" data-animate>Why Choose Our KA1 Courses?</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div class="bg-[rgba(255,255,255,0.05)] p-6 rounded-lg border border-tetra-border hover:border-tetra-green transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_10px_30px_rgba(0,255,136,0.2)] delay-100" data-animate>
                        <div class="text-center mb-4">
                            <i class="fas fa-check-circle text-4xl text-tetra-green"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-tetra-green text-center mb-3">Erasmus+ Approved</h3>
                        <p class="text-tetra-gray text-center">All our courses are designed to meet Erasmus+ KA1 mobility requirements</p>
                    </div>
                    <div class="bg-[rgba(255,255,255,0.05)] p-6 rounded-lg border border-tetra-border hover:border-tetra-green transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_10px_30px_rgba(0,255,136,0.2)] delay-200" data-animate>
                        <div class="text-center mb-4">
                            <i class="fas fa-user-tie text-4xl text-tetra-green"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-tetra-green text-center mb-3">Expert Trainers</h3>
                        <p class="text-tetra-gray text-center">Learn from experienced professionals with extensive teaching and training backgrounds</p>
                    </div>
                    <div class="bg-[rgba(255,255,255,0.05)] p-6 rounded-lg border border-tetra-border hover:border-tetra-green transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_10px_30px_rgba(0,255,136,0.2)] delay-300" data-animate>
                        <div class="text-center mb-4">
                            <i class="fas fa-hands-helping text-4xl text-tetra-green"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-tetra-green text-center mb-3">Practical Focus</h3>
                        <p class="text-tetra-gray text-center">Gain hands-on experience and ready-to-use resources for your institution</p>
                    </div>
                    <div class="bg-[rgba(255,255,255,0.05)] p-6 rounded-lg border border-tetra-border hover:border-tetra-green transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_10px_30px_rgba(0,255,136,0.2)] delay-400" data-animate>
                        <div class="text-center mb-4">
                            <i class="fas fa-users text-4xl text-tetra-green"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-tetra-green text-center mb-3">Networking Opportunities</h3>
                        <p class="text-tetra-gray text-center">Connect with educators from across Europe and build lasting professional relationships</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Registration Section -->
        <section class="bg-[#111] py-16">
            <div class="container mx-auto px-4">
                <h2 class="text-4xl font-bold text-center text-tetra-green mb-12" data-animate>How to Register for KA1 Courses</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <!-- Step 1 -->
                    <div class="bg-gradient-to-br from-[#1a1a1a] to-[#2d2d2d] rounded-lg p-6 relative border border-tetra-border hover:border-tetra-green transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_10px_30px_rgba(0,255,136,0.2)] delay-100" data-animate>
                        <div class="absolute -top-4 -left-4 w-10 h-10 bg-[#00ff88] rounded-full flex items-center justify-center text-[#111] font-bold">1</div>
                        <div class="text-center mb-4">
                            <i class="fas fa-search text-3xl text-[#00ff88]"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-[#00ff88] mb-3">Select Your Course</h3>
                        <p class="text-[#ccc]">Browse our KA1 courses and choose the one that aligns with your professional development goals.</p>
                    </div>

                    <!-- Step 2 -->
                    <div class="bg-gradient-to-br from-[#1a1a1a] to-[#2d2d2d] rounded-lg p-6 relative border border-tetra-border hover:border-tetra-green transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_10px_30px_rgba(0,255,136,0.2)] delay-200" data-animate>
                        <div class="absolute -top-4 -left-4 w-10 h-10 bg-[#00ff88] rounded-full flex items-center justify-center text-[#111] font-bold">2</div>
                        <div class="text-center mb-4">
                            <i class="fas fa-handshake text-3xl text-[#00ff88]"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-[#00ff88] mb-3">Contact Us</h3>
                        <p class="text-[#ccc]">Get in touch to discuss your interest and check availability.</p>
                        <div class="mt-4 space-y-2">
                            <p class="text-[#ccc]"><i class="fas fa-phone mr-2 text-[#00ff88]"></i>+356 99660124</p>
                            <p class="text-[#ccc]"><i class="fas fa-envelope mr-2 text-[#00ff88]"></i><a href="mailto:info@tetra.com.mt" class="text-[#00ff88] hover:text-[#33ff9f]">info@tetra.com.mt</a></p>
                            <a href="https://docs.google.com/forms/d/e/1FAIpQLScTUMNadcZFNP_iAmqsR7WLJ8291Eg3rRqdjaC4wEk0tyimiA/viewform?usp=header" 
                               class="inline-block mt-3 px-4 py-2 bg-[rgba(0,255,136,0.1)] text-[#00ff88] rounded-full border border-[#00ff88] hover:bg-[rgba(0,255,136,0.2)] transition-colors duration-200"
                               target="_blank">
                                <i class="fas fa-info-circle mr-2"></i>Request Info
                            </a>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="bg-gradient-to-br from-[#1a1a1a] to-[#2d2d2d] rounded-lg p-6 relative border border-tetra-border hover:border-tetra-green transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_10px_30px_rgba(0,255,136,0.2)] delay-300" data-animate>
                        <div class="absolute -top-4 -left-4 w-10 h-10 bg-[#00ff88] rounded-full flex items-center justify-center text-[#111] font-bold">3</div>
                        <div class="text-center mb-4">
                            <i class="fas fa-file-contract text-3xl text-[#00ff88]"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-[#00ff88] mb-3">Application Process</h3>
                        <p class="text-[#ccc]">We'll guide you through the Erasmus+ KA1 funding application process and provide necessary documentation.</p>
                    </div>

                    <!-- Step 4 -->
                    <div class="bg-gradient-to-br from-[#1a1a1a] to-[#2d2d2d] rounded-lg p-6 relative border border-tetra-border hover:border-tetra-green transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_10px_30px_rgba(0,255,136,0.2)] delay-400" data-animate>
                        <div class="absolute -top-4 -left-4 w-10 h-10 bg-[#00ff88] rounded-full flex items-center justify-center text-[#111] font-bold">4</div>
                        <div class="text-center mb-4">
                            <i class="fas fa-graduation-cap text-3xl text-[#00ff88]"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-[#00ff88] mb-3">Start Learning</h3>
                        <p class="text-[#ccc]">Once approved, join us in Malta for your professional development journey.</p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include '../components/footer.php'; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize animations
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-slide-up');
                        
                        // If element has specific animation class, use that instead
                        if (entry.target.classList.contains('animate-fade-in')) {
                            entry.target.classList.remove('animate-slide-up');
                            entry.target.classList.add('animate-fade-in');
                        }
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '50px'
            });

            document.querySelectorAll('[data-animate]').forEach(element => {
                observer.observe(element);
            });

            // Initialize expand/collapse functionality
            document.querySelectorAll('.expand-details-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const card = this.closest('.bg-gradient-to-br');
                    const content = card.querySelector('.expandable-content');
                    const icon = this.querySelector('.fa-chevron-down');
                    const buttonText = this.querySelector('.button-text');
                    
                    // Toggle content visibility
                    if (content.classList.contains('hidden')) {
                        // Show content
                        content.classList.remove('hidden');
                        content.style.maxHeight = content.scrollHeight + 'px';
                        icon.style.transform = 'rotate(180deg)';
                        buttonText.textContent = 'Hide Details';
                    } else {
                        // Hide content
                        content.style.maxHeight = '0px';
                        icon.style.transform = 'rotate(0deg)';
                        buttonText.textContent = 'Show Full Details';
                        setTimeout(() => {
                            content.classList.add('hidden');
                        }, 300);
                    }
                });
            });
        });
    </script>
</body>
</html> 