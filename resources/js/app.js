import './bootstrap';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

const header = document.querySelector('[data-site-header]');
const menuToggle = document.querySelector('[data-menu-toggle]');
const mobileMenu = document.querySelector('[data-mobile-menu]');

let lastScrollY = window.scrollY;
let scrollTicking = false;

const updateHeader = () => {
    if (!header) return;

    const currentScrollY = Math.max(window.scrollY, 0);
    const menuOpen = menuToggle?.getAttribute('aria-expanded') === 'true';
    const scrollingDown = currentScrollY > lastScrollY;

    header.classList.toggle('is-scrolled', currentScrollY > 24);
    header.classList.toggle('is-collapsed', currentScrollY > 140 && scrollingDown && !menuOpen);

    if (currentScrollY < 70 || !scrollingDown) {
        header.classList.remove('is-collapsed');
    }

    lastScrollY = currentScrollY;
    scrollTicking = false;
};

updateHeader();
window.addEventListener('scroll', () => {
    if (scrollTicking) return;
    scrollTicking = true;
    window.requestAnimationFrame(updateHeader);
}, { passive: true });

menuToggle?.addEventListener('click', () => {
    const open = menuToggle.getAttribute('aria-expanded') === 'true';
    menuToggle.setAttribute('aria-expanded', String(!open));
    mobileMenu.hidden = open;
    header?.classList.remove('is-collapsed');
});

if (!reduceMotion) {
    gsap.from('.hero-background', { scale: 1.13, duration: 1.8, ease: 'power2.out' });
    gsap.from('.hero-animate', { y: 34, opacity: 0, duration: .9, stagger: .11, delay: .16, ease: 'power3.out' });

    gsap.utils.toArray('.reveal').forEach((element) => {
        gsap.from(element, {
            y: 42,
            opacity: 0,
            duration: .8,
            ease: 'power3.out',
            scrollTrigger: { trigger: element, start: 'top 88%', once: true },
        });
    });
}

const imageTimers = new WeakMap();

function activateRotatingMedia(root = document) {
    root.querySelectorAll('[data-product-card]:not([data-rotation-ready]), [data-rotating-media]:not([data-rotation-ready])').forEach((container) => {
        container.dataset.rotationReady = 'true';
        const image = container.querySelector('[data-product-image], [data-rotating-image]');
        const images = JSON.parse(container.dataset.images || '[]');
        const interval = Number(container.dataset.interval || 2000);

        if (!image || images.length < 2 || reduceMotion) return;

        let index = 0;
        const start = () => {
            if (imageTimers.has(container)) return;
            const timer = window.setInterval(() => {
                index = (index + 1) % images.length;
                image.classList.add('is-changing');
                window.setTimeout(() => {
                    image.src = images[index];
                    image.classList.remove('is-changing');
                }, 180);
            }, interval);
            imageTimers.set(container, timer);
        };
        const stop = () => {
            const timer = imageTimers.get(container);
            if (timer) window.clearInterval(timer);
            imageTimers.delete(container);
        };

        const visibility = new IntersectionObserver(([entry]) => entry.isIntersecting ? start() : stop(), { rootMargin: '120px' });
        visibility.observe(container);
    });
}

activateRotatingMedia();

