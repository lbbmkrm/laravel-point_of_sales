@props([
    "shopProfile",
    "testimonials",
    "stats",
])

<section
    id="testimonials"
    class="py-20 px-8 bg-gradient-to-br from-gray-50 to-gray-100"
>
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-16">
            <h2
                class="text-4xl md:text-5xl font-Playfair font-bold text-gray-900 mb-4"
            >
                Apa Kata Mereka
            </h2>
            <div class="w-24 h-1 bg-amber-500 mx-auto mb-8"></div>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                Testimoni dari pelanggan setia yang telah merasakan pengalaman
                kopi terbaik di Qio Coffee.
            </p>
        </div>

        <!-- Testimonials Carousel -->
        <div
            x-data="{
                currentSlide: 0,
                testimonials: @js($testimonials->map(
                            fn ($t) => [
                                "name" => $t->client_name,
                                "role" => $t->client_role,
                                "image" => $t->client_image,
                                "rating" => $t->rating,
                                "text" => $t->testimonial_text,
                                "date" => $t->created_at->diffForHumans(),
                            ],
                        )),
                autoplay: null,
                init() {
                    this.startAutoplay()
                },
                startAutoplay() {
                    if (this.testimonials.length > 1) {
                        this.autoplay = setInterval(() => {
                            this.next()
                        }, 5000)
                    }
                },
                stopAutoplay() {
                    clearInterval(this.autoplay)
                },
                next() {
                    if (this.testimonials.length === 0) return
                    this.currentSlide = (this.currentSlide + 1) % this.testimonials.length
                },
                prev() {
                    if (this.testimonials.length === 0) return
                    this.currentSlide =
                        this.currentSlide === 0
                            ? this.testimonials.length - 1
                            : this.currentSlide - 1
                },
                goToSlide(index) {
                    this.currentSlide = index
                },
            }"
            @mouseenter="stopAutoplay()"
            @mouseleave="startAutoplay()"
            class="relative"
        >
            <!-- Main Testimonial Card -->
            <div class="relative overflow-hidden">
                <template
                    x-for="(testimonial, index) in testimonials"
                    :key="index"
                >
                    <div
                        x-show="currentSlide === index"
                        x-transition:enter="transition ease-out duration-500"
                        x-transition:enter-start="opacity-0 transform translate-x-full"
                        x-transition:enter-end="opacity-100 transform translate-x-0"
                        x-transition:leave="transition ease-in duration-500"
                        x-transition:leave-start="opacity-100 transform translate-x-0"
                        x-transition:leave-end="opacity-0 transform -translate-x-full"
                        class="bg-white rounded-2xl shadow-xl p-8 md:p-12"
                    >
                        <!-- Quote Icon -->
                        <div class="flex justify-center mb-6">
                            <div
                                class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center"
                            >
                                <svg
                                    class="w-8 h-8 text-amber-600"
                                    fill="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"
                                    />
                                </svg>
                            </div>
                        </div>

                        <!-- Rating -->
                        <div class="flex justify-center mb-4">
                            <template x-for="star in 5" :key="star">
                                <svg
                                    class="w-5 h-5 text-amber-500"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                                    />
                                </svg>
                            </template>
                        </div>

                        <!-- Testimonial Text -->
                        <p
                            class="text-gray-700 text-lg md:text-xl text-center leading-relaxed mb-8 italic"
                            x-text="testimonial.text"
                        ></p>

                        <!-- Customer Info -->
                        <div class="flex flex-col items-center">
                            <img
                                :src="testimonial.image"
                                :alt="testimonial.name"
                                class="w-20 h-20 rounded-full object-cover mb-4 border-4 border-amber-500"
                            />
                            <h4
                                class="text-xl font-semibold text-gray-900"
                                x-text="testimonial.name"
                            ></h4>
                            <p
                                class="text-amber-600 font-medium mb-1"
                                x-text="testimonial.role"
                            ></p>
                            <p
                                class="text-gray-500 text-sm"
                                x-text="testimonial.date"
                            ></p>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Navigation Arrows -->
            <button
                @click="prev()"
                class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 md:-translate-x-12 w-12 h-12 bg-white hover:bg-amber-600 rounded-full shadow-lg flex items-center justify-center text-gray-800 hover:text-white transition-all duration-300 group"
            >
                <svg
                    class="w-6 h-6"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M15 19l-7-7 7-7"
                    ></path>
                </svg>
            </button>

            <button
                @click="next()"
                class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 md:translate-x-12 w-12 h-12 bg-white hover:bg-amber-600 rounded-full shadow-lg flex items-center justify-center text-gray-800 hover:text-white transition-all duration-300 group"
            >
                <svg
                    class="w-6 h-6"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 5l7 7-7 7"
                    ></path>
                </svg>
            </button>

            <!-- Dots Navigation -->
            <div class="flex justify-center mt-8 space-x-2">
                <template
                    x-for="(testimonial, index) in testimonials"
                    :key="index"
                >
                    <button
                        @click="goToSlide(index)"
                        :class="{ 'bg-amber-600 w-8': currentSlide === index, 'bg-gray-300 w-2': currentSlide !== index }"
                        class="h-2 rounded-full transition-all duration-300 hover:bg-amber-500"
                    ></button>
                </template>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-16">
            <div
                class="text-center p-6 bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300"
            >
                <div class="text-4xl font-bold text-amber-600 mb-2">
                    {{ $stats["google_rating"] }}
                </div>
                <div class="text-gray-600 font-medium">Rating Google</div>
                <div class="flex justify-center mt-2">
                    @for ($i = 0; $i < floor($stats['google_rating']); $i++)
                        <svg
                            class="w-4 h-4 text-amber-500"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                        >
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                            />
                        </svg>
                    @endfor
                </div>
            </div>

            <div
                class="text-center p-6 bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300"
            >
                <div class="text-4xl font-bold text-amber-600 mb-2">
                    {{ $stats["happy_customers"] }}
                </div>
                <div class="text-gray-600 font-medium">Happy Customers</div>
            </div>

            <div
                class="text-center p-6 bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300"
            >
                <div class="text-4xl font-bold text-amber-600 mb-2">
                    {{ $stats["cups_served"] }}
                </div>
                <div class="text-gray-600 font-medium">Cups Served</div>
            </div>

            <div
                class="text-center p-6 bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300"
            >
                <div class="text-4xl font-bold text-amber-600 mb-2">
                    {{ $stats["years_experience"] }}+
                </div>
                <div class="text-gray-600 font-medium">Years Experience</div>
            </div>
        </div>
    </div>
</section>
