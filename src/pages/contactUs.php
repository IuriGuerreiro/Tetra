<?php 
include_once '../components/header.php';
?>

<head>
    <title>Contact Us - TETRA Education</title>
    <meta name="description" content="Get in touch with TETRA for all your educational needs. We're here to help with professional development, accreditation services, and more.">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
</head>

<main class="bg-gradient-to-br from-[#111111] to-[#1a1a1a] min-h-screen py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Page Header -->
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-center text-tetra-green mb-12 opacity-0 transform -translate-y-4 transition-all duration-500 animate-fade-in">Get in Touch</h2>
            <p class="text-xl text-white max-w-2xl mx-auto">Have questions about our services? We're here to help you with your educational journey.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Google Form Section -->
            <div class="bg-gradient-to-br from-[#1a1a1a] to-[#2a2a2a] rounded-xl border-2 border-tetra-border hover:border-tetra-green transition-all duration-300 hover:-translate-y-2 hover:shadow-[0_10px_30px_rgba(0,255,136,0.2)] p-10 mb-8">
                <div class="flex items-center gap-6 pb-6 border-b border-tetra-border">
                    <i class="fas fa-paper-plane text-4xl text-tetra-green"></i>
                    <div>
                        <h3 class="text-3xl font-semibold text-white">Send us a Message</h3>
                    </div>
                </div>
                <div class="mt-8 space-y-6">
                    <div class="bg-[rgba(0,255,136,0.1)] p-6 rounded-xl border-l-4 border-tetra-green flex items-start gap-4">
                        <i class="fas fa-info-circle text-tetra-green text-xl mt-1"></i>
                        <span class="text-lg text-white">Fill out our form to get in touch with our team. We'll respond to your inquiry as soon as possible.</span>
                    </div>
                    
                    <!-- Google Form iframe -->
                    <iframe src="https://docs.google.com/forms/d/e/1FAIpQLSf-22kC4X6Ks0p4f0e4IsunRcjDXXWi8vbHCz7GFTSThwuV1Q/viewform?embedded=true" 
                            class="w-full rounded-lg border border-tetra-green h-[500px] mb-6">
                        Loading…
                    </iframe>
                    
                    <div class="flex justify-center mt-8">
                        <a href="https://docs.google.com/forms/d/e/1FAIpQLSf-22kC4X6Ks0p4f0e4IsunRcjDXXWi8vbHCz7GFTSThwuV1Q/viewform" 
                           target="_blank" 
                           class="inline-flex items-center justify-center gap-3 px-8 py-4 bg-transparent text-tetra-green border-2 border-tetra-green rounded-full hover:bg-[rgba(0,255,136,0.1)] transition-all duration-300 text-lg font-medium">
                            <i class="fas fa-external-link-alt"></i>
                            Open Form in New Tab
                        </a>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="space-y-8">
                <!-- Office Location -->
                <div class="bg-gradient-to-br from-[#1a1a1a] to-[#2a2a2a] rounded-xl border-2 border-tetra-border hover:border-tetra-green transition-all duration-300 hover:-translate-y-2 hover:shadow-[0_10px_30px_rgba(0,255,136,0.2)] p-10 mb-8">
                    <div class="flex items-center gap-6 pb-6 border-b border-tetra-border">
                        <i class="fas fa-location-dot text-4xl text-tetra-green"></i>
                        <div>
                            <h3 class="text-2xl font-semibold text-white">Visit Us</h3>
                        </div>
                    </div>
                    <div class="mt-8 space-y-4">
                        <div class="bg-[rgba(0,255,136,0.1)] p-6 rounded-xl border-l-4 border-tetra-green flex items-start gap-4">
                            <i class="fas fa-map-marker-alt text-tetra-green text-xl mt-1"></i>
                            <span class="text-lg text-white">123 Education Street<br>Valletta, VLT 1234<br>Malta</span>
                        </div>
                    </div>
                </div>

                <!-- Contact Details -->
                <div class="bg-gradient-to-br from-[#1a1a1a] to-[#2a2a2a] rounded-xl border-2 border-tetra-border hover:border-tetra-green transition-all duration-300 hover:-translate-y-2 hover:shadow-[0_10px_30px_rgba(0,255,136,0.2)] p-10 mb-8">
                    <div class="flex items-center gap-6 pb-6 border-b border-tetra-border">
                        <i class="fas fa-address-book text-4xl text-tetra-green"></i>
                        <div>
                            <h3 class="text-2xl font-semibold text-white">Contact Details</h3>
                        </div>
                    </div>
                    <div class="mt-8 space-y-4">
                        <div class="bg-[rgba(0,255,136,0.1)] p-6 rounded-xl border-l-4 border-tetra-green flex items-start gap-4">
                            <i class="fas fa-phone text-tetra-green text-xl mt-1"></i>
                            <span class="text-lg text-white">+356 2123 4567</span>
                        </div>
                        <div class="bg-[rgba(0,255,136,0.1)] p-6 rounded-xl border-l-4 border-tetra-green flex items-start gap-4">
                            <i class="fas fa-envelope text-tetra-green text-xl mt-1"></i>
                            <span class="text-lg text-white">info@tetra.edu.mt</span>
                        </div>
                    </div>
                </div>

                <!-- Business Hours -->
                <div class="bg-gradient-to-br from-[#1a1a1a] to-[#2a2a2a] rounded-xl border-2 border-tetra-border hover:border-tetra-green transition-all duration-300 hover:-translate-y-2 hover:shadow-[0_10px_30px_rgba(0,255,136,0.2)] p-10 mb-8">
                    <div class="flex items-center gap-6 pb-6 border-b border-tetra-border">
                        <i class="fas fa-clock text-4xl text-tetra-green"></i>
                        <div>
                            <h3 class="text-2xl font-semibold text-white">Business Hours</h3>
                        </div>
                    </div>
                    <div class="mt-8 space-y-4">
                        <div class="bg-[rgba(0,255,136,0.1)] p-6 rounded-xl border-l-4 border-tetra-green flex items-start gap-4">
                            <i class="fas fa-calendar-day text-tetra-green text-xl mt-1"></i>
                            <span class="text-lg text-white">Monday - Friday: 9:00 AM - 5:00 PM</span>
                        </div>
                        <div class="bg-[rgba(0,255,136,0.1)] p-6 rounded-xl border-l-4 border-tetra-green flex items-start gap-4">
                            <i class="fas fa-calendar-xmark text-tetra-green text-xl mt-1"></i>
                            <span class="text-lg text-white">Saturday - Sunday: Closed</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animation for elements with animate-fade-in class
        setTimeout(() => {
            document.querySelectorAll('.animate-fade-in').forEach(el => {
                el.classList.add('opacity-100');
                el.classList.remove('opacity-0', '-translate-y-4');
            });
        }, 100);
    });
</script>

<?php 
include_once '../components/footer.php';
?>