document.querySelectorAll('[data-product-detail-gallery]').forEach((gallery) => {
    const main = gallery.querySelector('[data-gallery-main]');
    const thumbs = [...gallery.querySelectorAll('[data-gallery-thumb]')];
    const images = JSON.parse(gallery.dataset.galleryImages || '[]');
    let index = 0;
    let timer;

    if (!main || !images.length) return;

    const showImage = (nextIndex) => {
        index = nextIndex;
        main.classList.add('is-changing');
        window.setTimeout(() => {
            main.src = images[index].src;
            main.alt = images[index].alt;
            main.classList.remove('is-changing');
        }, 160);

        thumbs.forEach((thumb) => thumb.classList.toggle('is-active', Number(thumb.dataset.galleryIndex) === index));
        thumbs[index]?.scrollIntoView({ behavior: reduceMotion ? 'auto' : 'smooth', block: 'nearest', inline: 'center' });
    };

    const stop = () => {
        if (timer) window.clearInterval(timer);
        timer = null;
    };
    const start = () => {
        if (reduceMotion || images.length < 2 || timer) return;
        timer = window.setInterval(() => showImage((index + 1) % images.length), 2000);
    };

    thumbs.forEach((thumb) => {
        thumb.addEventListener('click', () => {
            showImage(Number(thumb.dataset.galleryIndex));
            stop();
            start();
        });
    });

    const visibility = new IntersectionObserver(([entry]) => entry.isIntersecting ? start() : stop(), { rootMargin: '80px' });
    visibility.observe(gallery);
});

document.addEventListener('submit', async (event) => {
    const form = event.target.closest('[data-ajax-cart]');
    if (!form) return;

    event.preventDefault();
    const button = form.querySelector('button[type="submit"]');
    const label = button?.querySelector('[data-button-label]');
    if (!button || button.disabled || button.dataset.loading === 'true') return;

    const originalLabel = label?.textContent || 'Add to Cart';
    button.dataset.loading = 'true';
    button.disabled = true;
    button.classList.remove('is-success', 'is-error');
    if (label) label.textContent = 'Adding…';

    try {
        const response = await fetch(form.action, {
            method: 'POST',
            body: new FormData(form),
            headers: { Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
        });
        const data = await response.json();

        if (!response.ok) {
            throw new Error(data.message || 'Could not add product');
        }

        document.querySelectorAll('.cart-count').forEach((count) => {
            count.textContent = data.cart_count;
            count.classList.add('is-bumping');
            window.setTimeout(() => count.classList.remove('is-bumping'), 400);
        });

        button.classList.add('is-success');
        if (label) label.textContent = `Added (${data.item_quantity})`;
        window.setTimeout(() => {
            button.classList.remove('is-success');
            if (label) label.textContent = originalLabel;
        }, 1500);
    } catch (error) {
        button.classList.add('is-error');
        if (label) label.textContent = 'Try again';
        window.setTimeout(() => {
            button.classList.remove('is-error');
            if (label) label.textContent = originalLabel;
        }, 1800);
    } finally {
        button.dataset.loading = 'false';
        button.disabled = false;
    }
});

const grid = document.querySelector('[data-product-grid]');
const loader = document.querySelector('[data-product-loader]');

if (grid && loader) {
    let loading = false;
    const observer = new IntersectionObserver(async ([entry]) => {
        if (!entry.isIntersecting || loading || !loader.dataset.nextUrl) return;

        loading = true;
        loader.classList.add('is-loading');

        try {
            const response = await fetch(loader.dataset.nextUrl, {
                headers: { Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            });
            if (!response.ok) throw new Error('Product request failed');

            const data = await response.json();
            const fragment = document.createRange().createContextualFragment(data.html);
            const cards = [...fragment.querySelectorAll('[data-product-card]')];
            grid.append(fragment);
            activateRotatingMedia(grid);

            if (!reduceMotion && cards.length) {
                gsap.from(cards, { y: 28, opacity: 0, duration: .55, stagger: .07, ease: 'power2.out' });
            }

            loader.dataset.nextUrl = data.next_page_url || '';
            if (!data.next_page_url) {
                observer.disconnect();
                loader.innerHTML = '<span>You have reached the end of our current collection.</span>';
                loader.classList.add('product-end');
            }
        } catch (error) {
            loader.querySelector('[data-loader-text]').textContent = 'Could not load products. Scroll away and try again.';
        } finally {
            loading = false;
            loader.classList.remove('is-loading');
        }
    }, { rootMargin: '300px 0px' });

    observer.observe(loader);
}
