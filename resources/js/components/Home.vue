<script setup lang="ts">
import { reactive, ref } from 'vue'

const jobTitle = ref('')
const companyType = ref('')
import maskotImage from '../../assets/maskot.png';
const handlePrepare = () => {
    // console.log('Preparing interview session...')
    // Navigasi ke halaman chat (opsional)
    window.location.href = '/chat'
}


</script>

<template>
    <div
        class="min-vh-100 d-flex align-items-center justify-content-center bg-gradient-main p-3 p-md-4 p-lg-5 text-center text-md-start">
        <div class="container-lg">
            <div class="row align-items-center justify-content-center">
                <!-- Left Section: Text -->
                <div class="col-12 col-md-6 mb-5 mb-md-0">
                    <h1 class="display-6 fw-bold lh-sm mb-3">
                        <span class="text-dark">Ace Your Interview </span>
                        <span class="text-purple"> Land Your Dream Job</span>
                    </h1>

                    <p class="text-dark fs-6 mb-4">
                        Our AI assistant analyzes your target role, generating unique behavioral questions and real-time
                        improvement tips to guarantee readiness.
                    </p>

                    <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center justify-content-md-start">
                        <button @click="handlePrepare" class="btn btn-lg text-white btn-custom-prepare shadow-sm">
                            Let's Prepare
                        </button>


                    </div>
                </div>

                <!-- Right Section: Image -->
                <div class="col-10 col-md-6 text-center">

                    <img :src="maskotImage" alt="Friendly robot assistant waving hello"
                        class="img-fluid mx-auto d-block hero-img" ref="heroImageRef" @mousemove="handleMouseMove"
                        @mouseenter="handleMouseEnter" @mouseleave="handleMouseLeave" :style="{
                            // ⚠️ Sekarang style binding HANYA untuk efek hover (translasi)
                            transform: isHovering
                                ? `translateX(${imageTransform.translateX}px) translateY(${imageTransform.translateY}px) scale(1.1)`
                                : `scale(1)` // Skala default 1 saat tidak hover
                        }" />

                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* === Background Gradient === */
.text-purple {
    color: #9D70F3;
}

.bg-gradient-main {
    background: linear-gradient(135deg, #ffffff 0%, #bbdef6 44%, #cdb7ea 88%) !important;
    min-height: 100vh;
    overflow-x: hidden;
}

/* === Buttons === */
.btn-custom-prepare {
    background: linear-gradient(90deg, #78A0FF, #C339D9);
    border-radius: 25px;
    min-width: 200px;
    height: 50px;
    transition: transform 0.2s ease-in-out;
}


.btn-custom-prepare:hover,
.btn-custom-send:hover {
    transform: scale(1.05);
}

.btn-custom-prepare:active,
.btn-custom-send:active {
    transform: scale(0.95);
}

/* === Hero Image Responsiveness === */
.hero-img {
    max-width: 100%;
    height: auto;
    transition: transform 0.1s ease-out;
    will-change: transform;

    animation: pulse-zoom 2s ease-in-out infinite alternate;
}

@keyframes pulse-zoom {
    0% {
        transform: scale(1);
    }

    100% {
        transform: scale(1.05);
    }
}

/* === Responsive Fine-Tuning === */
@media (max-width: 768px) {
    h1 {
        font-size: 1.9rem;
    }

    p {
        font-size: 0.95rem;
    }

    .btn-custom-prepare,
    .btn-custom-send {
        min-width: 100%;
        height: 48px;
    }

    .bg-gradient-main {
        text-align: center;
    }
}

@media (min-width: 1200px) {
    h1 {
        font-size: 2.6rem;
    }
}
</style>
