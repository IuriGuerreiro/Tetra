<?php
// Include the database configuration
require_once '../config/config.php';

// Including the header
include '../components/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TETRA - Education Solution</title>
    
    <meta name="description" content="We create successful, innovative educational products from the initial concept through accreditation and up to full course launch, delivery and completion.">
    
    <!-- Favicon -->
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
                    fontFamily: {
                        'inter': ['Inter', 'sans-serif'],
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
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <style>
        body { 
            opacity: 0;
            transition: opacity .3s ease;
        }
        .loaded { opacity: 1; }
        .phrase.active {
            opacity: 1 !important;
            visibility: visible !important;
            transform: translateY(0) !important;
            pointer-events: auto !important;
        }
        .dot.active {
            background-color: white !important;
            transform: scale(1.2) !important;
        }
    </style>
</head>
<body class="bg-tetra-dark text-tetra-gray font-inter">
    <main>
        <!-- Hero Section -->
        <section class="relative min-h-screen flex flex-col items-center justify-center py-8 px-4 sm:px-6 lg:px-8 overflow-hidden">
            <!-- Background Image -->
            <div class="absolute inset-0 z-0">
                <img src="../../public/assets/images/home/edu-books.jpg" 
                     alt="Education Background" 
                     class="w-full h-full object-cover">
                <!-- Dark Overlay -->
                <div class="absolute inset-0 bg-black/60"></div>
            </div>
            
            <!-- Logo -->
            <div class="relative z-10 w-20 h-20 sm:w-[80px] sm:h-[80px] mb-8 sm:mb-[60px] filter drop-shadow-[0_0_10px_rgba(255,255,255,0.3)]">
                <img src="../../public/assets/images/favicon.png" 
                     alt="TETRA Logo" 
                     class="w-full h-full object-contain">
            </div>
            
            <!-- Cycling phrases container -->
            <div class="relative z-10 w-full max-w-[600px] mx-auto mb-10 flex justify-center items-center min-h-[120px]">
                <div class="phrase absolute w-full text-center opacity-0 invisible transition-all duration-500 ease-in-out -translate-y-5 px-4 active" id="phrase1">
                    <h1 class="text-[clamp(1.2rem,3vw,2.5rem)] font-light tracking-[8px] m-0 text-white shadow-lg break-words hyphens-auto leading-relaxed">
                        TEACHER TRAINING ACADEMY
                    </h1>
                </div>
                <div class="phrase absolute w-full text-center opacity-0 invisible transition-all duration-500 ease-in-out -translate-y-5 px-4" id="phrase2">
                    <h1 class="text-[clamp(1.2rem,3vw,2.5rem)] font-light tracking-[8px] m-0 text-white shadow-lg break-words hyphens-auto leading-relaxed">
                        YOUR EDUCATION SOLUTION
                    </h1>
                </div>
                <div class="phrase absolute w-full text-center opacity-0 invisible transition-all duration-500 ease-in-out -translate-y-5 px-4" id="phrase3">
                    <h1 class="text-[clamp(1.2rem,3vw,2.5rem)] font-light tracking-[8px] m-0 text-white shadow-lg break-words hyphens-auto leading-relaxed">
                        TEACH, LEARN, CONNECT
                    </h1>
                </div>
            </div>
            
            <!-- Indicator dots -->
            <div class="relative z-10 flex gap-3">
                <div class="w-3 h-3 rounded-full bg-white/30 cursor-pointer transition-all duration-300 hover:scale-110 dot active" data-index="0"></div>
                <div class="w-3 h-3 rounded-full bg-white/30 cursor-pointer transition-all duration-300 hover:scale-110 dot" data-index="1"></div>
                <div class="w-3 h-3 rounded-full bg-white/30 cursor-pointer transition-all duration-300 hover:scale-110 dot" data-index="2"></div>
            </div>
        </section>

        <!-- Services Section -->
        <section class="py-20 bg-gradient-to-br from-[#111111] to-[#1a1a1a]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-4xl font-bold text-center text-tetra-green mb-12 opacity-0 transform -translate-y-4 transition-all duration-500 animate-fade-in">Our Services</h2>

                <!-- Professional Development Card -->
                <div class="bg-gradient-to-br from-[#1a1a1a] to-[#2a2a2a] rounded-xl border-2 border-tetra-border hover:border-tetra-green transition-all duration-300 hover:-translate-y-2 hover:shadow-[0_10px_30px_rgba(0,255,136,0.2)] p-10 mb-12">
                    <div class="flex items-center gap-6 pb-6 border-b border-tetra-border">
                        <i class="fas fa-graduation-cap text-4xl text-tetra-green"></i>
                        <div>
                            <h3 class="text-3xl font-semibold text-white">Professional Development for Educators</h3>
                        </div>
                    </div>
                    <div class="mt-8 space-y-6">
                        <div class="bg-[rgba(0,255,136,0.1)] p-6 rounded-xl border-l-4 border-tetra-green flex items-start gap-4">
                            <i class="fas fa-star text-tetra-green text-xl mt-1"></i>
                            <span class="text-lg text-white">TETRA specializes in delivering ELT Council-approved CPD sessions designed to transform your teaching practice and advance your career in English language education.</span>
                        </div>
                        
                        <div class="flex justify-center mt-8">
                            <a href="cpds.php" class="inline-flex items-center justify-center gap-3 px-8 py-4 bg-transparent text-tetra-green border-2 border-tetra-green rounded-full hover:bg-[rgba(0,255,136,0.1)] transition-all duration-300 text-lg font-medium">
                                <i class="fas fa-graduation-cap"></i>
                                Explore CPD Sessions
                            </a>
                        </div>
                    </div>
                </div>
                <h3 class="text-2xl font-semibold text-tetra-green text-center mb-12 opacity-0 transform translate-y-4 transition-all duration-500 animate-slide-up">Further and Higher Education Accreditation Services</h3>
                
                <!-- Provider Accreditation Part A -->
                <div class="bg-gradient-to-br from-[#1a1a1a] to-[#2a2a2a] rounded-xl border-2 border-tetra-border hover:border-tetra-green transition-all duration-300 hover:-translate-y-2 hover:shadow-[0_10px_30px_rgba(0,255,136,0.2)] p-10 mb-8">
                    <div class="flex items-center gap-6 pb-6 border-b border-tetra-border">
                        <i class="fas fa-certificate text-4xl text-tetra-green"></i>
                        <div>
                            <h3 class="text-2xl font-semibold text-white">PROVIDER ACCREDITATION PART A</h3>
                            <span class="text-tetra-green text-lg italic mt-2 block">Higher Education only</span>
                        </div>
                    </div>
                    <div class="mt-8 space-y-4">
                        <div class="bg-[rgba(0,255,136,0.1)] p-6 rounded-xl border-l-4 border-tetra-green flex items-start gap-4">
                            <i class="fas fa-file-alt text-tetra-green text-xl mt-1"></i>
                            <span class="text-lg text-white">Compilation of application form for Provider Accreditation</span>
                        </div>
                        <div class="bg-[rgba(0,255,136,0.1)] p-6 rounded-xl border-l-4 border-tetra-green flex items-start gap-4">
                            <i class="fas fa-chart-line text-tetra-green text-xl mt-1"></i>
                            <span class="text-lg text-white">Design and development of Business Plan with CSP</span>
                        </div>
                        <div class="bg-[rgba(0,255,136,0.1)] p-6 rounded-xl border-l-4 border-tetra-green flex items-start gap-4">
                            <i class="fas fa-calculator text-tetra-green text-xl mt-1"></i>
                            <span class="text-lg text-white">Financial Projections and Cash Flow planning</span>
                        </div>
                        <div class="bg-[rgba(0,255,136,0.1)] p-6 rounded-xl border-l-4 border-tetra-green flex items-start gap-4">
                            <i class="fas fa-tasks text-tetra-green text-xl mt-1"></i>
                            <span class="text-lg text-white">Reviews as requested by the MFHEA</span>
                        </div>
                    </div>
                </div>

                <!-- Provider Accreditation Part B -->
                <div class="bg-gradient-to-br from-[#1a1a1a] to-[#2a2a2a] rounded-xl border-2 border-tetra-border hover:border-tetra-green transition-all duration-300 hover:-translate-y-2 hover:shadow-[0_10px_30px_rgba(0,255,136,0.2)] p-10 mb-8">
                    <div class="flex items-center gap-6 pb-6 border-b border-tetra-border">
                        <i class="fas fa-award text-4xl text-tetra-green"></i>
                        <div>
                            <h3 class="text-2xl font-semibold text-white">PROVIDER ACCREDITATION PART B</h3>
                        </div>
                    </div>
                    <div class="mt-8 space-y-4">
                        <div class="bg-[rgba(0,255,136,0.1)] p-6 rounded-xl border-l-4 border-tetra-green flex items-start gap-4">
                            <i class="fas fa-file-alt text-tetra-green text-xl mt-1"></i>
                            <span class="text-lg text-white">Compilation of application form for Provider Accreditation</span>
                        </div>
                        <div class="bg-[rgba(0,255,136,0.1)] p-6 rounded-xl border-l-4 border-tetra-green flex items-start gap-4">
                            <i class="fas fa-shield-alt text-tetra-green text-xl mt-1"></i>
                            <span class="text-lg text-white">Design and development of IQA Policy</span>
                        </div>
                        <div class="bg-[rgba(0,255,136,0.1)] p-6 rounded-xl border-l-4 border-tetra-green flex items-start gap-4">
                            <i class="fas fa-search text-tetra-green text-xl mt-1"></i>
                            <span class="text-lg text-white">Reviews as requested by the MFHEA</span>
                        </div>
                    </div>
                </div>

                <!-- Course Development -->
                <div class="bg-gradient-to-br from-[#1a1a1a] to-[#2a2a2a] rounded-xl border-2 border-tetra-border hover:border-tetra-green transition-all duration-300 hover:-translate-y-2 hover:shadow-[0_10px_30px_rgba(0,255,136,0.2)] p-10 mb-8">
                    <div class="flex items-center gap-6 pb-6 border-b border-tetra-border">
                        <i class="fas fa-book-open text-4xl text-tetra-green"></i>
                        <div>
                            <h3 class="text-2xl font-semibold text-white">COURSE DEVELOPMENT</h3>
                        </div>
                    </div>
                    <div class="mt-8 space-y-4">
                        <div class="bg-[rgba(0,255,136,0.1)] p-6 rounded-xl border-l-4 border-tetra-green flex items-start gap-4">
                            <i class="fas fa-pencil-ruler text-tetra-green text-xl mt-1"></i>
                            <span class="text-lg text-white">Work with the Academy in building and developing a range of courses in the desired areas</span>
                        </div>
                        <div class="bg-[rgba(0,255,136,0.1)] p-6 rounded-xl border-l-4 border-tetra-green flex items-start gap-4">
                            <i class="fas fa-tasks text-tetra-green text-xl mt-1"></i>
                            <span class="text-lg text-white">We will be responsible for ensuring course design is fit for purpose and meets both industry and vocational training requirements</span>
                        </div>
                        <div class="bg-[rgba(0,255,136,0.1)] p-6 rounded-xl border-l-4 border-tetra-green flex items-start gap-4">
                            <i class="fas fa-list-ul text-tetra-green text-xl mt-1"></i>
                            <span class="text-lg text-white">Each course will include learning hours, rationale, aims, entry requirements, unit descriptors, unit content, learning outcomes & assessment strategies</span>
                        </div>
                        <div class="bg-[rgba(0,255,136,0.1)] p-6 rounded-xl border-l-4 border-tetra-green flex items-start gap-4">
                            <i class="fas fa-file-contract text-tetra-green text-xl mt-1"></i>
                            <span class="text-lg text-white">Prepare and submit all the necessary documentation required by MFHEA for formal accreditation of programmes</span>
                        </div>
                        <div class="bg-[rgba(0,255,136,0.1)] p-6 rounded-xl border-l-4 border-tetra-green flex items-start gap-4">
                            <i class="fas fa-chalkboard-teacher text-tetra-green text-xl mt-1"></i>
                            <span class="text-lg text-white">Assist in preparation of course content, teaching and student material</span>
                        </div>
                    </div>
                </div>

                <!-- Staff Recruitment & Development -->
                <div class="bg-gradient-to-br from-[#1a1a1a] to-[#2a2a2a] rounded-xl border-2 border-tetra-border hover:border-tetra-green transition-all duration-300 hover:-translate-y-2 hover:shadow-[0_10px_30px_rgba(0,255,136,0.2)] p-10 mb-8">
                    <div class="flex items-center gap-6 pb-6 border-b border-tetra-border">
                        <i class="fas fa-users text-4xl text-tetra-green"></i>
                        <div>
                            <h3 class="text-2xl font-semibold text-white">STAFF RECRUITMENT & DEVELOPMENT</h3>
                        </div>
                    </div>
                    <div class="mt-8 space-y-4">
                        <div class="bg-[rgba(0,255,136,0.1)] p-6 rounded-xl border-l-4 border-tetra-green flex items-start gap-4">
                            <i class="fas fa-user-tie text-tetra-green text-xl mt-1"></i>
                            <span class="text-lg text-white">Work with the Academy in training existing staff as well as staff recruitment & development, train the trainers and overall ensure the academic caliber of teaching staff</span>
                        </div>
                        <div class="bg-[rgba(0,255,136,0.1)] p-6 rounded-xl border-l-4 border-tetra-green flex items-start gap-4">
                            <i class="fas fa-graduation-cap text-tetra-green text-xl mt-1"></i>
                            <span class="text-lg text-white">Liaising with staff on maintaining their CPD portfolio</span>
                        </div>
                    </div>
                </div>

                <!-- Quality Assurance -->
                <div class="bg-gradient-to-br from-[#1a1a1a] to-[#2a2a2a] rounded-xl border-2 border-tetra-border hover:border-tetra-green transition-all duration-300 hover:-translate-y-2 hover:shadow-[0_10px_30px_rgba(0,255,136,0.2)] p-10 mb-8">
                    <div class="flex items-center gap-6 pb-6 border-b border-tetra-border">
                        <i class="fas fa-check-circle text-4xl text-tetra-green"></i>
                        <div>
                            <h3 class="text-2xl font-semibold text-white">QUALITY ASSURANCE</h3>
                        </div>
                    </div>
                    <div class="mt-8 space-y-4">
                        <div class="bg-[rgba(0,255,136,0.1)] p-6 rounded-xl border-l-4 border-tetra-green flex items-start gap-4">
                            <i class="fas fa-shield-alt text-tetra-green text-xl mt-1"></i>
                            <span class="text-lg text-white">Developing and strengthening QA Policy</span>
                        </div>
                        <div class="bg-[rgba(0,255,136,0.1)] p-6 rounded-xl border-l-4 border-tetra-green flex items-start gap-4">
                            <i class="fas fa-cogs text-tetra-green text-xl mt-1"></i>
                            <span class="text-lg text-white">Managing all Internal and External Quality Assurance procedures</span>
                        </div>
                        <div class="bg-[rgba(0,255,136,0.1)] p-6 rounded-xl border-l-4 border-tetra-green flex items-start gap-4">
                            <i class="fas fa-drafting-compass text-tetra-green text-xl mt-1"></i>
                            <span class="text-lg text-white">Taking responsibility for design and approval of all programmes</span>
                        </div>
                        <div class="bg-[rgba(0,255,136,0.1)] p-6 rounded-xl border-l-4 border-tetra-green flex items-start gap-4">
                            <i class="fas fa-chalkboard-teacher text-tetra-green text-xl mt-1"></i>
                            <span class="text-lg text-white">Implementing student centered learning across teaching and assessment</span>
                        </div>
                        <div class="bg-[rgba(0,255,136,0.1)] p-6 rounded-xl border-l-4 border-tetra-green flex items-start gap-4">
                            <i class="fas fa-user-graduate text-tetra-green text-xl mt-1"></i>
                            <span class="text-lg text-white">Registering students on programme of study ensuring entry requirements are met, recognition of prior learning and maintain student records through to certification</span>
                        </div>
                        <div class="bg-[rgba(0,255,136,0.1)] p-6 rounded-xl border-l-4 border-tetra-green flex items-start gap-4">
                            <i class="fas fa-handshake text-tetra-green text-xl mt-1"></i>
                            <span class="text-lg text-white">Coordinating with Internal Verifiers in making assessment decisions and liaising with External Verifiers in reaching final assessment decisions</span>
                        </div>
                        <div class="bg-[rgba(0,255,136,0.1)] p-6 rounded-xl border-l-4 border-tetra-green flex items-start gap-4">
                            <i class="fas fa-chart-line text-tetra-green text-xl mt-1"></i>
                            <span class="text-lg text-white">Ensuring Continuing Professional Development activities are carried out for teaching staff</span>
                        </div>
                        <div class="bg-[rgba(0,255,136,0.1)] p-6 rounded-xl border-l-4 border-tetra-green flex items-start gap-4">
                            <i class="fas fa-clipboard-list text-tetra-green text-xl mt-1"></i>
                            <span class="text-lg text-white">Carrying out necessary monitoring activities and programme reviews in liaison with key stakeholders</span>
                        </div>
                    </div>
                </div>
                <div class="flex justify-center mt-12">
                    <a href="https://docs.google.com/forms/d/e/1FAIpQLSf-22kC4X6Ks0p4f0e4IsunRcjDXXWi8vbHCz7GFTSThwuV1Q/viewform?usp=header" 
                       target="_blank" 
                       class="inline-flex items-center justify-center gap-3 px-10 py-4 bg-transparent text-tetra-green border-2 border-tetra-green rounded-full hover:bg-[rgba(0,255,136,0.1)] transition-all duration-300 text-lg font-medium group transform hover:-translate-y-1 hover:shadow-[0_10px_30px_rgba(0,255,136,0.2)]">
                        <i class="fas fa-paper-plane transform group-hover:scale-110 transition-transform duration-300"></i>
                        <span>Apply for Service</span>
                    </a>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="relative py-24 bg-black">
            <!-- Background Gradient -->
            <div class="absolute inset-0 bg-gradient-to-br from-[rgba(192,192,192,0.05)] to-[rgba(255,255,255,0.05)] backdrop-blur-lg"></div>
            
            <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <!-- Teachers Trained -->
                    <div class="bg-[rgba(26,26,26,0.8)] p-8 rounded-xl border border-tetra-border hover:border-tetra-green transition-all duration-300 hover:-translate-y-2 hover:shadow-[0_10px_30px_rgba(0,255,136,0.2)] backdrop-blur-sm group">
                        <i class="fas fa-user-graduate text-4xl text-tetra-green mb-4 transform transition-transform duration-300 group-hover:scale-110 group-hover:drop-shadow-[0_0_10px_rgba(0,255,136,0.5)]"></i>
                        <h3 class="text-5xl font-bold text-tetra-gray mb-2 transition-colors duration-300 group-hover:text-tetra-green">450</h3>
                        <p class="text-xl text-tetra-gray transition-colors duration-300 group-hover:text-tetra-green">Teachers Trained</p>
                    </div>

                    <!-- Courses Designed -->
                    <div class="bg-[rgba(26,26,26,0.8)] p-8 rounded-xl border border-tetra-border hover:border-tetra-green transition-all duration-300 hover:-translate-y-2 hover:shadow-[0_10px_30px_rgba(0,255,136,0.2)] backdrop-blur-sm group">
                        <i class="fas fa-book text-4xl text-tetra-green mb-4 transform transition-transform duration-300 group-hover:scale-110 group-hover:drop-shadow-[0_0_10px_rgba(0,255,136,0.5)]"></i>
                        <h3 class="text-5xl font-bold text-tetra-gray mb-2 transition-colors duration-300 group-hover:text-tetra-green">98</h3>
                        <p class="text-xl text-tetra-gray transition-colors duration-300 group-hover:text-tetra-green">Courses Designed</p>
                    </div>

                    <!-- Provider Accreditations -->
                    <div class="bg-[rgba(26,26,26,0.8)] p-8 rounded-xl border border-tetra-border hover:border-tetra-green transition-all duration-300 hover:-translate-y-2 hover:shadow-[0_10px_30px_rgba(0,255,136,0.2)] backdrop-blur-sm group">
                        <i class="fas fa-star text-4xl text-tetra-green mb-4 transform transition-transform duration-300 group-hover:scale-110 group-hover:drop-shadow-[0_0_10px_rgba(0,255,136,0.5)]"></i>
                        <h3 class="text-5xl font-bold text-tetra-gray mb-2 transition-colors duration-300 group-hover:text-tetra-green">10</h3>
                        <p class="text-xl text-tetra-gray transition-colors duration-300 group-hover:text-tetra-green">Provider Accreditations</p>
                    </div>

                    <!-- CPD Hours -->
                    <div class="bg-[rgba(26,26,26,0.8)] p-8 rounded-xl border border-tetra-border hover:border-tetra-green transition-all duration-300 hover:-translate-y-2 hover:shadow-[0_10px_30px_rgba(0,255,136,0.2)] backdrop-blur-sm group">
                        <i class="fas fa-clock text-4xl text-tetra-green mb-4 transform transition-transform duration-300 group-hover:scale-110 group-hover:drop-shadow-[0_0_10px_rgba(0,255,136,0.5)]"></i>
                        <h3 class="text-5xl font-bold text-tetra-gray mb-2 transition-colors duration-300 group-hover:text-tetra-green">5000</h3>
                        <p class="text-xl text-tetra-gray transition-colors duration-300 group-hover:text-tetra-green">CPD Hours Delivered</p>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <?php include '../components/footer.php'; ?>
    
    <!-- Performance optimization script -->
    <script src="../../public/assets/js/hero.js"></script>
    <script src="../../public/assets/js/scroll-animations.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.body.classList.add('loaded');
            
            // Stats animation
            const statsObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate');
                        statsObserver.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.5
            });

            document.querySelectorAll('.group').forEach(card => {
                statsObserver.observe(card);
            });
            
            // Hero section functionality is now in hero.js
        });
    </script>
</body>
</html>










