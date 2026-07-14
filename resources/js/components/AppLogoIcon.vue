<script setup lang="ts">
import type { HTMLAttributes } from 'vue';

defineOptions({
    inheritAttrs: false,
});

type Props = {
    className?: HTMLAttributes['class'];
};

defineProps<Props>();
</script>

<template>
    <svg
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 100 100"
        :class="className"
        v-bind="$attrs"
    >
        <circle
            cx="50"
            cy="50"
            r="36"
            fill="none"
            stroke="#5c4c34"
            stroke-width="1.6"
            stroke-dasharray="58 8 38 8 20 8"
        />
        <line x1="50" y1="50" x2="50" y2="17" stroke="#ddbb7a" stroke-width="2.2" />
        <line x1="50" y1="50" x2="83" y2="50" stroke="#ddbb7a" stroke-width="2.2" />
        <line x1="50" y1="50" x2="50" y2="83" stroke="#ddbb7a" stroke-width="2.2" />
        <line x1="50" y1="50" x2="17" y2="50" stroke="#ddbb7a" stroke-width="2.2" />
        <path d="M0,-10 L4.5,2 L-4.5,2 Z" fill="#ddbb7a" transform="translate(50,14) rotate(0)" />
        <path d="M0,-10 L4.5,2 L-4.5,2 Z" fill="#ddbb7a" transform="translate(86,50) rotate(90)" />
        <path d="M0,-10 L4.5,2 L-4.5,2 Z" fill="#ddbb7a" transform="translate(50,86) rotate(180)" />
        <path d="M0,-10 L4.5,2 L-4.5,2 Z" fill="#ddbb7a" transform="translate(14,50) rotate(270)" />
        <path d="M0,-7 L3.4,1.5 L-3.4,1.5 Z" fill="#7a6440" transform="translate(75.46,24.54) rotate(45)" />
        <path d="M0,-7 L3.4,1.5 L-3.4,1.5 Z" fill="#7a6440" transform="translate(75.46,75.46) rotate(135)" />
        <path d="M0,-7 L3.4,1.5 L-3.4,1.5 Z" fill="#7a6440" transform="translate(24.54,75.46) rotate(225)" />
        <path d="M0,-7 L3.4,1.5 L-3.4,1.5 Z" fill="#7a6440" transform="translate(24.54,24.54) rotate(315)" />
        <polygon
            points="50,39 57.78,42.22 61,50 57.78,57.78 50,61 42.22,57.78 39,50 42.22,42.22"
            fill="#15110d"
            stroke="#ddbb7a"
            stroke-width="2"
        />
        <path
            d="M50 44.5 L51.3 49 L55 50 L51.3 51 L50 55.5 L48.7 51 L45 50 L48.7 49 Z"
            fill="#ddbb7a"
        />
    </svg>
</template>
