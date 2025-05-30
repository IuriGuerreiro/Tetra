<?php
require_once '../config/config.php';
require_once '../Controllers/CPDController.php';
include '../components/header.php';

// Initialize CPD Controller
$cpdController = new CPDController(GetPDO());
$cpds = $cpdController->getAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CPD Sessions - TETRA</title>
    <link rel="icon" type="image/png" href="https://new.tetra.com.mt/public/assets/images/favicon.png">

    <meta name="description" content="Discover our comprehensive range of CPD sessions designed for professional development">
    
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
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' }
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
</head>
<body class="bg-tetra-dark text-tetra-gray font-['Inter'] opacity-0 transition-opacity duration-300 ease-in-out" id="body">
    <main>
        <!-- Hero Section -->
        <section class="relative min-h-screen flex flex-col items-center justify-center px-4 sm:px-6 lg:px-8 overflow-hidden">
            <!-- Background Image -->
            <div class="absolute inset-0 z-0">
                <img src="../../public/assets/images/home/edu-books.jpg" alt="Education Background" 
                     class="w-full h-full object-cover">
                <!-- Dark Overlay -->
                <div class="absolute inset-0 bg-black/60"></div>
            </div>

            <!-- Triangle logo -->
            <div class="relative z-10 w-20 h-20 mb-16 sm:mb-14 md:mb-[60px] filter drop-shadow-[0_0_10px_rgba(255,255,255,0.3)]" data-animate>
                <img src="../../public/assets/images/favicon.png" 
                     alt="TETRA Logo" 
                     class="w-full h-full object-contain">
            </div>
            
            <!-- Hero content -->
            <div class="relative z-10 text-center max-w-3xl mx-auto px-4">
                <h1 class="text-[clamp(2rem,5vw,3.5rem)] leading-tight mb-6 text-white font-light tracking-wider animate-fade-in">
                    Continuous Professional Development
                </h1>
                <p class="text-[clamp(1rem,2vw,1.2rem)] leading-relaxed text-white/90 animate-slide-up">
                    Enhance your teaching skills with our ELT Council-approved CPD sessions
                </p>
            </div>
        </section>

        <!-- Upcoming Sessions -->
        <section class="py-16">
            <div class="container mx-auto px-4">
                <h2 class="text-4xl font-bold text-center text-tetra-green mb-12 animate-fade-in">
                    ELT Council Approved CPD Sessions
                </h2>
                
                <div class="bg-[rgba(0,255,136,0.1)] p-6 rounded-lg mb-12 flex items-start gap-4 animate-slide-up max-w-[1400px] mx-auto">
                    <i class="fas fa-info-circle text-2xl text-tetra-green mt-1"></i>
                    <p class="text-tetra-gray">
                        TETRA delivers a comprehensive series of ELT Council-approved CPD sessions designed to enhance your teaching practice. 
                        All sessions count towards your ELT permit requirements and feature expert facilitators with extensive experience in English language teaching.
                    </p>
                </div>

                <div class="flex flex-col gap-8 max-w-[1400px] mx-auto">
                    <?php if (!empty($cpds)): ?>
                        <?php foreach ($cpds as $cpd): ?>
                            <div class="bg-gradient-to-br from-[#1a1a1a] to-[#2d2d2d] rounded-xl border-2 border-tetra-border hover:border-tetra-green transition-all duration-300 hover:-translate-y-2 hover:shadow-[0_10px_30px_rgba(0,255,136,0.2)] animate-slide-up w-full">
                                <div class="flex flex-col md:flex-row">
                                    <?php if (!empty($cpd['image_path'])): ?>
                                        <div class="md:w-1/3 lg:w-1/4">
                                            <div class="h-full">
                                                <img src="../../public/assets/images/<?php echo htmlspecialchars($cpd['image_path']); ?>" 
                                                     alt="<?php echo htmlspecialchars($cpd['title']); ?>"
                                                     class="w-full h-full object-cover rounded-t-xl md:rounded-l-xl md:rounded-tr-none">
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="flex-1 p-6 md:p-8">
                                        <h3 class="text-2xl font-semibold text-tetra-green mb-4">
                                            <?php echo htmlspecialchars($cpd['title']); ?>
                                        </h3>
                                        
                                        <!-- Session Meta Information -->
                                        <div class="flex flex-wrap gap-4 mb-6">
                                            <div class="flex items-center gap-2 bg-[rgba(0,255,136,0.1)] px-4 py-2 rounded-full">
                                                <i class="fas fa-clock text-tetra-green"></i>
                                                <span class="text-tetra-green"><?php echo htmlspecialchars($cpd['duration_hours']); ?> hours</span>
                                            </div>
                                            <?php if (!empty($cpd['delivery_mode'])): ?>
                                                <div class="flex items-center gap-2 bg-[rgba(0,255,136,0.1)] px-4 py-2 rounded-full">
                                                    <i class="fas fa-chalkboard-teacher text-tetra-green"></i>
                                                    <span class="text-tetra-green"><?php echo htmlspecialchars($cpd['delivery_mode']); ?></span>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <!-- Course Overview -->
                                        <?php if (!empty($cpd['course_rationale'])): ?>
                                            <div class="bg-[rgba(255,255,255,0.05)] p-6 rounded-xl border-l-4 border-tetra-green mb-6">
                                                <h4 class="text-tetra-green text-lg font-semibold mb-3 flex items-center gap-2">
                                                    <i class="fas fa-lightbulb"></i> Course Overview
                                                </h4>
                                                <p class="text-tetra-gray leading-relaxed">
                                                    <?php echo nl2br(htmlspecialchars(substr($cpd['course_rationale'], 0, 500))); ?>
                                                    <?php echo strlen($cpd['course_rationale']) > 500 ? '...' : ''; ?>
                                                </p>
                                            </div>
                                        <?php endif; ?>

                                        <!-- Expand button -->
                                        <button class="expand-btn w-full bg-[rgba(0,255,136,0.1)] text-tetra-green border-2 border-tetra-green px-6 py-3 rounded-xl hover:bg-[rgba(0,255,136,0.2)] transition-all duration-300 flex items-center justify-center gap-3 mb-6">
                                            <i class="fas fa-chevron-down transition-transform duration-300"></i>
                                            <span class="button-text">Show Full Details</span>
                                        </button>

                                        <!-- Expandable Content -->
                                        <div class="expandable-content hidden transition-all duration-300 space-y-6 mb-8">
                                            <!-- Full Course Rationale -->
                                            <?php if (!empty($cpd['course_rationale']) && strlen($cpd['course_rationale']) > 500): ?>
                                                <div class="bg-[rgba(255,255,255,0.05)] p-6 rounded-xl border-l-4 border-tetra-green">
                                                    <h4 class="text-tetra-green text-lg font-semibold mb-3 flex items-center gap-2">
                                                        <i class="fas fa-lightbulb"></i> Full Course Rationale
                                                    </h4>
                                                    <p class="text-tetra-gray leading-relaxed">
                                                        <?php echo nl2br(htmlspecialchars($cpd['course_rationale'])); ?>
                                                    </p>
                                                </div>
                                            <?php endif; ?>

                                            <!-- Course Objectives -->
                                            <?php if (!empty($cpd['course_objectives'])): ?>
                                                <div class="bg-[rgba(255,255,255,0.05)] p-6 rounded-xl border-l-4 border-tetra-green">
                                                    <h4 class="text-tetra-green text-lg font-semibold mb-3 flex items-center gap-2">
                                                        <i class="fas fa-target"></i> Course Objectives
                                                    </h4>
                                                    <?php 
                                                    $objectives = $cpd['course_objectives'];
                                                    if (strpos($objectives, ';') !== false || strpos($objectives, '-') !== false) {
                                                        $items = preg_split('/[;\-]\s*/', $objectives);
                                                        echo '<ul class="list-disc pl-5 text-tetra-gray space-y-2">';
                                                        foreach ($items as $item) {
                                                            $item = trim($item);
                                                            if (!empty($item)) {
                                                                echo '<li>' . htmlspecialchars($item) . '</li>';
                                                            }
                                                        }
                                                        echo '</ul>';
                                                    } else {
                                                        echo '<p class="text-tetra-gray leading-relaxed">' . nl2br(htmlspecialchars($objectives)) . '</p>';
                                                    }
                                                    ?>
                                                </div>
                                            <?php endif; ?>

                                            <!-- Learning Outcomes -->
                                            <?php if (!empty($cpd['learning_outcomes'])): ?>
                                                <div class="bg-[rgba(255,255,255,0.05)] p-6 rounded-xl border-l-4 border-tetra-green">
                                                    <h4 class="text-tetra-green text-lg font-semibold mb-3 flex items-center gap-2">
                                                        <i class="fas fa-graduation-cap"></i> Learning Outcomes
                                                    </h4>
                                                    <?php 
                                                    $outcomes = $cpd['learning_outcomes'];
                                                    if (strpos($outcomes, ';') !== false || strpos($outcomes, '-') !== false) {
                                                        $items = preg_split('/[;\-]\s*/', $outcomes);
                                                        echo '<ul class="list-disc pl-5 text-tetra-gray space-y-2">';
                                                        foreach ($items as $item) {
                                                            $item = trim($item);
                                                            if (!empty($item)) {
                                                                echo '<li>' . htmlspecialchars($item) . '</li>';
                                                            }
                                                        }
                                                        echo '</ul>';
                                                    } else {
                                                        echo '<p class="text-tetra-gray leading-relaxed">' . nl2br(htmlspecialchars($outcomes)) . '</p>';
                                                    }
                                                    ?>
                                                </div>
                                            <?php endif; ?>

                                            <!-- Course Procedures -->
                                            <?php if (!empty($cpd['course_procedures'])): ?>
                                                <div class="bg-[rgba(255,255,255,0.05)] p-6 rounded-xl border-l-4 border-tetra-green">
                                                    <h4 class="text-tetra-green text-lg font-semibold mb-3 flex items-center gap-2">
                                                        <i class="fas fa-tasks"></i> Course Procedures
                                                    </h4>
                                                    <p class="text-tetra-gray leading-relaxed">
                                                        <?php echo nl2br(htmlspecialchars($cpd['course_procedures'])); ?>
                                                    </p>
                                                </div>
                                            <?php endif; ?>

                                            <!-- Assessment Procedure -->
                                            <?php if (!empty($cpd['assessment_procedure'])): ?>
                                                <div class="bg-[rgba(255,255,255,0.05)] p-6 rounded-xl border-l-4 border-tetra-green">
                                                    <h4 class="text-tetra-green text-lg font-semibold mb-3 flex items-center gap-2">
                                                        <i class="fas fa-clipboard-check"></i> Assessment Procedure
                                                    </h4>
                                                    <p class="text-tetra-gray leading-relaxed">
                                                        <?php echo nl2br(htmlspecialchars($cpd['assessment_procedure'])); ?>
                                                    </p>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                        <!-- More Details Button -->
                                        <div class="pt-4">
                                            <a href="view-cpd.php?id=<?php echo urlencode($cpd['id']); ?>" 
                                               class="inline-flex items-center justify-center w-full bg-tetra-green text-tetra-dark px-6 py-3 rounded-xl font-semibold hover:bg-[#33ff9f] transition-all duration-300">
                                                More Details <i class="fas fa-arrow-right ml-2"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-span-2 bg-[rgba(0,255,136,0.1)] p-8 rounded-xl flex items-center justify-center gap-4 animate-slide-up">
                            <i class="fas fa-info-circle text-3xl text-tetra-green"></i>
                            <p class="text-tetra-gray text-xl">No CPD sessions currently loaded. Please contact us for information about upcoming sessions.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- Benefits Section -->
        <section class="py-16 bg-gradient-to-br from-[#1a1a1a] to-[#2d2d2d]">
            <div class="container mx-auto px-4">
                <h2 class="text-4xl font-bold text-center text-tetra-green mb-12 animate-fade-in">
                    Why Choose Our CPD Sessions?
                </h2>
                <div class="flex flex-col gap-8 max-w-[1400px] mx-auto">
                    <div class="bg-[rgba(255,255,255,0.05)] p-8 rounded-lg border border-tetra-border hover:border-tetra-green transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_10px_30px_rgba(0,255,136,0.2)] animate-slide-up w-full">
                        <div class="flex items-center gap-6">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle text-4xl text-tetra-green"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold text-tetra-green mb-3">ELT Council Approved</h3>
                                <p class="text-tetra-gray">All our sessions are approved by the ELT council and count towards your permit requirements</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-[rgba(255,255,255,0.05)] p-8 rounded-lg border border-tetra-border hover:border-tetra-green transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_10px_30px_rgba(0,255,136,0.2)] animate-slide-up delay-100 w-full">
                        <div class="flex items-center gap-6">
                            <div class="flex-shrink-0">
                                <i class="fas fa-user-tie text-4xl text-tetra-green"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold text-tetra-green mb-3">Expert Facilitators</h3>
                                <p class="text-tetra-gray">Learn from experienced professionals with extensive teaching and training backgrounds</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-[rgba(255,255,255,0.05)] p-8 rounded-lg border border-tetra-border hover:border-tetra-green transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_10px_30px_rgba(0,255,136,0.2)] animate-slide-up delay-200 w-full">
                        <div class="flex items-center gap-6">
                            <div class="flex-shrink-0">
                                <i class="fas fa-hands-helping text-4xl text-tetra-green"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold text-tetra-green mb-3">Practical Focus</h3>
                                <p class="text-tetra-gray">Gain hands-on experience and ready-to-use resources for your classroom</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-[rgba(255,255,255,0.05)] p-8 rounded-lg border border-tetra-border hover:border-tetra-green transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_10px_30px_rgba(0,255,136,0.2)] animate-slide-up delay-300 w-full">
                        <div class="flex items-center gap-6">
                            <div class="flex-shrink-0">
                                <i class="fas fa-users text-4xl text-tetra-green"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold text-tetra-green mb-3">Interactive Sessions</h3>
                                <p class="text-tetra-gray">Engage in discussions, group work, and practical exercises with fellow teachers</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Registration Steps -->
        <section class="py-16 bg-tetra-dark">
            <div class="container mx-auto px-4">
                <h2 class="text-4xl font-bold text-center text-tetra-green mb-12 animate-fade-in">
                    How to Register
                </h2>
                <div class="flex flex-col gap-8 max-w-[1400px] mx-auto">
                    <!-- Step 1 -->
                    <div class="bg-gradient-to-br from-[#1a1a1a] to-[#2d2d2d] rounded-lg p-8 relative border border-tetra-border hover:border-tetra-green transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_10px_30px_rgba(0,255,136,0.2)] animate-slide-up w-full">
                        <div class="absolute -top-4 -left-4 w-10 h-10 bg-tetra-green rounded-full flex items-center justify-center text-tetra-dark font-bold">1</div>
                        <div class="flex items-center gap-6">
                            <div class="flex-shrink-0">
                                <i class="fas fa-list-ul text-3xl text-tetra-green"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold text-tetra-green mb-3">Choose Your Session</h3>
                                <p class="text-tetra-gray">Browse our comprehensive CPD sessions and select those that match your professional development needs.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="bg-gradient-to-br from-[#1a1a1a] to-[#2d2d2d] rounded-lg p-8 relative border border-tetra-border hover:border-tetra-green transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_10px_30px_rgba(0,255,136,0.2)] animate-slide-up delay-100 w-full">
                        <div class="absolute -top-4 -left-4 w-10 h-10 bg-tetra-green rounded-full flex items-center justify-center text-tetra-dark font-bold">2</div>
                        <div class="flex items-center gap-6">
                            <div class="flex-shrink-0">
                                <i class="fas fa-handshake text-3xl text-tetra-green"></i>
                            </div>
                            <div class="flex-grow">
                                <h3 class="text-xl font-semibold text-tetra-green mb-3">Get in Touch</h3>
                                <p class="text-tetra-gray mb-4">Ready to enhance your teaching skills? Contact us to learn more about our CPD sessions.</p>
                                <div class="space-y-2">
                                    <p class="text-tetra-gray"><i class="fas fa-phone mr-2 text-tetra-green"></i>+356 99660124</p>
                                    <p class="text-tetra-gray"><i class="fas fa-envelope mr-2 text-tetra-green"></i><a href="mailto:info@tetra.com.mt" class="text-tetra-green hover:text-[#33ff9f]">info@tetra.com.mt</a></p>
                                    <a href="https://docs.google.com/forms/d/e/1FAIpQLSeU3CvyZ-Wh1lfE9i7LY_ka_wyzt0iAaABtu3nvJeT6Tyv8wg/viewform?usp=dialog" 
                                       class="inline-block mt-3 px-4 py-2 bg-[rgba(0,255,136,0.1)] text-tetra-green rounded-full border border-tetra-green hover:bg-[rgba(0,255,136,0.2)] transition-all duration-300"
                                       target="_blank">
                                        <i class="fas fa-info-circle mr-2"></i>Request Info
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="bg-gradient-to-br from-[#1a1a1a] to-[#2d2d2d] rounded-lg p-8 relative border border-tetra-border hover:border-tetra-green transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_10px_30px_rgba(0,255,136,0.2)] animate-slide-up delay-200 w-full">
                        <div class="absolute -top-4 -left-4 w-10 h-10 bg-tetra-green rounded-full flex items-center justify-center text-tetra-dark font-bold">3</div>
                        <div class="flex items-center gap-6">
                            <div class="flex-shrink-0">
                                <i class="fas fa-calendar-alt text-3xl text-tetra-green"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold text-tetra-green mb-3">Get Scheduled</h3>
                                <p class="text-tetra-gray">We'll contact you with available dates and session details.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Step 4 -->
                    <div class="bg-gradient-to-br from-[#1a1a1a] to-[#2d2d2d] rounded-lg p-8 relative border border-tetra-border hover:border-tetra-green transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_10px_30px_rgba(0,255,136,0.2)] animate-slide-up delay-300 w-full">
                        <div class="absolute -top-4 -left-4 w-10 h-10 bg-tetra-green rounded-full flex items-center justify-center text-tetra-dark font-bold">4</div>
                        <div class="flex items-center gap-6">
                            <div class="flex-shrink-0">
                                <i class="fas fa-graduation-cap text-3xl text-tetra-green"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold text-tetra-green mb-3">Attend & Learn</h3>
                                <p class="text-tetra-gray">Join the session and enhance your teaching skills with expert guidance.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include '../components/footer.php'; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add loaded class to body
            document.getElementById('body').classList.add('opacity-100');
            
            // Initialize expand/collapse functionality
            document.querySelectorAll('.expand-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const content = this.nextElementSibling;
                    const icon = this.querySelector('.fa-chevron-down');
                    const buttonText = this.querySelector('.button-text');
                    
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

            // Initialize animations
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('opacity-100', 'translate-y-0');
                        entry.target.classList.remove('opacity-0', 'translate-y-4');
                    }
                });
            }, {
                threshold: 0.1
            });

            document.querySelectorAll('[class*="animate-"]').forEach(element => {
                observer.observe(element);
            });
        });
    </script>
</body>
</html> 